<x-mail::message>
# {{ $titulo }}

{{ $mensaje }}

<x-mail::panel>
**Máquina:** {{ $mantencion->maquinaria->nombre ?? 'Desconocida' }}
**Código Interno:** {{ $mantencion->maquinaria->codigo_interno ?? 'N/A' }}
**Estado:** {{ $mantencion->estado }}
</x-mail::panel>

<x-mail::button :url="url('/admin/mantencions')">
Ver en el Sistema
</x-mail::button>

Saludos,<br>
{{ config('app.name') }}
</x-mail::message>
