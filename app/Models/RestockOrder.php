<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestockOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number', 'user_id', 'supplier_id',
        'expected_delivery_date', 'status', 'notes', 'rating'
    ];

    public function manager() // Manager pembuat
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function supplier() // Supplier penerima
    {
        return $this->belongsTo(User::class, 'supplier_id');
    }

    public function details()
    {
        return $this->hasMany(RestockOrderDetail::class);
    }
}
