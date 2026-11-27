<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Enderecos extends Model
{
    use HasFactory;

    protected $table = 'enderecos';
    protected $primaryKey = 'EnderecosID';
    public $timestamps = false;

    protected $fillable = [
        'userID',
        'apelido',
        'rua',
        'numero',
        'bairro',
        'cep',
        'cidade',
        'estado',
        'pais',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'userID', 'UserID');
    }
}