<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\BannerRequest;
use App\Models\Banner;
use App\Repositories\V1\Contracts\BannerRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
{
    private $bannerRepository;

    public function __construct(BannerRepositoryInterface $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function index()
    {
        $banners = $this->bannerRepository->index();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(BannerRequest $request)
    {
        return $this->bannerRepository->store([]);
    }

    public function update_banner(BannerRequest $request)
    {
        return $this->bannerRepository->update($request->banner_id, []);
    }

    public function destroy($banner)
    {
        $this->bannerRepository->destroy($banner);
        return Redirect::route('banners.index');
    }

    public function update_banner_visibility(Banner $banner)
    {
        $banner->update([
            'visible' => !$banner->visible
        ]);
        return Redirect::route('banners.index');
    }


    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'present']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            foreach ($array as $i) {
                $this->bannerRepository->destroy($i);
            }
        }
        return response()->json(['message' => 'Əməliyyat uğurla tamamlandı.'], 200);
    }
}
