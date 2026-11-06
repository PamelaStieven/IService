<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Agendamento;
use App\Models\LocacaoEquip;

class Pagamento extends Model
{
    use HasFactory;

    protected $table = 'Pagamento';
    protected $primaryKey = 'PagamentoID';
    public $timestamps = false;

    protected $fillable = [
        'AgendaID',
        'LocEquipID',
        'metodo',
        'valor_total',
        'taxa_site',
        'status_pagamento',
        'data_pagamento',
    ];

    protected $casts = [
        'valor_total'    => 'decimal:2',
        'taxa_site'      => 'decimal:1',
        'data_pagamento' => 'datetime',
    ];

    public function agendamento()
    {
        return $this->belongsTo(Agendamento::class, 'AgendaID', 'AgendaID');
    }

    public function locacaoEquip()
    {
        return $this->belongsTo(LocacaoEquip::class, 'LocEquipID', 'LocEquipID');
    }
}