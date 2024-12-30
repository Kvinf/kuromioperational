<?php

use App\Http\Controllers\InvoiceItemController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MsUserController;
use Illuminate\Support\Facades\Route;
use App\Models\item;
use App\Models\receipt;
use Illuminate\Support\Facades\Auth;


Route::middleware("auth")->group(function() {
    Route::get('/', function () {
        return view('applayout');
    })->name("dashboard");

    Route::get('/item',function () {
        $item = item::get();
        return view('itemmanagement')->with('items',$item);
    })->name("itemview");

    Route::get('/addinvoice',function() {
        $item = item::get();
        return view("invoiceadd")->with('items',$item);
    })->name("addinvoice");

    Route::get('/invoice',function()
    {
        $item = receipt::get();
        return view("receiptmanagement")->with('items',$item);
    })->name("invoiceview");

    Route::post("/additem",[ItemController::class,'addItem'])->name("addItem");

    Route::post("/addItemInvoice",[InvoiceItemController::class,'addInvoice'])->name("addInvoiceItem");
    Route::get('/receipt/pdf/{id}', [InvoiceItemController::class, 'generateReceiptPdf'])->name("downloadInvoice");

});

Route::get('/logout',function(){
    Auth::logout();
    return redirect()->route("login");
})->name("logout");

Route::get('/login', function () {
    return view('login');
})->name("login");

Route::post('login',[MsUserController::class,'login'])->name("loginPost");