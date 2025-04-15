<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'no_hp',
        'point'
    ];

    public function sales() {
        return $this->hasMany(Sale::class);
    }
}
