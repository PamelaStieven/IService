<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Habilidade;
use App\Models\Servico;
use App\Models\Agendamento;
use App\Models\DadosBancarios;

class Tecnicos extends Model
{
    use HasFactory;

    protected $table = 'Tecnicos';
    protected $primaryKey = 'TecnicoID';
    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'documento',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UserID', 'UserID');
    }

    public function dadosBancarios()
    {
        return $this->hasOne(DadosBancarios::class, 'TecnicoID', 'TecnicoID');
    }

    public function habilidades()
    {
        return $this->hasMany(Habilidade::class, 'TecnicoID', 'TecnicoID');
    }

    public function servicos()
    {
        return $this->hasMany(Servico::class, 'TecnicoID', 'TecnicoID');
    }

    public function agendamentos()
    {
        return $this->hasMany(Agendamento::class, 'TecnicoID', 'TecnicoID');
    }
}