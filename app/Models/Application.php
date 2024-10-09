<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function item() // Use plural for many-to-many relationships
    {
        return $this->belongsToMany(Item::class, 'item_applications')
                    ->withPivot('quantity','id') // Include pivot fields if needed
                    ->withTimestamps(); // Include timestamps if needed
    }
    
}
