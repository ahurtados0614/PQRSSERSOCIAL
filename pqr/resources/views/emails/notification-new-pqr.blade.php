<p>Hola, <strong>{{ ucwords($pqr->solicitante->nombre) }} {{ ucwords($pqr->solicitante->apellido) }}</strong>.</p>

<p>Hemos recibido correctamente tu solicitud de <strong>{{ $pqr->tipo }}</strong> y ha sido asignada a nuestro equipo de atención para su gestión.</p>

<div style="background-color: #f3f4f6; padding: 15px; border-radius: 8px; margin: 20px 0;">
    <h3 style="margin-top: 0; color: #1f2937;">Detalles del Radicado</h3>
    <p><strong>Número de Radicado:</strong> <span style="color: #2563eb; font-weight: bold;">{{ $pqr->radicado }}</span></p>
    <p><strong>Categoría:</strong> {{ ucwords($pqr->categoria) }}</p>
    <p><strong>Fecha de Registro:</strong> {{ $pqr->created_at->format('d/m/Y') }}</p>
</div>

<p>Puedes rastrear el estado e historial de tu solicitud en cualquier momento ingresando tu número de radicado en nuestra plataforma de seguimiento:</p>

<p style="text-align: center; margin: 25px 0;">
    <a href="{{ url('/pqr/rastreo?radicado=' . $pqr->radicado) }}" 
       style="background-color: #1f2937; color: #ffffff; padding: 12px 20px; text-decoration: none; border-radius: 6px; font-weight: bold; display: inline-block;">
        Consultar Estado de mi PQR
    </a>
</p>

<p>Si el botón no funciona, copia y pega el siguiente enlace en tu navegador:</p>
<p style="word-break: break-all; color: #4b5563;">
    {{ url('/pqr/rastreo?radicado=' . $pqr->radicado) }}
</p>

<hr style="border: none; border-top: 1px solid #e5e7eb; margin: 30px 0;" />

<p style="font-size: 12px; color: #6b7280;">Este es un correo automático, por favor no respondas directamente a este mensaje.</p>