<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Email;
use App\Models\EmailFolder;
use App\Models\UserEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EmailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $folderId)
    {
        ////FIXME FIX FOLDER PART
        $id = $request->user()->id;
        $emails = Email::with('sender', 'recipient', 'attachments', 'statuses','emailFolder','emailUsers' ,'emailUsers.users')
            ->whereHas('emailFolder', function ($q) use ($folderId, $id) {
             $q->where(['folder_id' => (int)$folderId, 'user_id' => $id]);
        })->get();
        return response()->json($emails);
    }

    public function getCount(Request $request)
    {
        $id = $request->user()->id;

        /// $emails =  DB::table('emails')->distinct('folder_id')->count('folder_id');
        $emails = DB::select("SELECT folder_id as id, count(folder_id) count FROM email_folders where user_id = $id GROUP BY folder_id");

        ///$emails = Email::select('folder_id')->count();
        return response()->json($emails);
    }
    public function emailUsers(Request $request)
    {
//        $id = $request->user()->id;
//        ////FIXME FIX FOLDER PART
//        /// $emails =  DB::table('emails')->distinct('folder_id')->count('folder_id');
//        $emails = UserEmail::where('user_id', $id)->get();
//
//        ///$emails = Email::select('folder_id')->count();
//        return response()->json($emails);
    }

    public function show($id)
    {
        $email = Email::with('sender', 'recipient', 'attachments', 'statuses')->findOrFail($id);
        return response()->json($email);
    }

    public function store(Request $request)
    {

        $userId = $request->user()->id;
        $this->validate($request, [
//            'sender_id' => 'required',
//            'recipient_id' => 'number',
//            'subject' => 'required',
            /// 'body' => 'required',
        ]);
        $email = new Email();
        $email->sender_id = $userId;
        $email->owner_id = $userId;

        if ($email->save()) {
            $emailFolder = new EmailFolder();
            $emailFolder->user_id = $userId;
            $emailFolder->folder_id = 2;
            $emailFolder->email_id = $email->id;

            if (!$emailFolder->save()) {
                return response()->json([
                    'success' => '0',
                    'type' => 'forbidden',
                ], 403);
            }

            $userEmail = new UserEmail();
            $userEmail->user_id = $userId;
            $userEmail->email_id = $email->id;
            $userEmail->user_status = 1;

            if (!$userEmail->save()) {
                return response()->json([
                    'success' => '0',
                    'type' => 'forbidden',
                ], 403);
            }
            $file = $request->file('pdf');
          ///  $value = file_get_contents($request->file('pdf'));
            $storagePath =   Storage::put("public/documents/$email->id", $file);
            $storageName = basename($storagePath);

            $attachment = new Attachment();
            $attachment->email_id = $email->id;
            $attachment->file_name = $storageName;
            $attachment->file_content = $file;
//            $url = Storage::url("documents/$email->id");
//            dd($url);

            if (!$attachment->save()) {
                return response()->json([
                    'success' => '0',
                    'type' => 'forbidden',
                ], 403);
            }

            return response()->json($email, 201);
        } else {
            return response()->json([
                'success' => '0',
                'type' => 'forbidden',
            ], 403);
        }

    }

    public function changeFolder(Request $request, $id, $docId): \Illuminate\Http\JsonResponse
    {
        $userId = $request->user()->id;
        $email = EmailFolder::where(['email_id'=> $id, 'user_id'=>$userId])->update(['folder_id'=>$docId]);
//        $email->folder_id = $docId;
//        $email->update();
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


    public function test(){

    }
}
