<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
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
      $website = Website::find($website_id);
      $posts = $website->posts;

      return response()->json([
        'success' => true,
        'data' => [
          'posts' => $posts,
        ],
      ]);
    }

    public function addSubscriber(Request $request, $website_id) {
      $validator = Validator::make($request->all(), [
         'subscriber_email' => 'required|email',
      ]);

      if($validator->fails()) {
        return response()->json([
          'error' => true,
          'messages' => $validator->errors(),
        ], Response::HTTP_BAD_REQUEST);
      }

      $validated = $validator->validated();

      $data = $validator->safe()->only(['subscriber_email', 'subscriber_name']);
      $subscriber_email = $data['subscriber_email'];
      $subscriber_name = $data['subscriber_name'] ?? '';

      $subscriber = User::where('email', $subscriber_email)->first();

      if(!$subscriber) {
        $subscriber = User::create([
          'name' => $subscriber_name,
          'email' => $subscriber_email
        ]);
      };

      $subscription = WebsiteSubscriber::where([
        ['website_id', $website_id],
        ['subscriber_id', $subscriber->id],
      ])->first();

      if(!$subscription) {
        $subscription = WebsiteSubscriber::create([
          'website_id' => $website_id,
          'subscriber_id' => $subscriber->id,
        ]);
      }

      return response()->json([
        'success' => true,
        'data' => [
          'subscription' => $subscription,
        ],
      ]);
    }
}
