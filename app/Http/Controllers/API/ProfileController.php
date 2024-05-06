<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Profile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function profile (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'address' => 'sometimes',
            'city_id' => 'sometimes|string|max:255',
            'province' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|max:255',
            'city_name' => 'sometimes|string|max:255',
            'postal_code' => 'sometimes|string|max:255',
        ]);


        if($validator->fails()) {
            return ResponseFormmater::error(
                null,
                $validator->errors(),
                500
            );
        }

        $profile = Profile::create([
            'user_id' => $request->user_id,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'province' => $request->province,
            'type' => $request->type,
            'city_name' => $request->city_name,
            'postal_code' => $request->postal_code,
        ]);


        try {
            $profile->save();
            return ResponseFormmater::success(
                $profile,
                'Data Profile  Berhasil di tambahkan'
            );
        }

        catch(Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Data profile  tidak ada',
                404
            );
        }
    }

    public function editProfile (Request $request , $id)
    {
        $profile = Profile::findOrFail($id);
        $data = $request->all();

        $profile->update($data);
        return ResponseFormmater::success(
            $profile,
            'Data Profile Berhasil di update'
        );
    }
}
