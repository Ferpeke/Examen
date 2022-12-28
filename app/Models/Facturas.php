<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    use HasFactory;

    public function usuario() {
        return $this->belongsTo(User::class);
    }
    public function conceptos(){
        return $this->hasMany(Conceptos::class);
    }
}
