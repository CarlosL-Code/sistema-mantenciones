<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Trabajo #{{ $mantencion->id }}</title>
    <style>
        @page { margin: 20px 25px; }
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 10px; color: #333; line-height: 1.3; margin: 0; padding: 0; }
        .header { background-color: #1a2b4c; color: white; padding: 15px 20px; text-align: left; position: relative; border-bottom: 3px solid #3b82f6; }
        .header h1 { margin: 0; font-size: 20px; font-weight: 300; letter-spacing: 1px; text-transform: uppercase; }
        .header p { margin: 5px 0 0 0; font-size: 11px; color: #cbd5e1; }
        .header .status { position: absolute; top: 15px; right: 20px; background-color: #3b82f6; color: white; padding: 5px 12px; border-radius: 4px; font-weight: bold; font-size: 10px; text-transform: uppercase; letter-spacing: 1px; }
        
        .container { padding: 15px 20px; }
        
        .row { width: 100%; margin-bottom: 15px; display: block; clear: both; }
        .col-50 { width: 48%; display: inline-block; vertical-align: top; }
        .col-right { margin-left: 3%; }
        
        .info-box { border: 1px solid #e2e8f0; border-radius: 4px; overflow: hidden; margin-bottom: 12px; }
        .info-box-title { background-color: #f8fafc; color: #0f172a; padding: 8px 10px; font-size: 11px; font-weight: bold; border-bottom: 1px solid #e2e8f0; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-box-content { padding: 10px; background-color: #ffffff; }
        
        table.modern-table { width: 100%; border-collapse: collapse; margin-bottom: 0; }
        table.modern-table th, table.modern-table td { padding: 5px 0; text-align: left; border: none; border-bottom: 1px solid #f1f5f9; }
        table.modern-table tr:last-child th, table.modern-table tr:last-child td { border-bottom: none; }
        table.modern-table th { width: 40%; color: #64748b; font-weight: normal; font-size: 9px; text-transform: uppercase; }
        table.modern-table td { font-weight: 500; color: #1e293b; }
        
        .data-table-wrapper { border: 1px solid #e2e8f0; border-radius: 4px; overflow: hidden; margin-bottom: 15px; }
        table.data-table { width: 100%; border-collapse: collapse; }
        table.data-table th { background-color: #f8fafc; color: #64748b; font-size: 9px; text-transform: uppercase; padding: 8px 10px; text-align: left; border-bottom: 1px solid #e2e8f0; }
        table.data-table td { padding: 8px 10px; border-bottom: 1px solid #f1f5f9; color: #334155; }
        table.data-table tr:last-child td { border-bottom: none; }
        table.data-table tr:nth-child(even) { background-color: #f8fafc; }
        
        .totals-section { width: 100%; margin-top: 15px; display: block; clear: both; }
        .totals-box { width: 35%; float: right; border: 1px solid #e2e8f0; border-radius: 4px; overflow: hidden; }
        table.totals-table { width: 100%; border-collapse: collapse; }
        table.totals-table th, table.totals-table td { padding: 7px 10px; border-bottom: 1px solid #f1f5f9; }
        table.totals-table th { color: #64748b; font-weight: normal; font-size: 10px; text-align: left; }
        table.totals-table td { font-weight: bold; color: #1e293b; text-align: right; }
        table.totals-table tr.grand-total { background-color: #1a2b4c; }
        table.totals-table tr.grand-total th { color: white; font-weight: bold; font-size: 11px; text-transform: uppercase; }
        table.totals-table tr.grand-total td { color: white; font-size: 14px; }
        
        .signature-section { width: 100%; margin-top: 35px; display: block; clear: both; text-align: center; page-break-inside: avoid; }
        .signature-box { width: 45%; display: inline-block; vertical-align: top; }
        .signature-line { border-bottom: 1px solid #94a3b8; width: 80%; margin: 0 auto 8px auto; }
        .signature-title { font-weight: bold; color: #0f172a; margin-bottom: 3px; font-size: 11px; }
        .signature-text { color: #64748b; font-size: 10px; line-height: 1.3; }
        
        .footer { text-align: center; margin-top: 25px; padding-top: 10px; border-top: 1px solid #e2e8f0; color: #94a3b8; font-size: 8px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>REPORTE DE MANTENCIÓN</h1>
        <p>Orden de Trabajo N°: <strong>{{ str_pad($mantencion->id, 6, '0', STR_PAD_LEFT) }}</strong> | Fecha: <strong>{{ now()->format('d/m/Y') }}</strong></p>
        <div class="status">{{ $mantencion->estado }}</div>
    </div>

    <div class="container">
        
        <!-- Bloque Superior a Dos Columnas -->
        <div class="row">
            <!-- Columna Izquierda: Activo -->
            <div class="col-50">
                <div class="info-box">
                    <div class="info-box-title">Información del Activo</div>
                    <div class="info-box-content">
                        <table class="modern-table">
                            <tr>
                                <th>Maquinaria/Equipo</th>
                                <td>{{ !empty($mantencion->maquinaria->nombre) ? $mantencion->maquinaria->nombre : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Código Interno</th>
                                <td>{{ !empty($mantencion->maquinaria->codigo_interno) ? $mantencion->maquinaria->codigo_interno : 'S/C' }}</td>
                            </tr>
                            <tr>
                                <th>Ubicación/Sector</th>
                                <td>{{ !empty($mantencion->maquinaria->area_sector) ? $mantencion->maquinaria->area_sector : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Tipo Mantención</th>
                                <td>{{ $mantencion->tipo }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Columna Derecha: Reporte -->
            <div class="col-50 col-right">
                <div class="info-box">
                    <div class="info-box-title">Detalles del Reporte</div>
                    <div class="info-box-content">
                        <table class="modern-table">
                            <tr>
                                <th>Fecha Solicitud</th>
                                <td>{{ $mantencion->fecha_realizacion ? $mantencion->fecha_realizacion->format('d/m/Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Fecha Reparación</th>
                                <td>{{ $mantencion->fecha_reparacion ? $mantencion->fecha_reparacion->format('d/m/Y') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Técnico Asignado</th>
                                <td>{{ !empty($mantencion->tecnico->name) ? $mantencion->tecnico->name : 'No asignado' }}</td>
                            </tr>
                            <tr>
                                <th>Tiempo Utilizado</th>
                                <td>{{ !empty($mantencion->tiempo_utilizado) ? $mantencion->tiempo_utilizado : 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Trabajo Realizado (Ancho completo) -->
        <div class="info-box">
            <div class="info-box-title">Desarrollo del Trabajo</div>
            <div class="info-box-content">
                <p style="margin: 0 0 10px 0;"><strong>Observación Inicial / Problema:</strong><br>
                <span style="color: #475569;">{{ !empty($mantencion->observaciones_tecnico) ? $mantencion->observaciones_tecnico : 'Sin observaciones' }}</span></p>
                
                <p style="margin: 0;"><strong>Trabajo Realizado:</strong><br>
                <span style="color: #475569;">{{ !empty($mantencion->trabajo_realizado) ? $mantencion->trabajo_realizado : 'No registrado' }}</span></p>
            </div>
        </div>

        <!-- Repuestos -->
        <div class="info-box-title" style="background: none; border-bottom: none; padding-left: 0; font-size: 14px;">Repuestos Utilizados</div>
        <div class="data-table-wrapper">
            @if($mantencion->repuestos && $mantencion->repuestos->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th style="width: 50%;">Descripción del Repuesto</th>
                        <th style="width: 15%; text-align: center;">Cantidad</th>
                        <th style="width: 15%; text-align: right;">P. Unit.</th>
                        <th style="width: 20%; text-align: right;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mantencion->repuestos as $repuesto)
                    <tr>
                        <td><strong>{{ $repuesto->nombre }}</strong></td>
                        <td style="text-align: center;">{{ $repuesto->pivot->cantidad }}</td>
                        <td style="text-align: right;">${{ number_format($repuesto->pivot->precio_unitario ?? 0, 0, ',', '.') }}</td>
                        <td style="text-align: right; color: #0f172a; font-weight: bold;">${{ number_format($repuesto->pivot->precio_total, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <div style="padding: 15px; text-align: center; color: #64748b; font-style: italic;">No se registraron repuestos en esta mantención.</div>
            @endif
        </div>

        <!-- Costos Totales -->
        <div class="totals-section">
            <div class="totals-box">
                <table class="totals-table">
                    <tr>
                        <th>Costo Repuestos:</th>
                        <td>${{ number_format($mantencion->repuestos->sum('pivot.precio_total') ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Costo Mano de Obra:</th>
                        <td>${{ number_format($mantencion->costo_mano_obra ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Servicios Externos:</th>
                        <td>${{ number_format($mantencion->costo_externo ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Otros Costos:</th>
                        <td>${{ number_format($mantencion->costo_otros ?? 0, 0, ',', '.') }}</td>
                    </tr>
                    @php
                        $totalBruto = ($mantencion->repuestos->sum('pivot.precio_total') ?? 0) + 
                                      ($mantencion->costo_mano_obra ?? 0) + 
                                      ($mantencion->costo_externo ?? 0) + 
                                      ($mantencion->costo_otros ?? 0);
                        $totalNeto = round($totalBruto / 1.19);
                        $totalIva = $totalBruto - $totalNeto;
                    @endphp
                    <tr>
                        <th>Total Neto:</th>
                        <td>${{ number_format($totalNeto, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>IVA (19%):</th>
                        <td>${{ number_format($totalIva, 0, ',', '.') }}</td>
                    </tr>
                    <tr class="grand-total">
                        <th>COSTO TOTAL (IVA INCL.)</th>
                        <td>${{ number_format($totalBruto, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div style="clear: both;"></div>

        <!-- Firmas -->
        <div class="signature-section">
            <div class="signature-box" style="float: left;">
                <div class="signature-line"></div>
                <div class="signature-title">Firma Supervisor / Jefatura</div>
                <div class="signature-text">
                    Nombre: ______________________<br>
                    Fecha: ______________________
                </div>
            </div>
            
            <div class="signature-box" style="float: right;">
                <div class="signature-line"></div>
                <div class="signature-title">Firma de Conformidad Técnico</div>
                <div class="signature-text">
                    @php
                        $firma = json_decode($mantencion->firma_tecnico, true);
                    @endphp
                    Nombre: <strong>{{ !empty($firma['nombre']) ? $firma['nombre'] : '______________________' }}</strong><br>
                    RUT: {{ !empty($firma['rut']) ? $firma['rut'] : '______________________' }}
                </div>
            </div>
            <div style="clear: both;"></div>
        </div>

        <!-- Footer -->
        <div class="footer">
            Documento generado automáticamente por el Sistema de Gestión de Activos y Mantenciones.<br>
            Copia controlada de orden de trabajo interna.
        </div>

    </div>

</body>
</html>
