<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Support\Str;

class DynamicTemplateMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectLine;
    public $markdownContent;
    public $themeColor;
    public $email;

    public function __construct($template, $data = [])
    {
        $this->subjectLine = $this->parseString($template->subject, $data);
        
        $parsedContent = $this->parseString($template->content, $data);
        $this->markdownContent = Str::markdown($parsedContent);
        $this->email = $data['email'] ?? null;
        
        // Capture the color, fallback to neon green if missing
        $this->themeColor = $template->theme_color ?? '#00ff88'; 
    }

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->subjectLine);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.dynamic',
            with: [
                'themeColor' => $this->themeColor,
            ]
        );
    }

    private function parseString($string, $data)
    {
        foreach ($data as $key => $value) {
            $string = str_replace('{{ ' . $key . ' }}', $value, $string);
            $string = str_replace('{{' . $key . '}}', $value, $string);
        }
        return $string;
    }
}