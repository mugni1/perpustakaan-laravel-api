<?php

namespace App\Http\Controllers;

use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function count(){
        $result = Transaction::count();
        return response(['count'=>$result]);
    }

    public function index(){
        $result = Transaction::select('id', 'borrowing_id', 'transaction_type', 'amount', 'created_at')
        ->orderByDesc("created_at")
        ->with([
            'borrowings:id,user_id,book_id',
            'borrowings.books:id,title',
            'borrowings.users:id,username'
        ])
        ->simplePaginate(15);
        // return TransactionResource::collection($result);
        return response(['data'=>$result]);
    }

    public function show($id){
        // $result = Transaction::where('id', $id)->first();
        $result = Transaction::findOrFail($id);
        return new TransactionResource($result);
        // return $result;
    }

    public function trasnBorrow(){
        $result = Transaction::select('id', 'borrowing_id', 'transaction_type', 'amount', 'created_at')
        ->orderByDesc("created_at")
        ->where('transaction_type', 'peminjaman')
        ->with([
            'borrowings:id,user_id,book_id',
            'borrowings.books:id,title',
            'borrowings.users:id,username'
        ])
        ->simplePaginate(15);
        // return TransactionResource::collection($result);
        return response(['data'=>$result]);
    }

    public function transReturn(){
        $result = Transaction::select('id', 'borrowing_id', 'transaction_type', 'amount', 'created_at')
        ->orderByDesc("created_at")
        ->where('transaction_type', 'pengembalian')
        ->with([
            'borrowings:id,user_id,book_id',
            'borrowings.books:id,title',
            'borrowings.users:id,username'
        ])
        ->simplePaginate(15);
        // return TransactionResource::collection($result);
        return response(['data'=>$result]);
    }

    public function transFine(){
        $result = Transaction::select('id', 'borrowing_id', 'transaction_type', 'amount', 'created_at')
        ->orderByDesc("created_at")
        ->where('transaction_type', 'denda')
        ->with([
            'borrowings:id,user_id,book_id',
            'borrowings.books:id,title',
            'borrowings.users:id,username'
        ])
        ->simplePaginate(15);
        // return TransactionResource::collection($result);
        return response(['data'=>$result]);
    }
}