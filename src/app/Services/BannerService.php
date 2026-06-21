<?php

namespace App\Services;

use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    public function getBanner(): ?Banner
    {
        return Banner::query()->first();
    }

    public function update(array $data, ?UploadedFile $image = null): Banner
    {
        $banner = Banner::query()->first() ?? new Banner();

        if ($image) {
            if ($banner->image) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $image->store('banners', 'public');
        }

        $banner->fill($data);
        $banner->save();

        return $banner;
    }
}
