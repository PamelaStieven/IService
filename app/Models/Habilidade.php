<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tecnicos;

class Habilidade extends Model
{
    use HasFactory;

    protected $table = 'Habilidade';
    protected $primaryKey = 'HabilidadeID';
    public $timestamps = false;

    protected $fillable = [
        'TecnicoID',
        'descricao',
        'cursos',
    ];

    public function tecnico()
    {
        return $this->belongsTo(Tecnicos::class, 'TecnicoID', 'TecnicoID');
    }
}