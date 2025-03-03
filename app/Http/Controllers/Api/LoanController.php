<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Loans;
use App\Models\User;
use App\Models\Books;

class LoanController extends Controller
{
    function __construct()
    {

    }

    public function index(){
        $loans = Loans::all();

        $data = [];
        foreach($loans as $loan){
            $data[] = [
                'loan_id' => $loan->loan_id,
                'user_id' => $loan->user_id,
                'book_id' => $loan->book_id,
                'loan_date' => $loan->loan_date,
                'return_date' => $loan->return_date,
                'status' => $loan->status,
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $data,
        ], 200);
    }

    public function loanBook(Request $request){
        $userId = $request->input('user_id') ?? null;
        $bookId = $request->input('book_id') ?? null;
        $loanDate = $request->input('loan_date') ?? null;
        $returnDate = $request->input('return_date') ?? null;

        if(!$userId || !$bookId || !$loanDate || !$returnDate){
            return response()->json([
                'status' => 'error',
                'message' => 'Please provide all required fields',
            ], 400);
        }

        $findUser = User::where('id', $userId)->first();
        if(!$findUser){
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $findBooks = Books::where('book_id', $bookId)->first();
        if(!$findBooks){
            return response()->json([
                'status' => 'error',
                'message' => 'Book not found',
            ], 404);
        }

        if($loanDate > $returnDate){
            return response()->json([
                'status' => 'error',
                'message' => 'Loan date cannot be greater than return date',
            ], 400);
        }

        $insertLoan = Loans::insert([
            'user_id' => $userId,
            'book_id' => $bookId,
            'loan_date' => $loanDate,
            'return_date' => $returnDate,
            'status' => 'borrowed',
        ]);

        if(!$insertLoan){
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to loan book',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Book loaned successfully',
        ], 200);
    }
}
