<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactNotification extends Mailable
{
	use Queueable, SerializesModels;

	public $contactEmail;
	public $contactSubject;
	public $contactMessage;

	/**
	 * Create a new message instance.
	 */
	public function __construct($email, $subject, $message)
	{
		$this->contactEmail = $email;
		$this->contactSubject = $subject;
		$this->contactMessage = $message;
	}

	/**
	 * Get the message envelope.
	 */
	public function envelope(): Envelope
	{
		return new Envelope(
			from: env('MAIL_FROM_ADDRESS', 'hello@example.com'),
			subject:'Nuevo mensaje de contacto: ' .($this->contactSubject ?? 'Sin asunto'),
		);
	}

	/**
	 * Get the message content definition.
	 */
	public function content(): Content
	{
		return new Content(
			markdown: 'emails.contact',
			with: [
				'email' => $this->contactEmail,
				'subject' => $this->contactSubject,
				'message' => $this->contactMessage,
			],
		);
	}

	/**
	 * Get the attachments for the message.
	 *
	 * @return array<int, \Illuminate\Mail\Mailables\Attachment>
	 */
	public function attachments(): array
	{
		return [];
	}
}
