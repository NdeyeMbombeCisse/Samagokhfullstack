<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Projet;

class NewProjectNotification extends Notification
{
    use Queueable;

    protected $projet;

    /**
     * Create a new notification instance.
     */
    public function __construct(Projet $projet)
    {
        $this->projet = $projet;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable)
    {
        return ['database', 'mail']; // On peut ajouter 'broadcast' si vous souhaitez des notifications en temps réel
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Un nouveau projet a été publié : ' . $this->projet->titre)
                    ->action('Voir le projet', url('/details/projet/' . $this->projet->id))
                    ->line('Merci d\'utiliser notre application!');
    }

    /**
     * Get the array representation of the notification.
     */
    public function toArray($notifiable)
    {
        return [
            'projet_id' => $this->projet->id,
            'titre' => $this->projet->titre,
            'description' => $this->projet->description,
        ];
    }
}
