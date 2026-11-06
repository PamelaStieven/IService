<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tecnicos;

class DadosBancarios extends Model
{
    use HasFactory;

    protected $table = 'Dados_bancarios';
    protected $primaryKey = 'ContaID';
    public $timestamps = false;

    protected $fillable = [
        'TecnicoID',
        'banco',
        'agencia',
        'numero_conta',
        'tipo_conta',
        'titular',
        'cpf_cnpj_titular',
    ];

    public function tecnico()
    {
        return $this->belongsTo(Tecnicos::class, 'TecnicoID', 'TecnicoID');
    }
}