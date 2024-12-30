<?php

namespace App\Http\Controllers;

use App\Models\MsUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MsUserController extends Controller
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
    public function show(MsUser $msUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MsUser $msUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MsUser $msUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MsUser $msUser)
    {
        //
    }

    public function login(Request $request)
    {

        try {
            $validateData = $request->validate([
                'email' => 'required',
                'password' => 'required|min:6',
            ]);

            $credentials = $request->only('email', 'password');


            if (Auth::attempt($credentials)) {
                
                $user = Auth::user();

                if ($user->verified) {
                    error_log("success");
                    return redirect()->route("dashboard");
                } 
            } else {
                error_log("Invalid credentials attempt for email: {$validateData['email']}");
                return redirect()->route('login')->withErrors('Invalid credentials.');
            }
        } catch (\Exception $ex) {
            error_log($ex->getMessage());
            return redirect()->route('login')->withErrors('An error occurred: ' . $ex->getMessage());
        }
    }
}
