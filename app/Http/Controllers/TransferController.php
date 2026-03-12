<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'payer_id' => 'required|exists:users,id',
            'payee_id' => 'required|exists:users,id|different:payer_id',
            'value' => 'required|numeric|min:0.01',
        ]);
    

        
        $payer = User::find($validatedData['payer_id']);
        $payee = User::find($validatedData['payee_id']);
        
        
        if ($payer->type === 'merchant') {
            return response()->json([
                'message' => 'Merchants users are not allowed to send transfers'
                ], 403);
            }
            
        if ($payer->wallet->balance < $validatedData['value']) {
            return response()->json([
                'message' => 'Insufficient balance'], 422);
            }
            
        $response = Http::get('https://util.devi.tools/api/v2/authorize');
        if (!$response['data']['authorization']) {
            return response()->json([
                'message' => 'Transfer not authorized'
            ], 403);
        }



        $transfer = DB::transaction(function () use ($payer, $payee, $validatedData) {
            $payer->wallet->balance -= $validatedData['value'];
            $payee->wallet->balance += $validatedData['value'];
            $payer->wallet->save();
            $payee->wallet->save();
            
            
            return Transfer::create([
                'payer_id' => $validatedData['payer_id'],
                'payee_id' => $validatedData['payee_id'],
                'value' => $validatedData['value'],
                ]);
                
            });


            return response()->json([
            'message' => 'Transfer created successfully',
            'transfer' => $transfer
                ], 201);
                
    }            
                    

     
}
