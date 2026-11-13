<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agendamento extends Model
{
    use HasFactory;

    protected $table = 'Agendamento'; 
    protected $primaryKey = 'AgendamentoID'; 
    public $timestamps = false; 

    protected $fillable = [
        'TecnicoID',
        'ServicoID',
        'UserID',
        'data_hora_inicio',
        'data_hora_fim',
        'status_servico',
    ];

    // Relacionamentos
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
}