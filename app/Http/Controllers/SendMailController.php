<?php

namespace App\Http\Controllers;

use App\Models\EmailFolder;
use App\Models\User;
use App\Models\UserEmail;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    public function index(Request $request)
    {
//        $content = [
//            'subject' => 'This is the mail subject',
//            'body' => 'This is the email body of how to send email from laravel 10 with mailtrap.'
//        ];
//
//        Mail::to($request->email)->send(new SampleMail($content));
        $user = User::where('email', $request->email)->limit(1)->get();

        if (count($user) === 0) {
            $user = new User();
            $user->email = $request->email;
            $user->password = bcrypt('admin');
            if (!$user->save()) {
                return response()->json([
                    'success' => '0',
                    'type' => 'forbidden',
                ], 403);
            }

        }else{
            $user = $user[0];
        }

        $userEmail = new UserEmail();
        $userEmail->user_id = $user->id;
        $userEmail->email_id = $request->docId;
        $userEmail->user_status = $request->userType;
        if (!$userEmail->save()) {
            return response()->json([
                'success' => '0',
                'type' => 'forbidden',
            ], 403);
        }
        $emailFolder = new EmailFolder();
        $emailFolder->email_id =  $request->docId;
        $emailFolder->user_id =  $user->id;
        $emailFolder->folder_id = 10;
        if (!$emailFolder->save()) {
            return response()->json([
                'success' => '0',
                'type' => 'forbidden',
            ], 403);
        }
        //        $user->notify(
//            new UserCreateNotification($user)
//        );
        return response()->json([
            'userEmail' => $userEmail,
            'user' => $user,
            'success' => '1',
            'type' => 'success',
        ], 201);


    }
}
