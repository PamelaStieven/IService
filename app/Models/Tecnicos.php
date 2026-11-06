<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $table = 'User';
    protected $primaryKey = 'UserID';
    public $timestamps = false;

    protected $fillable = [
        'nome_razao',
        'email',
        'cpf_cnpj',
        'data_nascimento',
        'telefone',
        'tipo',
    ];

    protected $casts = [
        'data_nascimento' => 'datetime',
    ];

    public function tecnico()
    {
        return $this->hasOne(Tecnico::class, 'UserID', 'UserID');
    }
}