<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use App\Http\Controllers\Controller;
use App\Models\phoneCredential;
use App\Models\receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Imagick;



class InvoiceItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InvoiceItem $invoiceItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InvoiceItem $invoiceItem)
    {
        //
    }

    public function generateReceiptPNG(Request $request)
    {
        $transaction = receipt::where("id", $request->id)->first();

        $items = InvoiceItem::where("invoiceId", $transaction->id)->get();

        error_log(Carbon::parse($transaction->created_at)->format('d F Y'));

        $data = [
            'transactionId' => $transaction->invoiceNumber,
            'customerName' => $transaction->customerName,
            'customerPhone' => $transaction->customerPhone,
            'date' => Carbon::parse($transaction->created_at)->format('d F Y'),
            'items' => $items,
            'total' => $transaction->totalPrice,
            'date' => now()->toFormattedDateString(),
        ];

        $pdf = Pdf::loadView('invoice', $data)
            ->setPaper('a4', 'portrait')
            ->setOption('isHtml5ParserEnabled', true)
            ->setOption('isRemoteEnabled', true);

        return $pdf->stream('invoice.pdf');
    }


    public function generateReceiptPDF(Request $request)
    {
        try {
            set_time_limit(300);

            $transaction = receipt::where("id", $request->id)->first();

            $items = InvoiceItem::where("invoiceId", $transaction->id)->get();

            error_log(Carbon::parse($transaction->created_at)->format('d F Y'));

            $data = [
                'transactionId' => $transaction->invoiceNumber,
                'customerName' => $transaction->customerName,
                'customerPhone' => $transaction->customerPhone,
                'date' => Carbon::parse($transaction->created_at)->format('d F Y'),
                'items' => $items,
                'total' => $transaction->totalPrice,
                'date' => now()->toFormattedDateString(),
            ];

            $pdfContent = Pdf::loadView('invoice', $data)
                ->setPaper('a4', 'portrait')
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->output();

            // Save and process image
            $tempPdfPath = storage_path('app/temp_invoice.pdf');
            file_put_contents($tempPdfPath, $pdfContent);
            $imagick = new Imagick();

            // Set high resolution (DPI) for rendering
            $imagick->setResolution(600, 600); // High DPI for better rendering quality

            // Read the PDF
            $imagick->readImage($tempPdfPath);

            // Set image format and quality
            $imagick->setImageFormat('jpg');
            $imagick->setImageCompression(Imagick::COMPRESSION_JPEG);
            $imagick->setImageCompressionQuality(100); // Maximum quality

            // Resize to 4K A4 dimensions (3840x2715 pixels)
            $imagick->resizeImage(1448, 2048, Imagick::FILTER_LANCZOS, 1); // Maintain quality with Lanczos filter

            // Generate the final image blob
            $pngContent = $imagick->getImageBlob();

            // Cleanup
            $imagick->clear();
            $imagick->destroy();

            // Return the image response
            return response($pngContent, 200, [
                'Content-Type' => 'image/jpg',
                'Content-Disposition' => 'attachment; filename="invoice_4k_a4.jpg"',
            ]);
        } catch (Exception $ex) {
            error_log($ex);
            return back()->withErrors("Download Fail");
        }
    }

    public function editInvoice(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'id' => 'required',
                'item' => 'required|array',
                'item.*' => 'exists:items,id',
                'qty' => 'required|array',
                'qty.*' => 'integer|min:1',
                'customerName' => 'required',
                'customerPhone' => 'required',
            ]);


            $invoiceItem = receipt::where("id", $request->id)->first();


            if ($invoiceItem) {

                InvoiceItem::where("invoiceId", $invoiceItem->id)->delete();
                $totalPrice = 0;

                foreach ($request->item as $index => $itemId) {

                    $quantity = $request->qty[$index];
                    $price = $request->price[$index];
                    $name = $request->name[$index];
                    $piece = $request->pricePiece[$index];

                    $totalPrice += $price;

                    InvoiceItem::create([
                        'invoiceId' => $invoiceItem->id,
                        'itemPrice' => $price,
                        'itemName' => $name,
                        'itemQty' => $quantity,
                        'itemId' => $itemId,
                        'itemPricePiece' => $piece
                    ]);

                    $invoiceItem->totalPrice = $totalPrice;
                    $invoiceItem->save();
                }

                $customerPhone = phoneCredential::where("customerPhone",$request->customerPhone)->first();


                if (!$customerPhone)
                {
                    phoneCredential::create([
                        'customerName' => $request->customerName,
                        'customerPhone' => $request->customerPhone,
                    ]);
                }
            }



            DB::commit();
            return back()->withErrors("Update Completed");
        } catch (\Exception $ex) {
            DB::rollBack();

            return back()->withErrors("Update Error: " . $ex->getMessage());
        }
    }


    public function deleteInvoice(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
               'id' => 'required'
            ]);

            $invoice = receipt::where("id",$request->id)->first();

            if ($invoice) 
            {
                receipt::where("id",$request->id)->delete();
            }

            DB::commit();
            return back()->withErrors("Delete Completed");
        } catch (\Exception $ex) {
            DB::rollBack();

            return back()->withErrors("Delete Error: " . $ex->getMessage());
        }
    }

    public function addInvoice(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'item' => 'required|array',
                'item.*' => 'exists:items,id',
                'qty' => 'required|array',
                'qty.*' => 'integer|min:1',
                'customerName' => 'required',
                'customerPhone' => 'required',
            ]);

            $invoiceItem = receipt::create([
                'InvoiceName' => "-",
                'customerName' => $request->customerName,
                'customerPhone' => $request->customerPhone,
                'totalPrice' => 0
            ]);

            $totalPrice = 0;

            foreach ($request->item as $index => $itemId) {
                $quantity = $request->qty[$index];
                $price = $request->price[$index];
                $name = $request->name[$index];
                $piece = $request->pricePiece[$index];

                $totalPrice += $price;

                InvoiceItem::create([
                    'invoiceId' => $invoiceItem->id,
                    'itemPrice' => $price,
                    'itemName' => $name,
                    'itemQty' => $quantity,
                    'itemId' => $itemId,
                    'itemPricePiece' => $piece
                ]);
            }

            $invoiceItem->totalPrice = $totalPrice;

            $invoiceItem->save();

            $customerPhone = phoneCredential::where("customerPhone",$request->customerPhone)->first();

            if (!$customerPhone)
            {
                phoneCredential::create([
                    'customerName' => $request->customerName,
                    'customerPhone' => $request->customerPhone,
                ]);
            }

            DB::commit();
            return back()->withErrors("Insert Completed");
        } catch (\Exception $ex) {
            DB::rollBack();

            return back()->withErrors("Insert Error: " . $ex->getMessage());
        }
    }
}
