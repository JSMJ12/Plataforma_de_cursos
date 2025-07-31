<?php

// app/Notifications/CapacitadorAccepted.php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class CapacitadorAccepted extends Notification
{
    use Queueable;

    protected $user;
    protected $password;
    protected $loginToken;

    public function __construct($user, $password, $loginToken)
    {
        $this->user = $user;
        $this->password = $password;
        $this->loginToken = $loginToken;
    }

    public function toMail($notifiable)
    {
        $loginUrl = route('login.token', ['token' => $this->loginToken]);

        return (new MailMessage)
            ->subject('Capacitador Aceptado')
            ->greeting('¡Hola ' . $this->user->name . '!')
            ->line('Tu solicitud para ser capacitador ha sido aceptada.')
            ->line('Puedes acceder al sistema usando el siguiente enlace:')
            ->action('Acceder al Sistema', $loginUrl)
            ->line('Tu contraseña es: ' . $this->password)
            ->line('Si el enlace no funciona, usa la contraseña proporcionada para iniciar sesión.')
            ->line('Gracias por tu paciencia.');
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

}
