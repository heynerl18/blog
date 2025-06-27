{{-- resources/views/emails/contact.blade.php --}}
<x-mail::message>
# Nuevo Mensaje de Contacto

Has recibido un nuevo mensaje a través del formulario de contacto de tu sitio web.

**Correo Electrónico:** {{ $email }}

@if($subject)
**Asunto:** {{ $subject }}
@endif

**Mensaje:**
{{ $message }}

Gracias,
El equipo de {{ config('app.name') }}
</x-mail::message>