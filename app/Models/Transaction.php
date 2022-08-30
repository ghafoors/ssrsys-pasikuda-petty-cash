<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'reference',
        'note',
        'amount',
        'date',
        'posted_by',
        'category_id',
        'budget_id',
        'currency'
    ];

    protected $with = [
        'postedBy',
        'category'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function postedBy() {
        return $this->belongsTo(User::class, 'posted_by');
    }

    public function category() {
        return $this->belongsTo(TransactionCategory::class, 'category_id');
    }

}
