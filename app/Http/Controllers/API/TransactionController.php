<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormmater;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Midtrans\Config;
use Midtrans\Snap;

class TransactionController extends Controller
{
    public function checkout (Request $request)
    {
        $validator =  Validator::make($request->all(), [
            'user_id' => 'sometimes|exists:users,id',
            'total_transaction' => 'sometimes|integer',
            'courier' => 'required|string|max:255',
            'service' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'cost' => '',
            'estimated' => '',
            'status_transaction' => '',
            'payment_type' => '',
            'order_id' => '',
            'token_payment' => 'sometimes',
            'cart_ids' => 'required|array',
            'cart_ids.*' => 'exists:carts,id',
        ]);


        if($validator->fails()) {
            return ResponseFormmater::error(
                null,
                $validator->errors(),
                500
            );
        }

        $transaction = Transaction::create([
            'user_id' => $request->user_id,
            'total_transaction' => $request->total_transaction,
            'courier' => $request->courier,
            'service' => $request->service,
            'description' => $request->description,
            'cost' => $request->cost,
            'estimated' => $request->estimated,
            'status_transaction' => $request->status_transaction,
            'payment_type' => $request->payment_type,
            'order_id' => $request->order_id,
            'token_payment' => $request->token_payment
        ]);

        $transaction->carts()->attach($request->cart_ids);

        // Konfigurasi Midtrans
        Config::$serverKey = config('services.midtrans.serverKey');
        Config::$isProduction = config('services.midtrans.isProduction');
        Config::$isSanitized = config('services.midtrans.isSanitized');
        Config::$is3ds = config('services.midtrans.is3ds');

        $transaction = Transaction::find($transaction->id);

        $timestamp = now()->format('YmdHis');
        $orderId = $transaction->id . '_' . $timestamp;

        $transaction->order_id = $orderId;
        $transaction->save();

        // Midtrans Snap
        $midtrans = array(
            'transaction_details' => array(
                'order_id' => $orderId,
                'gross_amount' => $transaction->total_transaction,
            ),
        );

        if ($transaction->users) {
            $midtrans['customer_details'] = array(
                'first_name' => $transaction->users->name,
                'email' => $transaction->users->email
            );
        }

        try {
            $snapToken = Snap::getSnapToken($midtrans);
            $transaction->token_payment = $snapToken;
            $transaction->save();

            return ResponseFormmater::success(
                $transaction->load('carts'),
                'Data Transaction Berhasil di tambahkan'
            );
        } catch (Exception $error) {
            return ResponseFormmater::error(
                $error->getMessage(),
                'Data Transaction tidak ada',
                404
            );
        }
    }

    public function updateCheckout(Request $request , $id)
    {
        $transaction = Transaction::findOrFail($id);
        $data = $request->all();

        $transaction->update($data);
        return ResponseFormmater::success(
            $transaction,
            'Data Transaction Berhasil di update'
        );

    }

    public function deleteCheckout(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);

        $transaction->delete();
        return ResponseFormmater::success(
            $transaction,
            'Data Transaction Berhasil di Delete'
        );
    }

    public function transaction (Request $request)
    {
        $id = $request->input('id');
        $user_id = $request->input('user_id');
        $status_transaction = $request->input('status_transaction');
        $limit = $request->input('limit', 10);

        if($id)
        {
            $transaction = Transaction::with(['users', 'carts', 'users.profiles'])->find($id);

            if($transaction)
            {
                return ResponseFormmater::success(
                    $transaction,
                    'Transaction berhasil diambil'
                );
            }

            else {
                return ResponseFormmater::error(
                    null,
                    'Transaction tidak ditemukan',
                    404,
                );
            }
        }

        $transaction = Transaction::with(['users', 'carts']);

        if($user_id)
        {
            $transaction->where('user_id', $user_id);
        }

        if($status_transaction)
        {
            $transaction->where('status_transaction', $status_transaction);
        }

        return ResponseFormmater::success(
            $transaction->paginate($limit),
            'Transaction berhasil diambil'
        );

    }
}
