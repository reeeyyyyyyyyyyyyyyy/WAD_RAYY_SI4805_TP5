<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Book extends Model
{
    use HasFactory;
    /**
     * ==========1===========
     * Fill in the code to define the table name and fillable attributes
     */
    protected $table = 'books';

    protected $fillable = [
        'title',
        'author',
        'published_year',
        'is_available',
    ];
}
