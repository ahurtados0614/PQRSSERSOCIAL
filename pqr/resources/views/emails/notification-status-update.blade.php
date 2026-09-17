<p>Hola, <strong>{{ ucwords($pqr->solicitante->nombre) }} {{ ucwords($pqr->solicitante->apellido) }}</strong>.</p>

<p>Te informamos que se ha registrado un nuevo seguimiento o cambio de estado sobre tu solicitud de <strong>{{ $pqr->tipo }}</strong>.</p>

<div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0;">
    <h3 style="margin-top: 0; color: #1f2937;">Detalles de la PQR</h3>
    <p><strong>Número de Radicado:</strong> <span style="color: #2563eb; font-weight: bold;">{{ $pqr->radicado }}</span></p>
    <p><strong>Estado Actual:</strong> <span style="background-color: #dbeafe; color: #1e40af; padding: 2px 8px; border-radius: 4px; font-weight: bold; font-size: 13px;">{{ $pqr->estado }}</span></p>
    <p><strong>Prioridad:</strong> {{ $pqr->prioridad }}</p>
</div>

<div style="border-left: 4px solid #2563eb; background-color: #ffffff; padding: 15px; border-top: 1px solid #e5e7eb; border-right: 1px solid #e5e7eb; border-bottom: 1px solid #e5e7eb; border-radius: 0 6px 6px 0; margin-bottom: 20px;">
    <h4 style="margin-top: 0; color: #111827; font-size: 14px;">Gestión Realizada / Respuesta:</h4>
    <p style="color: #374151; font-size: 14px; margin-bottom: 0; line-height: 1.5; white-space: pre-line;">{{ $gestion['descripcion'] ?? $pqr->descripcion }}</p>
</div>

<p style="text-align: center; margin: 25px 0;">
    <a href="{{ url('/pqr/rastreo?radicado=' . $pqr->radicado) }}" 
       style="background-color: #1f2937; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
        Ver Historial Completo
    </a>
</p>

<p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
<p style="word-break: break-all; color: #4b5563;">
    {{ url('/pqr/rastreo?radicado=' . $pqr->radicado) }}
</p>

<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;" />

<p style="font-size: 12px; color: #6b7280;">Este es un correo automático, por favor no respondas directamente a este mensaje.</p>