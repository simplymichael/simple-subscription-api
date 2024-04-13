<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'body',
        'website_id',
        'notifications_sent'
    ];

    public function website() {
      return $this->belongsTo(Website::class);
    }
}
