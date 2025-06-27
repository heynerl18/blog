<?php

namespace App\Livewire\Public;

use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactNotification;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Illuminate\Support\Facades\Log;

#[Layout('layouts.public')]
class ContactForm extends Component
{
  public $email = '';
  public $subject = '';
  public $message = '';

  public $successMessage = '';
  public $errorMessage = '';

  protected $rules = [
    'email' => 'required|email',
    'subject' => 'nullable|string|min:3',
    'message' => 'required|string|min:10',
  ];

  protected $messages = [
    'email.required' => 'El campo de correo electrónico es requerido.',
    'email.email' => 'Por favor, ingresa un correo electrónico válido.',
    'subject.min' => 'El asunto debe tener al menos 3 caracteres.',
    'message.required' => 'El mensaje es requerido.',
    'message.min' => 'El mensaje debe tener al menos 10 caracteres.',
  ];

  public function submitForm(){
    $this->validate();
    try {

      ContactMessage::create([
        'email' => $this->email,
        'subject' => $this->subject,
        'message' => $this->message,
      ]);

      Mail::to('heynerleiva18@gmail.com')->send(new ContactNotification(
        $this->email,
        $this->subject,
        $this->message
      ));

      $this->reset(['email', 'subject', 'message']);
      $this->successMessage = '¡Tu mensaje ha sido enviado con éxito! Te responderemos pronto.';
      
    } catch (\Exception $e) {
      $this->errorMessage ='Hubo un error al enviar tu mensaje. Por favor, inténtalo de nuevo más tarde.';
      Log::error('Error al enviar el mensaje de contacto: ' . $e->getMessage());
    }
  }

  public function render()
  {
    return view('livewire.public.contact-form');
  }
}
