<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait HasImgUrl
{
    /**
     * Get the URL to the images.
     *
     * @return string
     */
    public function getImgUrlAttribute()
    {

        return Storage::url($this->img_path);
        // return $this->img_path ? Storage::url($this->img_path) : $this->img_path;

        // return $this->img_path
        //     ? Storage::disk($this->profilePhotoDisk())->url($this->img_path)
        //     : $this->defaultProfilePhotoUrl();
    }
}
