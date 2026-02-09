<?php

namespace App\Events;

use App\Models\PacienteDia;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class PacienteChamado implements ShouldBroadcast
{
    use SerializesModels;

    public array $paciente;

    public function __construct(PacienteDia $paciente)
    {
        $this->paciente = [
            'id'   => $paciente->id,
            'nome' => $paciente->paciente->nome_completo ?? '',
            'sala' => $paciente->sala_dia,
        ];
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chamadas');
    }

    public function broadcastAs(): string
    {
        return 'PacienteChamado';
    }
}
