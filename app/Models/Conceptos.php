<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conceptos extends Model
{
    use HasFactory;

    public function facturas(){
        return $this->belongsTo(Facturas::class);
    }
}
