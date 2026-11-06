<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enderecos extends Model
{
    use HasFactory;

    protected $table = 'enderecos'; 

    protected $fillable = [ 
        'apelido',
        'rua',
        'numero',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'pais',
    ];
}