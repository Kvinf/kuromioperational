<?php

namespace App\Http\Controllers;

use App\Models\phoneCredential;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Svg\Tag\Rect;

class PhoneCredentialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function searchPhone(Request $request) 
    {
        $customer = phoneCredential::where('customerPhone', $request->phone)->first();

        if ($customer) {
            return response()->json([
                'success' => true,
                'customer' => [
                    'name' => $customer->customerName
                ]
            ]);
        }

        return response()->json(['success' => false, 'message' => 'Customer not found'], 404);
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
    public function show(phoneCredential $phoneCredential)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(phoneCredential $phoneCredential)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, phoneCredential $phoneCredential)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(phoneCredential $phoneCredential)
    {
        //
    }
    
}
