<x-mail::message>
# Alerta de Mantención Próxima

Se acerca la fecha para realizar una mantención programada.

**Máquina:** {{ $mantencion->maquinaria->nombre }} ({{ $mantencion->maquinaria->codigo_interno }})
**Tipo de Mantención:** {{ $mantencion->tipo }}
**Fecha Programada:** {{ \Carbon\Carbon::parse($mantencion->fecha_proxima)->format('d/m/Y') }}

Por favor, asegúrese de preparar los repuestos y agendar con el equipo técnico.

<x-mail::button :url="url('/admin/mantencions')">
Ver en el Sistema
</x-mail::button>

Saludos,<br>
Sistema de Mantenciones San Julián
</x-mail::message>
