<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Books extends Model
{
    protected $table = 'books';

    protected $fillable = [
        'book_id',
        'title',
        'author',
        'publisher',
        'year',
        'isbn',
        'category_id',
        'stock',
    ];

    public function category()
    {
        return $this->belongsTo('App\Models\Categories', 'category_id');
    }
}
