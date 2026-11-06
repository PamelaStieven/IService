<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;

class Endereco extends Model
{
    use HasFactory;

    protected $table = 'Endereco';
    protected $primaryKey = 'EnderecoID';
    public $timestamps = false;

    protected $fillable = [
        'UserID',
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
        return $this->belongsTo(Usuario::class, 'UserID', 'UserID');
    }
}