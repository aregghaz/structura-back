<?php

namespace App\Http\Controllers;

use App\Models\UserEmail;
use Illuminate\Http\Request;

class UserEmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $info = UserEmail::where('email_id', $request->docId)->with('users')->get();
        return response()->json($info);
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
    public function show(UserEmail $userEmail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserEmail $userEmail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserEmail $userEmail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserEmail $userEmail)
    {
        //
    }
}
