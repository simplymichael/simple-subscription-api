<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Website;
use App\Models\WebsiteSubscriber;

class WebsiteController extends Controller
{
    public function getWebsitesList() {
      $websites = Website::all();

      return response()->json([
        'success' => true,
        'data' => [
          'websites' => $websites,
        ],
      ]);
    }

    public function getPostsList(Request $request, $website_id) {
      //$posts = Website::with('posts')->find($website_id)
      $posts = Website::find($website_id)->posts();

      return response()->json([
        'success' => true,
        'data' => [
          'posts' => $posts,
        ],
      ]);
    }

    public function addSubscriber(Request $request, $website_id) {
      $subscriber_email = $request->subscriber_email;
      $subscriber_name = $request->subscriber_name;
      $subscriber = User::where('email', $sbuscriber_email);

      if(!$subscriber) {
        $subscriber = User::create([
          'name' => $subscriber_name,
          'email' => $subscriber_email
        ]);
      };

      $subscription = WebsiteSubscriber::create([
        'website_id' => $website_id,
        'subscriber_id' => $subscriber->id,
      ]);
    }
}
