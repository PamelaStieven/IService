<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tecnicos;
use App\Models\Servico;
use App\Models\Usuario;
use App\Models\Pagamento;
use App\Models\ItemServico;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'Agendamento';
    protected $primaryKey = 'AgendaID';
    public $timestamps = false;

    protected $fillable = [
        'TecnicoID',
        'ServicoID',
        'UserID',
        'data_hora_inicio',
        'data_hora_fim',
        'status_servico',
    ];

    protected $casts = [
        'data_hora_inicio' => 'datetime',
        'data_hora_fim'    => 'datetime',
    ];

    public function tecnico()
    {
        return $this->belongsTo(Tecnicos::class, 'TecnicoID', 'TecnicoID');
    }

    public function servico()
    {
        return $this->belongsTo(Servico::class, 'ServicoID', 'ServicoID');
    }

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UserID', 'UserID');
    }

    public function pagamento()
    {
        return $this->hasOne(Pagamento::class, 'AgendaID', 'AgendaID');
    }

    public function itensServico()
    {
        return $this->hasMany(ItemServico::class, 'AgendamentoID', 'AgendaID');
    }
}