<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registro extends Model
{
    protected $table = 'registro';

    protected $fillable = [
        'humedad',
        'temperatura',
        'hora',
        'fecha'
    ];
}
