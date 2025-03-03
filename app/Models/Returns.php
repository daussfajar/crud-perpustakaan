<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Returns extends Model
{
    protected $table = 'returns';

    protected $fillable = [
        'return_id',
        'loan_id',
        'fine',
        'return_date',
        'status'
    ];

    public function loan()
    {
        return $this->belongsTo('App\Models\Loans', 'loan_id');
    }
}
