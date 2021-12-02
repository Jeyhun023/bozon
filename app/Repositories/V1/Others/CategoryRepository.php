<?php


namespace App\Repositories\V1\Others;


use App\Models\Category;
use App\Models\Product;
use App\Repositories\V1\Contracts\AdminCategoryRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use \Illuminate\Support\Str;

class CategoryRepository implements AdminCategoryRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        return Category::where('parent_id', 0)->orderBy('parent_id')->with('children')->get();
    }

    public function store(array $data)
    {
        $file_name = null;
        if (request()->file('banner')) {
            $time = time();
            $file = request()->file('banner');
            $ext = $file->getClientOriginalExtension();
            $path = public_path('uploads/categories/' . $time . '.' . $ext);
            Image::make($file->getRealPath())->save($path);
            $file_name = $time . '.' . $ext;
        }

        abort_if(request('parent_id') && !Category::where('id', request('parent_id'))->first(), 404);

        $slug = Str::slug(request('name'));
        $dub = Category::where('slug', $slug)->first();
        if ($dub) {
            return ['error' => "Bu ad artiq istifade olunub"];
        }

        Category::create([
            'parent_id' => request('parent_id') ?? 0,
            'banner' => $file_name,
            'name' => request('name'),
            'slug' => $slug,
            'meta_title' => request('meta_title'),
            'meta_desc' => request('meta_desc'),
            'sort' => request('sort'),
            'visible' => request()->has('visible') ? (request('visible') == 'on' ? true : false) : false,
        ]);

        return ['success' => "Ugurla Elave olundu"];
    }

    /**
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
    }

    public function update(int $id, array $data)
    {
        $category = Category::findOrFail($id);

        $file_name = $category->getRawOriginal('banner');
        if (request()->file('banner')) {
            File::delete($category->banner);
            $time = time();
            $file = request()->file('banner');
            $ext = $file->getClientOriginalExtension();
            $path = public_path('uploads/categories/' . $time . '.' . $ext);
            Image::make($file->getRealPath())->save($path);
            $file_name = $time . '.' . $ext;
        }

        abort_if(request('parent_id') && !Category::where('id', request('parent_id'))->first(), 404);

        $slug = Str::slug(request('name'));
        $dub = Category::where('slug', $slug)->where('id', '!=', $category->id)->first();
        if ($dub) {
            return ['danger' => "Bu ad artiq istifade olunub"];
        }
        $category->update([
            'parent_id' => request('parent_id') ?? 0,
            'banner' => $file_name,
            'name' => request('name'),
            'slug' => $slug,
            'meta_title' => request('meta_title'),
            'meta_desc' => request('meta_desc'),
            'sort' => request('sort'),
            'visible' => request()->has('visible') ? (request('visible') == 'on' ? true : false) : false,
        ]);

        return ['success' => "Redacte olundu"];
    }

    public function destroy(int $id)
    {
        $cat = Category::where('id', $id)->orderBy('parent_id')->with(['children2' => function ($query) {
            $query->select('id', 'parent_id', 'name');
        }])->first();
        if (count($cat->children)) {
            $this->foorCategoryDelete($cat->children);
        }
        Product::where('category_id', $cat->id)->update([
            'category_id' => null
        ]);
        File::delete($cat->banner);
        $cat->delete();
    }

    function foorCategoryDelete($items)
    {
        foreach ($items as $item) {
            File::delete($item->banner);
            Product::where('category_id', $item->id)->update([
                'category_id' => null
            ]);
            if (count($item->children)) {
                $this->foorCategoryDelete($item->children);
            }
            $item->delete();
        }
    }
}
