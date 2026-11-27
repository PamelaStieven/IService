<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipamentos extends Model
{
    use HasFactory;

    protected $table = 'equipamentos';
    protected $primaryKey = 'EquipID';

    protected $fillable = [
        'UserID',
        'nome',
        'modelo',
        'descricao_tecnica',
        'estado_conservacao',
        'valor_diaria',
        'imagem',
        'data_compra',
        'valor_aluguel',
        'status',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UserID');
    }
}
