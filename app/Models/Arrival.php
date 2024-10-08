<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arrival extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function item(){
        return $this->belongsTo(Item::class);
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }
}