<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Website;
use App\Jobs\SendNotifications;
use App\Notifications\PostPublished;

class ProcessNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:process-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Queue notifications to be sent to subscribed users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
      $websites = Website::all();

      collect($websites)->map(function($website) {
        // Prepare data for queueing the notificaton
        $subscribers = $website->subscribers;
        $posts = $website->posts()->where('notifications_sent', 0)->get();

        collect($posts)->map(function($post) use(&$website, &$subscribers) {
          $notification = new PostPublished($post, $website); // PostPublished notification

          // Add the notification to the queue.
          // Dispatch the SendNotifications job
          SendNotifications::dispatch($subscribers, $notification);

          $post->notifications_sent = 1;
          $post->save();
        });
      });
    }
}
