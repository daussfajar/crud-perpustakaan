<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loans extends Model
{
    protected $table = 'loans';

    protected $fillable = [
        'loan_id',
        'user_id',
        'book_id',
        'loan_date',
        'return_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function book()
    {
        return $this->belongsTo('App\Models\Books', 'book_id');
    }
}
