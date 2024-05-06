<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'phone' => 'sometimes',
                'role' => 'sometimes'
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'role' => $request->role,
            ]);

            $user = User::where('email', $request->email)->first();
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormmater::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Register Success');
        }

        catch(Exception $error) {
            return ResponseFormmater::error([
                'message' => 'Register Failed',
                'error' => $error
            ], 'Register Failed', 404);
        }
    }

    public function login (Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);

            $crendetials = request(['email', 'password']);

            if(!Auth::attempt($crendetials)) {
                return ResponseFormmater::error([
                    'message' => 'Unauthorized'
                ], 'Unauthorized Failed', 404);
            }

            $user = User::where('email', $request->email)->first();

            if(!Hash::check($request->password, $user->password, [])) {
                throw new Exception('password is incorrect');
            }

            $tokenResult = $user->createToken('authToken')->plainTextToken;
            return ResponseFormmater::success([
                'access_token' =>  $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 'Login Success');
        }

        catch(Exception $error) {
            return ResponseFormmater::error([
                'message' => 'Login Failed',
                'error' => $error
            ], 'Login Failed', 404);
        }
    }

    public function updated (Request $request , $id)
    {
        $user = User::findOrFail($id);

        $existingData = User::where('email', $request->email)->where('id', '!=', $id)->first();

        if($existingData) {
            return ResponseFormmater::error(
                null,
                'Email sudah dimiliki orang lain',
                505
            );
        }

        $data = $request->all();

        if($request->hasFile('avatar')) {

            if($request->file('avatar')->isValid()) {
                Storage::disk('upload')->delete($user->avatar);
                $avatar = $request->file('avatar');
                $extensions = $avatar->getClientOriginalExtension();
                $userAvatar = "user/".date('YmdHis').".".$extensions;
                $uploadPath = \env('UPLOAD_PATH'). "/user";
                $request->file('avatar')->move($uploadPath, $userAvatar);
                $data['avatar'] = $userAvatar;
            }
        }

        if($request->input('password')) {

            $data['password'] = Hash::make($data['password']);

        } else {

            $data = Arr::except($data,['password']);
        }

        $user->update($data);
        return ResponseFormmater::success(
            $user,
            'Data User berhasil diupdate'
        );
    }

    public function delete (Request $request , $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return ResponseFormmater::success(
            $user,
            'Data User Berhasil di delete'
        );
    }

    public function user (Request $request)
    {
        $id = $request->input('id');
        $name = $request->input('name');
        $role = $request->input('role');
        $profile_id = $request->input('profile_id');

        if($id) {
            $user = User::with(['profiles'])->find($id);

            if($user) {
                return ResponseFormmater::success(
                    $user,
                    'Data User berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'User tidak ada',
                    404
                );
            }
        }


        $user = User::with(['profiles']);

        if($name) {
            $user->where('name', 'LIKE', '%' . $name . '%');
        }


        if($role) {
            $user->where('role', 'LIKE', '%' . $role . '%');
        }

        if($profile_id)
        {
            $user->where('profile_id', $profile_id);
        }


        return ResponseFormmater::success(
            $user->get(),
            'List User Berhasil diambil'
        );
    }
}
