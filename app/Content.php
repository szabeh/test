<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

class Content extends Model implements HasMedia
{
    use SoftDeletes, HasMediaTrait;

    public $table = 'contents';

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'lid',
        'body',
        'rutitr',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    const STATUS_SELECT = [
        'draft'     => 'draft',
        'pending'   => 'pending',
        'published' => 'published',
    ];

    public function registerMediaConversions(Media $media = null)
    {
        $this->addMediaConversion('thumb')->width(50)->height(50);
    }

    public function getImageAttribute()
    {
        $files = $this->getMedia('image');

        $files->each(function ($item) {
            $item->url = $item->getUrl();
        });

        return $files;
    }
}
