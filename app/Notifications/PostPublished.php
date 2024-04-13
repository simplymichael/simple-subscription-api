<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Post;
use App\Models\Website;

class PostPublished extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(Post $post, Website $website)
    {
        $this->post = $post;
        $this->website = $website;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                ->line("New post '$post->title' published on website $website.")
                //->action('Click to view post', url("/posts/$post->id"))
                ->line("A new post '$post->title' has been published on website '$website->url'!")
                ->line("Summary: $post->description");
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
