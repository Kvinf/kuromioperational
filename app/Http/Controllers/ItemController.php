<?php

namespace App\Http\Controllers;

use App\Models\item;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ItemController extends Controller
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
    public function show(item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(item $item)
    {
        //
    }

    public function addItem (Request $request)
    {

        try
        {
            $validateData = $request->validate([
                'name' => 'required',
                'price' => 'required',
            ]);

            DB::beginTransaction();

            item::create([
                'name' => $validateData["name"],
                'price' =>  $validateData["price"]
            ]);

            DB::commit();

            return back()->withErrors("Insert Completed");

        }
        catch (Exception $ex)
        {
            DB::rollBack();
            return back()->withErrors("Insert Error" + $ex->getMessage());

        }

    }
}
