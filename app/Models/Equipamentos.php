<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamentos extends Model
{
    use HasFactory;

    protected $table = 'equipamentos';

    protected $fillable = [
        'UserID',
        'nome',
        'modelo',
        'descricao_tecnica',
        'data_compra',
        'valor_aluguel',
        'status',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UserID');
    }
}
