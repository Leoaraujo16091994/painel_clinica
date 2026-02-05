<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PacienteDia extends Model
{
    use HasFactory;
    protected $table = 'paciente_dia';

    protected $fillable = [
        'paciente_id',
        'chegou',
        'chamado',
        'chamado_painel',
        'chamar_acompanhante',
        'sala_dia',
        'turno_dia',
        'observacao',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id');
    }
}
