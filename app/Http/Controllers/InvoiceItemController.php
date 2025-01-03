<?php

namespace App\Http\Controllers;

use App\Models\InvoiceItem;
use App\Http\Controllers\Controller;
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
            $imagick->readImage($tempPdfPath);
            $imagick->setImageFormat('jpg');
            $pngContent = $imagick->getImageBlob();

            unlink($tempPdfPath);

            return response($pngContent, 200, [
                'Content-Type' => 'image/jpg',
                'Content-Disposition' => 'attachment; filename="invoice.jpg"',
            ]);
        } catch (Exception $ex) {
            error_log($ex);
            return back()->withErrors("Download Fail");
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

            DB::commit();
            return back()->withErrors("Insert Completed");
        } catch (\Exception $ex) {
            DB::rollBack();

            return back()->withErrors("Insert Error: " . $ex->getMessage());
        }
    }
}
