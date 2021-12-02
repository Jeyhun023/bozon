<?php


namespace App\Repositories\V1\Product;


use App\Models\Banner;
use App\Repositories\V1\Contracts\BannerRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class BannerRepository implements BannerRepositoryInterface
{
    use ApiResponder;

    public function getAllBanners()
    {
        $banners = Banner::visible(true)->get();
        $this->data = $banners;
        return $this->returnData();
    }

    public function index()
    {
        return Banner::orderByDesc('created_at')->paginate(getPaginationLimit());
    }

    public function store(array $data)
    {
        $time = time();
        $file = request()->file('main_image');
        $ext = $file->getClientOriginalExtension();
        $file_thumb = request()->file('main_image');
        $path = public_path('uploads/banners/' . $time . '.' . $ext);
        $path2 = public_path('uploads/banners/' . $time . '_thumb.' . $ext);
        Image::make($file->getRealPath())->save($path);
        $thumb = Image::make($file_thumb->getRealPath())->resize(300, 300)->save($path2);

        Banner::create([
            'main_image' => $time . '.' . $ext,
            'thumb_image' => $time . '_thumb.' . $ext,
            'url' => request('url'),
            'title' => request('title'),
            'sira' => request('sira'),
        ]);

        return response()->json(['success' => "Ugurla Elave olundu"]);
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
        $banner = Banner::where('id', $id)->first();
        abort_if(!$banner, 404);
        if (request('main_image')) {
            File::delete(public_path('uploads/banners/') . $banner->getRawOriginal('thumb_image'));
            File::delete(public_path('uploads/banners/') . $banner->getRawOriginal('main_image'));
            $time = time();
            $file = request()->file('main_image');
            $ext = $file->getClientOriginalExtension();
            $file_thumb = request()->file('main_image');
            $path = public_path('uploads/banners/' . $time . '.' . $ext);
            $path2 = public_path('uploads/banners/' . $time . '_thumb.' . $ext);
            Image::make($file->getRealPath())->save($path);
            Image::make($file_thumb->getRealPath())->resize(300, 300)->save($path2);
            $banner->update([
                'main_image' => $time . '.' . $ext,
                'thumb_image' => $time . '_thumb.' . $ext
            ]);
        }
        $banner->update([
            'url' => request('url'),
            'title' => request('title'),
            'sira' => request('sira')
        ]);
        return response()->json(['success' => "Ugurla Redacte olundu"]);
    }

    public function destroy(int $id)
    {
        $banner = Banner::where('id', $id)->first();
        abort_if(!$banner, 404);
        File::delete(public_path('uploads/banners/') . $banner->getRawOriginal('thumb_image'));
        File::delete(public_path('uploads/banners/') . $banner->getRawOriginal('main_image'));
        $banner->delete();
    }
}
