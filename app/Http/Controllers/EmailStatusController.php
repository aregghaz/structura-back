<?php

namespace App\Http\Controllers;

use App\Models\EmailStatus;
use Illuminate\Http\Request;

class EmailStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $emailStatuses = EmailStatus::all();
        return response()->json($emailStatuses);
    }

    public function show($id)
    {
        $emailStatus = EmailStatus::findOrFail($id);
        return response()->json($emailStatus);
    }
}
