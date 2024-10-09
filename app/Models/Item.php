<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function arrival(){
        return $this->hasMany(Arrival::class);
    }

    public function location(){
        return $this->belongsTo(Location::class);
    }

    public function applications() // Use plural for many-to-many relationships
    {
        return $this->belongsToMany(Application::class, 'item_applications');
    }
}
