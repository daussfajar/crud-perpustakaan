<?php

namespace App\Repository;

use App\Models\Loans;
use App\Models\Books;
use App\Models\Returns;

use Illuminate\Http\JsonResponse;
use App\Helper\REST_Response;

use Carbon\Carbon;

class LoanRepository
{

    public function showAllLoans() : JsonResponse
    {
        $model = new Loans();
        $loans = $model->join('books', 'loans.book_id', '=', 'books.book_id')
            ->join('users', 'loans.user_id', '=', 'users.id')
            ->select('loans.loan_id', 'books.title', 'books.author', 'books.publisher', 'books.year', 'loans.loan_date', 'loans.return_date', 'loans.status', 'users.name as requester_name', 'users.email as requester_email')
            ->get();

        if ($loans->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No loans found'
            ], REST_Response::NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $loans
        ], REST_Response::SUCCESS);
    }

    public function getLoanById($loan_id): JsonResponse
    {
        $model = new Loans();
        $loans = $model->join('books', 'loans.book_id', '=', 'books.book_id')
            ->join('users', 'loans.user_id', '=', 'users.id')
            ->join('returns', 'returns.loan_id', '=', 'loans.loan_id', 'left')
            ->select('loans.loan_id', 'books.title', 'books.author', 'books.publisher', 'books.year', 'loans.loan_date', 'loans.return_date', 'loans.status', 'users.name as requester_name', 'users.email as requester_email', 'returns.notes', 'returns.status as return_status', 'returns.return_date as actual_return_date')
            ->where('loans.loan_id', $loan_id)
            ->get();

        if (!$loans) {
            return response()->json([
                'status' => 'error',
                'message' => 'Loan not found'
            ], REST_Response::NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $loans
        ], REST_Response::SUCCESS);
    }

    public function showLoansByUserId($user_id): JsonResponse
    {
        $model = new Loans();
        $loans = $model->join('books', 'loans.book_id', '=', 'books.book_id')
            ->select('books.title', 'books.author', 'books.publisher', 'books.year', 'loans.loan_date', 'loans.return_date', 'loans.status')
            ->where('loans.user_id', $user_id)
            ->get();

        if ($loans->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No loans found for this user'
            ], REST_Response::NOT_FOUND);
        }

        return response()->json([
            'status' => 'success',
            'data' => $loans
        ], REST_Response::SUCCESS);
    }

    public function createLoan(array $data): JsonResponse
    {
        $loan = Loans::create($data);

        // Update stock
        $book = Books::find($data['book_id']);
        $book->stock = $book->stock - 1;
        $book->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Loan created successfully',
            'data' => $loan
        ], REST_Response::CREATED);
    }

    public function returnBook($loan_id, $status, $notes): JsonResponse
    {
        $loan = Loans::find($loan_id);
        $loan->status = 'returned';
        $loan->save();

        // Update stock
        $book = Books::find($loan->book_id);
        $book->stock = $book->stock + 1;

        $return_date = Carbon::parse($loan->return_date);
        $now = Carbon::now();
        $loan->status = 'returned';
        if ($now->gt($return_date)) {
            $loan->status = 'late';
        }

        $book->save();

        $returns = Returns::create([
            'loan_id' => $loan_id,
            'status' => $status,
            'notes' => $notes,
            'return_date' => $now
        ]);

        if(!$returns) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to return book'
            ], REST_Response::BAD_REQUEST);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Book returned successfully',
            'data' => $loan
        ], REST_Response::SUCCESS);
    }
}
