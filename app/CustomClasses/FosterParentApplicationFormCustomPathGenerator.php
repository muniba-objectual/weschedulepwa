<?php
namespace App\CustomClasses;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;


class FosterParentApplicationFormCustomPathGenerator implements PathGenerator
{
public function getPath(Media $media) : string
{
  //  if ($media->getCustomProperty('familyMemberID')) {
 //       return 'FosterParentApplicationForm/' . $media->id . "/" .  $media->collection_name . '/' . $media->getCustomProperty('familyMemberID') . "/";
 //   } else {
//        return 'FosterParentApplicationForm/' . $media->id . "/" .  $media->collection_name . '/';
    //}

    return 'FosterParentApplicationForm/' . $media->id . "/" .  $media->collection_name . '/';

}

public function getPathForConversions(Media $media) : string
{
return $this->getPath($media) . 'conversions/';
}

public function getPathForResponsiveImages(Media $media): string
{
return $this->getPath($media) . 'responsive/';
}
}
