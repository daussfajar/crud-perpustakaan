<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\LoanService;
class LoanController extends Controller
{
    protected $service;

    function __construct(LoanService $service) {
        $this->service = $service;
    }

    public function showAllLoans() {
        $loans = $this->service->showAllLoans();
        return $loans;
    }

    public function showLoanById(Request $request) {
        $loanId = $request->loan_id;
        $loan = $this->service->showLoanById([
            'loan_id' => $loanId
        ]);

        return $loan;
    }

    public function createLoan(Request $request) {
        $loan = $this->service->createLoan([
            'user_id' => $request->input('user_id'),
            'book_id' => $request->input('book_id'),
            'loan_date' => $request->input('loan_date'),
            'return_date' => $request->input('return_date'),
            'status' => $request->input('status')
        ]);

        return $loan;
    }

    public function showLoanByUserId(Request $request) {
        $userId = $request->user_id;
        $loan = $this->service->showLoansByUserId([
            'user_id' => $userId
        ]);

        return $loan;
    }

    public function returnBook(Request $request) {
        $loanId = $request->loan_id;
        $loan = $this->service->returnBook([
            'loan_id'   => $loanId,
            'user_id'   => $request->input('user_id'),
            'status'    => $request->input('status'),
            'notes'     => $request->input('notes')
        ]);

        return $loan;
    }
}
