<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\CategoryRequest;
use App\Models\Category;
use App\Repositories\V1\Contracts\AdminCategoryRepositoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(AdminCategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $category = $this->categoryRepository->index();
        return view('admin.category.index', compact('category'));
    }

    public function create()
    {
        $category = Category::where('parent_id', 0)->orderBy('parent_id')->with(['children2' => function ($query) {
            $query->select('id', 'parent_id', 'name');
        }])->select('id', 'parent_id', 'name')->get();

        return view('admin.category.create', compact('category'));
    }

    public function store(CategoryRequest $request)
    {
        $res = $this->categoryRepository->store($request->all());
        if (isset($res['error'])) {
            return redirect()->back()->with(['danger' => "Bu ad artiq istifade olunub"], 403);
        }
        return redirect()->route('category.index');
    }

    public function update($category, CategoryRequest $request)
    {
        $res = $this->categoryRepository->update($category, []);
        if (isset($res['error'])) {
            return redirect()->back()->with(['danger' => "Bu ad artiq istifade olunub"], 403);
        }
        return redirect()->route('category.index');
    }

    public function edit(Category $category)
    {
        $categorys = Category::where('parent_id', 0)->orderBy('parent_id')->with(['children2' => function ($query) {
            $query->select('id', 'parent_id', 'name');
        }])->select('id', 'parent_id', 'name')->get();
        return view('admin.category.edit')->with(['cat' => $category, 'category' => $categorys]);
    }

    public function destroy($banner)
    {
        $this->categoryRepository->destroy($banner);
        return redirect()->route('category.index');
    }

    public function update_category_visibility(Category $category)
    {
        $category->update([
            'visible' => !$category->visible
        ]);
        return redirect()->route('category.index');
    }

    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'present']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            foreach ($array as $i) {
                $this->categoryRepository->destroy($i);
            }
        }
        return response()->json(['message' => 'Əməliyyat uğurla tamamlandı.'], 200);
    }
}
