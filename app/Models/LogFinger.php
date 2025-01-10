<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogFinger extends Model
{
    use HasFactory;
    protected $table = 'log_fingers';
    protected $fillable = ['barcode', 'finger', 'transaction_code', 'store_id'];
}
