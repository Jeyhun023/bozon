<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\BlogRequest;
use App\Http\Requests\Admin\V1\MagazaUserRequest;
use App\Models\Blog;
use App\Models\Stores;
use App\Models\User;
use App\Repositories\V1\Others\BlogRepository;
use App\Repositories\V1\User\MagazaUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BlogController extends Controller
{
    private $auhtRepository;

    public function __construct(BlogRepository $auhtRepository)
    {
        $this->auhtRepository = $auhtRepository;
    }

    public function index()
    {
        $blogs = $this->auhtRepository->index();
        return view('admin.blog.index', compact('blogs'));
    }

    public function create()
    {
        return view('admin.blog.create');
    }

    public function store(BlogRequest $request)
    {
        $result = $this->auhtRepository->store($request->all());
        if (array_key_exists('success', $result)) {
            return Redirect::route('blogs.index');
        } else {
            \redirect()->back()->withErrors(['danger' => "Xeta bas verdi"]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Blog $blog)
    {
        return view('admin.blog.edit', compact('blog'));
    }

    public function update(BlogRequest $request, $blog)
    {
        $this->auhtRepository->update($blog, $request->all());
        return Redirect::route('blogs.index');
    }

    public function destroy($magaza)
    {
        $this->auhtRepository->destroy($magaza);
        return Redirect::route('blogs.index');
    }

    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'present']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            foreach (Blog::whereIn('id', $array)->get() as $item) {
                $this->auhtRepository->destroy($item->id);
            }
        }
        return response()->json(['message' => 'Əməliyyat uğurla tamamlandı.'], 200);
    }

    public function update_blog_visibility(Blog $blog)
    {
        $blog->update([
            'active' => !$blog->active
        ]);
        return Redirect::route('blogs.index');
    }
}
