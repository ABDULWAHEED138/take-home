<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Article extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
//        'publish_at' => 'datetime',
    ];

    public function sources(): HasOne
    {
        return $this->hasOne(Source::class);
    }

    public function category(): HasOne
    {
        return $this->hasOne(Category::class);
    }
}
