<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Usuario;
use App\Models\Equipamento;
use App\Models\Pagamento;

class LocacaoEquip extends Model
{
    use HasFactory;

    protected $table = 'locacao_equips';
    protected $primaryKey = 'LocEquipID';
    public $timestamps = false;

    protected $fillable = [
        'UserID',
        'EquipID',
        'data_retirada',
        'data_devolucao',
    ];

    protected $casts = [
        'data_retirada'  => 'datetime',
        'data_devolucao' => 'datetime',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'UserID', 'UserID');
    }

    public function equipamento()
    {
        return $this->belongsTo(Equipamentos::class, 'EquipID', 'EquipID');
    }

    public function pagamento()
    {
        return $this->hasOne(Pagamento::class, 'LocEquipID', 'LocEquipID');
    }
}