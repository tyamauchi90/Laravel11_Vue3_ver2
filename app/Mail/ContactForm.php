<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactForm extends Mailable
{
  use Queueable, SerializesModels;

  public $inputs;

  /**
   * Create a new message instance.
   *
   * @param array $inputs
   */
  public function __construct($inputs)
  {
    $this->inputs = $inputs;
  }

  /**
   * Get the message envelope.
   */
  public function envelope(): Envelope // 封筒
  {
    $fromAddress = config('mail.from.address');
    $fromName = config('mail.from.name');
    $bccAddress = config('mail.bcc.address');
    $bccName = config('mail.bcc.name');

    return new Envelope(
      subject: 'お問い合わせを受け付けました',
      from: new Address($fromAddress, $fromName),
      to: [new Address($this->inputs['email'], '送信先')],
      bcc: [new Address($bccAddress, $bccName)],
    );
  }

  /**
   * Get the message content definition.
   */
  public function content(): Content
  {
    return new Content(
      view: 'emails.contactResponse',
    );
  }

  /**
   * Get the attachments for the message.
   *
   * @return array<int, \Illuminate\Mail\Mailables\Attachment>
   */
  public function attachments(): array
  {
    // ここに添付ファイルを追加するコードを記述します。
    return [];
  }
}


// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Address;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;

// class ContactForm extends Mailable
// {
//   use Queueable, SerializesModels;

//   public $inputs;

//   /**
//    * Create a new message instance.
//    *
//    * @param array $inputs
//    */
//   public function __construct($inputs)
//   {
//     $this->inputs = $inputs;
//   }

//   /**
//    * Build the message.
//    */
//   public function build()
//   {
//     return $this->to($this->inputs['email'])
//       ->bcc('pecopon24@gmail.com')
//       ->view('emails.contactResponse')
//       ->subject('お問い合わせを受け付けました');
//   }
