<?php


namespace App\Repositories\V1\Others;


use App\Models\Banner;
use App\Models\Blog;
use App\Models\Stores;
use App\Models\User;
use App\Repositories\V1\Contracts\BannerRepositoryInterface;
use App\Repositories\V1\Contracts\BlogRepositoryInterface;
use App\Repositories\V1\Contracts\CrudInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BlogRepository implements BlogRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        $blogs = Blog::query()->orderBy('created_at', 'desc');

        $blogs = app(Pipeline::class)
            ->send($blogs)
            ->through([
                \App\QueryFilters\Title::class
            ])
            ->thenReturn()
            ->paginate(getPaginationLimit());
        return $blogs;
    }

    public function store(array $data)
    {
        $blog = new Blog();
        $data = request()->except('_token');

        $time = time();
        $file = request()->file('thumb_nail');
        $ext = $file->getClientOriginalExtension();
        $path = public_path('/uploads/blogs/') . $time . '.' . $ext;
        Image::make($file->getRealPath())->save($path);
        $blog->title = $data['title'];
        $blog->url = $data['url'];
        $blog->description = $data['about'];
        $blog->thumb_nail = $time . '.' . $ext;
        $blog->slug = Str::slug($data['title']);
        $blog->active = isset($data['active']) ? ($data['active'] == 'on' ? true : false) : false;;
        $blog->save();
        return ['success' => "Ugurla Elave olundu"];
    }

    public function show($slug)
    {
        $blog = Blog::firstWhere('slug',$slug);

        if ($blog){
            $this->data = $blog;
        } else {
            $this->status = JsonResponse::HTTP_NOT_FOUND;
            $this->message = trans('messages.model_not_found');
        }

        return $this->returnData();
    }

    public function update(int $id, array $data)
    {
        $blog = Blog::where('id', $id)->first();
        abort_if(!$blog, 404);
        if (isset($data['thumb_nail'])) {
            if ($data['thumb_nail']) {
                File::delete(public_path('uploads/blogs/') . $blog->thumb_nail);
                $time = time();
                $file = request()->file('thumb_nail');
                $ext = $file->getClientOriginalExtension();
                $path = public_path('/uploads/blogs/' . $time . '.' . $ext);
                Image::make($file->getRealPath())->save($path);
                $blog->thumb_nail = $time . '.' . $ext;
            }
        }
        $blog->title = $data['title'];
        $blog->slug = Str::slug($data['title']);
        $blog->active = isset($data['active']) ? ($data['active'] == 'on' ? true : false) : false;
        $blog->url = $data['url'];
        $blog->description = $data['about'];
        $blog->save();
        return response()->json(['success' => "Ugurla Redacte olundu"]);
    }

    public function destroy(int $id)
    {
        $blog = Blog::where('id', $id)->first();
        abort_if(!$blog, 404);
        File::delete(public_path('uploads/blogs/') . $blog->thumb_nail);
        $blog->delete();
    }

    public function getActiveBlogs()
    {
        $blogs = Blog::whereActive(1)->orderBy('created_at', 'desc')->paginate(6);
        $this->data = $blogs;
        return $this->returnData();
    }
}
