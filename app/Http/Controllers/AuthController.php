<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function registration(Request $request)
    {
////FIXME
//        $validator = Validator::make($request->all(), [
//            'name' => 'required|string',
//            'surname' => 'string',
//            'phone_number' => 'required|string',
//            'email' => 'required|string|email|unique:users',
//            ///'password' => 'required|string|confirmed',
//            'birthday' => 'string',
//            'address' => 'required|string',
//            'state' => 'required|string',
//        ]);
//        if ($validator->fails()) {
//            return response()->json(['success' => 0, 'type' => 'validation_filed', 'error' => $validator->messages()], 422);
//        }
        $user = new User();
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->fatherName = $request->fatherName;
        $user->country = $request->country;
        $user->dob = $request->dob;
        $user->email = $request->email;
        $user->passport = $request->password;
        $user->password = bcrypt('admin');
        $user->status = 1;
        $user->save();
        if (!$user->save()) {
            return response()->json([
                'success' => '0',
                'type' => 'forbidden',
            ], 403);
        }
//        $user->notify(
//            new UserCreateNotification($user)
//        );
        return response()->json([
            'success' => '1',
            'type' => 'success',
        ], 201);


//    return this->usersRepository->save(user);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean',
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me) {
            $token->expires_at = Carbon::now()->addWeeks(1);
        }
        $token->save();
        return response()->json([
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
        ]);
    }

    public function user(Request $request)
    {
        $userId = $request->user()->id;
        $user = User::find($userId);

        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
        ];


        return response()->json($data);
    }
}
