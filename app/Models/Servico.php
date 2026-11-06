<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tecnicos;
use App\Models\Agendamento;
use App\Models\ItemServico;

class Servico extends Model
{
    use HasFactory;

    protected $table = 'Servico';
    protected $primaryKey = 'ServicoID';
    public $timestamps = false;

    protected $fillable = [
        'TecnicoID',
        'titulo',
        'categoria',
        'descricao',
        'preco_base',
        'tipo_preco',
    ];

    protected $casts = [
        'preco_base' => 'decimal:2',
    ];

    public function tecnico()
    {
        return $this->belongsTo(Tecnicos::class, 'TecnicoID', 'TecnicoID');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'ServicoID', 'ServicoID');
    }

    public function itensServico()
    {
        return $this->hasMany(ItemServico::class, 'ServicoID', 'ServicoID');
    }
}