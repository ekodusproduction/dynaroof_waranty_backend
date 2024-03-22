<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warranty extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'warranties';
    protected $guarded = [];

    public function customers(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}


