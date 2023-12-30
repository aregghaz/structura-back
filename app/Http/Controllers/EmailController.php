<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $folderId)
    {
        $id = $request->user()->id;
        $emails = Email::with('sender', 'recipient', 'attachments', 'statuses')->where([
            'owner_id' => $id,
            'folder_id' => (int)$folderId,
        ])->get();
        return response()->json($emails);
    }

    public function getCount()
    {
        /// $emails =  DB::table('emails')->distinct('folder_id')->count('folder_id');
        $emails = DB::select("SELECT folder_id as id, count(folder_id) count FROM emails GROUP BY folder_id");

        ///$emails = Email::select('folder_id')->count();
        return response()->json($emails);
    }

    public function show($id)
    {
        $email = Email::with('sender', 'recipient', 'attachments', 'statuses')->findOrFail($id);
        return response()->json($email);
    }

    public function store(Request $request)
    {

        $this->validate($request, [
//            'sender_id' => 'required',
//            'recipient_id' => 'number',
//            'subject' => 'required',
            /// 'body' => 'required',
        ]);
        $email = new Email();

        $email->sender_id = $request->user()->id;
        $email->owner_id = $request->user()->id;
        $email->recipient_id = $request->user()->id;
        $email->subject = 'new Document';
        $email->body = 'new Document';
        $email->folder_id = $request->folderId;
        if ($email->save()) {
            $file = $request->file('pdf');
            $attachment = new Attachment();
            $attachment->email_id = $email->id;
            $attachment->file_name = $request->file('pdf')->getClientOriginalName();
            $attachment->file_content = $file;
            $attachment->save();
            return response()->json($email, 201);
        } else {
            return response()->json('error', 500);
        }

    }

    public function changeFolder(Request $request): \Illuminate\Http\JsonResponse
    {
        $email = Email::findOrFail($request->id);
        $email->folder_id = $request->folderId;
        $email->update();
        return response()->json($email, 201);
    }

    public function saveFile(Request $request): \Illuminate\Http\JsonResponse
    {
        if ($request->file('pdf')) {
            $file = $request->file('pdf');
            $attachment = new Attachment();
            $attachment->email_id = $request->id;
            $attachment->file_name = $request->file('pdf')->getClientOriginalName();
            $attachment->file_content = $file;
            if ($attachment->save()) {
                return response()->json($attachment, 201);
            } else {
                return response()->json('error', 500);
            }
        } else {
            return response()->json('error', 500);
        }

    }
}
