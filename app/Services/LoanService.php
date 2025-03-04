<?php

namespace App\Services;

use App\Repository\LoanRepository;
use Illuminate\Support\Facades\Validator;

use App\Helper\REST_Response;

use App\Repository\AuthRepository;
use App\Repository\BooksRepository;

class LoanService {
    protected $repo;
    protected $authRepo;
    protected $booksRepo;

    public function __construct(LoanRepository $loanRepository, AuthRepository $authRepository, BooksRepository $booksRepository)
    {
        $this->repo = $loanRepository;
        $this->authRepo = $authRepository;
        $this->booksRepo = $booksRepository;
    }

    public function showAllLoans() {
        return $this->repo->showAllLoans();
    }

    public function showLoanById($request) {
        $validator = Validator::make($request, [
            'loan_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        $loan = $this->repo->getLoanById($request['loan_id']);

        return $loan;
    }

    public function showLoansByUserId($request) {
        $validator = Validator::make($request, [
            'user_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        $loans = $this->repo->showLoansByUserId($request['user_id']);

        return $loans;
    }

    public function createLoan($request) {
        $validator = Validator::make($request, [
            'user_id' => 'required|integer',
            'book_id' => 'required|integer',
            'loan_date' => 'required|date',
            'return_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid data',
                'errors' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        $user = $this->authRepo->findUserById($request['user_id']);
        $book = $this->booksRepo->find($request['book_id']);

        if(!$user || !$book) {
            return response()->json([
                'status' => 'error',
                'message' => 'User or book not found'
            ], REST_Response::NOT_FOUND);
        }

        $returnDate = strtotime($request['return_date']);
        $loanDate = strtotime($request['loan_date']);

        if($returnDate < $loanDate) {
            return response()->json([
                'status' => 'error',
                'message' => 'Return date must be after loan date'
            ], REST_Response::BAD_REQUEST);
        }

        // check if book is available
        $bookAvailable = $this->booksRepo->isBookAvailable($request['book_id']);
        if(!$bookAvailable) {
            return response()->json([
                'status' => 'error',
                'message' => 'Book is not available'
            ], REST_Response::BAD_REQUEST);
        }

        $request['status'] = 'borrowed';

        return $this->repo->createLoan($request);
    }

    public function returnBook($request) {
        $validator = Validator::make($request, [
            'loan_id'   => 'required|integer',
            'user_id'   => 'required|integer',
            'status'    => 'required|string|in:fine,damaged,lost',
            'notes'     => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->all()
            ], REST_Response::BAD_REQUEST);
        }

        $loan = $this->repo->getLoanById($request['loan_id']);

        if(!$loan) {
            return response()->json([
                'status' => 'error',
                'message' => 'Loan not found'
            ], REST_Response::NOT_FOUND);
        }

        $data = $loan->getData();
        $row = $data->data[0];

        if($row->status == 'returned') {
            return response()->json([
                'status' => 'error',
                'message' => 'Book already returned'
            ], REST_Response::BAD_REQUEST);
        }

        $return = $this->repo->returnBook($request['loan_id'], $request['status'], $request['notes']);

        return $return;
    }
}
