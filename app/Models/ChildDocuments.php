<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
class ChildDocuments extends Model implements HasMedia
{
    use InteractsWithMedia;
    protected $table = "child_documents";


    protected $fillable = [
        'fk_ChildID',
        'type',
        'description',
        'date',
        'renewal_date',
        'recurring'


    ];

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('preview')
            ->fit(Manipulations::FIT_CROP, 300, 300)
            ->nonQueued();
    }

    public function getChildren() {

        return $this->hasMany(Child::class,'id','fk_ChildID')->orderBy('initials');

    }

}
