<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterKeywords = $request->get('keyword');
        $filterRole = $request->get('role');
        $data['currentPage'] = 'users.index';

        $query = User::query();

        if($filterKeywords) {
            $query->where('email', 'like', '%' . $filterKeywords . '%');
        }


        if ($filterRole) {
            $query->where('role', $filterRole);
        }

        $data['user'] = $query->paginate(10);
        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['user'] = User::findOrFail($id);
        return view('user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $dataUser = User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255',
            'password' => 'sometimes|string|min:6|confirmed',
            'avatar' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'phone' => 'sometimes|string|max:255',
            'role' => 'sometimes|string|max:255'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $existingData = User::where('email', $request->email)->where('id', '!=', $id)->first();

        if($existingData) {
            return redirect()->back()->with('failed', 'No email sudah dimiliki orang lain');
        }

        $input = $request->all();



        if($request->hasFile('avatar')) {

            if($request->file('avatar')->isValid()) {
                Storage::disk('upload')->delete($dataUser->avatar);
                $avatar = $request->file('avatar');
                $extensions = $avatar->getClientOriginalExtension();
                $userAvatar = "user/".date('YmdHis').".".$extensions;
                $uploadPath = \env('UPLOAD_PATH'). "/user";
                $request->file('avatar')->move($uploadPath, $userAvatar);
                $input['avatar'] = $userAvatar;
            }
        }

        if($request->input('new_password')) {

            $input['password'] = Hash::make($input['new_password']);

        } else {

            $input = Arr::except($input,['password']);
        }

        $dataUser->update($input);
        return redirect()->route('user.index')->with('status', 'Users Successfully Update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataUser = User::findOrFail($id);
        $input = Storage::disk('upload')->delete($dataUser->avatar);
        $dataUser->delete($input);
        return redirect()->back()->with('status', 'Users Successfully Deleted');
    }
}
