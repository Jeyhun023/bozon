<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\MagazaUserRequest;
use App\Models\Category;
use App\Models\Stores;
use App\Repositories\V1\Contracts\MagazaUserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginedStoreController extends Controller
{
    private $auhtRepository;

    public function __construct(MagazaUserRepositoryInterface $auhtRepository)
    {
        $this->auhtRepository = $auhtRepository;
//        abort_if(!Auth::guard('seller')->check(), 404);
    }

    public function edit(Stores $store)
    {
        $category = Category::orderBy('parent_id')->with(['children2' => function ($query) {
            $query->select('id', 'parent_id', 'name');
        }])->select('id', 'parent_id', 'name')->get();

        return view('admin.logined_store.edit', compact('store', 'category'));
    }

    public function update(MagazaUserRequest $request, $store)
    {
        $this->auhtRepository->update($store, $request->all());
        return Redirect::route('logined.store.edit', ['store' => $store])->with(['success' => true]);
    }
}
