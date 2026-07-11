<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aviso de Mantención</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7f6; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 40px auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        .header { background-color: #0f172a; padding: 30px; text-align: center; }
        .header img { max-width: 150px; height: auto; }
        .header h1 { color: #ffffff; margin: 15px 0 0; font-size: 24px; font-weight: 600; }
        .content { padding: 40px 30px; color: #334155; line-height: 1.6; }
        .alert { padding: 15px; border-radius: 6px; margin-bottom: 25px; font-weight: 600; }
        .alert.vencida { background-color: #fee2e2; color: #b91c1c; border-left: 4px solid #ef4444; }
        .alert.proxima { background-color: #fef9c3; color: #a16207; border-left: 4px solid #eab308; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        table th, table td { padding: 12px 15px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        table th { background-color: #f8fafc; color: #64748b; font-weight: 600; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
        table td { font-size: 15px; }
        .btn { display: inline-block; background-color: #2563eb; color: #ffffff; text-decoration: none; padding: 12px 25px; border-radius: 6px; font-weight: 600; margin-top: 30px; }
        .footer { background-color: #f8fafc; padding: 20px; text-align: center; font-size: 13px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Asumiendo que el logo estará en public/images/logo.png o similar, usamos asset() -->
            <img src="{{ asset('images/logo.png') }}" alt="CMMS Logo">
            <h1>Sistema de Mantención CMMS</h1>
        </div>
        <div class="content">
            <p>Hola,</p>
            <p>Este es un aviso automático generado por el sistema CMMS.</p>
            
            <div class="alert {{ $tipoAviso }}">
                @if($tipoAviso === 'vencida')
                    ⚠️ ALERTA: La mantención de este activo se encuentra VENCIDA.
                @else
                    🔔 AVISO: Se aproxima la fecha programada para mantención.
                @endif
            </div>

            <table>
                <tr>
                    <th>Activo / Equipo</th>
                    <td>{{ $mantencion->maquinaria->nombre }} ({{ $mantencion->maquinaria->codigo_interno }})</td>
                </tr>
                <tr>
                    <th>Área / Sector</th>
                    <td>{{ $mantencion->maquinaria->area }}</td>
                </tr>
                <tr>
                    <th>Tipo de Mantención</th>
                    <td>{{ $mantencion->tipo }}</td>
                </tr>
                <tr>
                    <th>Fecha Programada</th>
                    <td>{{ \Carbon\Carbon::parse($mantencion->fecha_proxima)->format('d/m/Y') }}</td>
                </tr>
            </table>

            <div style="text-align: center;">
                <a href="{{ url('/admin/mantencions/' . $mantencion->id . '/edit') }}" class="btn">Ver Orden de Mantención</a>
            </div>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Confites San Julián. Todos los derechos reservados.
        </div>
    </div>
</body>
</html>
