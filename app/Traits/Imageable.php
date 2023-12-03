<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Storage;
use Modules\Image\Models\Image;

trait Imageable
{
    /**
     * @return MorphMany
     */
    public function images(): morphMany
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    /**
     * @return MorphOne
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function addImages($images, $folderPath): void
    {
        foreach ($images as $image) {
            $this->addImage($image['image'], $folderPath);
        }
    }

    public function addImage($image, $folderPath): void
    {
        $this->image()->create(
            [
                'image' => $image->store($folderPath, 'public'),
            ]
        );

    }

    //Update single image
    public function updateImage($image, $folderPath): void
    {
        if ($this->image) {
            $this->deleteImage($this->image->image);
            $this->image()->delete();
        }
        $this->addImage($image, $folderPath);
    }

    protected function deleteImage($path): void
    {
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
