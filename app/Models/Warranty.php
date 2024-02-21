<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warranty extends Model
{
    use HasFactory;
    protected $table = 'warranties';
    protected $guarded = [];

    public function customers(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}


