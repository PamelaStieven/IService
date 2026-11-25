<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'UserID';
    public $timestamps = false; 

    protected $fillable = [
        'nome_razao',
        'email',
        'password',
        'cpf_cnpj',
        'data_nascimento',
        'telefone',
        'tipo',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'data_nascimento' => 'datetime',
    ];

    public function getAuthIdentifierName()
    {
        return 'UserID';
    }

    public function tecnico()
    {
        return $this->hasOne(Tecnicos::class, 'UserID', 'UserID');
    }

    public function enderecos()
    {
        return $this->hasMany(Enderecos::class, 'UserID', 'UserID');
    }

    public function equipamentos()
    {
        return $this->hasMany(Equipamentos::class, 'UserID', 'UserID');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'UserID', 'UserID');
    }

    public function locacoesEquip()
    {
        return $this->hasMany(LocacaoEquip::class, 'UserID', 'UserID');
    }
}
