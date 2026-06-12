<?php

namespace App\Http\Controllers\Admin;

use App\Enums\FlashMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BannerUpdateRequest;
use App\Services\BannerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BannerController extends Controller
{

    public function edit(BannerService $bannerService): View
    {
        return view('admin.banner', [
            'banner' => $bannerService->getBanner(),
        ]);
    }

    public function update(BannerUpdateRequest $request, BannerService $bannerService): RedirectResponse
    {
        $bannerService->update(
            $request->only('title'),
            $request->file('image')
        );

        return redirect()
            ->route('admin.banner.edit')
            ->with('success', FlashMessage::BANNER_CREATED->value);
    }
}
