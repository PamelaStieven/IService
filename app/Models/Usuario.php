<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tecnicos;
use App\Models\Endereco;
use App\Models\Equipamento;
use App\Models\Agendamento;
use App\Models\LocacaoEquip;

class Usuario extends Model
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
        return $this->hasOne(Tecnicos::class, 'UserID', 'UserID');
    }

    public function enderecos()
    {
        return $this->hasMany(Endereco::class, 'UserID', 'UserID');
    }

    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class, 'UserID', 'UserID');
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