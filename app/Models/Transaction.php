<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_number', 'user_id', 'supplier_id',
        'customer_name', 'type', 'date', 'status', 'notes'
    ];

    public function user() // Staff
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supplier() // Supplier (untuk barang masuk)
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}
