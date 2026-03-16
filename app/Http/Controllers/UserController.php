<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

use function Laravel\Prompts\select;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'cpf_cnpj' => 'required|string|max:14|unique:users',
            'type' => 'required|in:user,merchant',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create($validatedData);

        // Creates a wallet for the user
        Wallet::create([
            
            'user_id' => $user->id,
            'balance' => 1000.00,
        ]);

        return response()->json([
            'message' => 'User created successfully',
             'user' => $user
             ], 201);

        
    }

    public function show($userId)
    {
        $user = User::with([
        'wallet'=> function($query) {
                $query->select('user_id','balance');
        }])
        ->select('id', 'name', 'email', 'cpf_cnpj', 'type')
        ->find($userId);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        } else {
            return response()->json([
            'user' => $user
            ], 200);
        }

        }



        
}
