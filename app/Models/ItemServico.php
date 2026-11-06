<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Servico;
use App\Models\Agendamento;

class ItemServico extends Model
{
    use HasFactory;

    protected $table = 'itemservico';
    protected $primaryKey = 'ItemServicoID';
    public $timestamps = false;

    protected $fillable = [
        'AgendamentoID',
        'ServicoID',
        'descricao_item',
        'data_item',
    ];

    protected $casts = [
        'data_item' => 'date',
    ];

    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'AgendamentoID', 'AgendaID');
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'ServicoID', 'ServicoID');
    }
}