<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\MagazaUserRequest;
use App\Models\Category;
use App\Models\Stores;
use App\Models\User;
use App\Repositories\V1\Contracts\MagazaUserRepositoryInterface;
use App\Repositories\V1\User\MagazaUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class MagazaController extends Controller
{
    private $auhtRepository;

    public function __construct(MagazaUserRepositoryInterface $auhtRepository)
    {
        $this->auhtRepository = $auhtRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->auhtRepository->index();
        return view('admin.magaza_users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::orderBy('parent_id')->with(['children2' => function ($query) {
            $query->select('id', 'parent_id', 'name');
        }])->select('id', 'parent_id', 'name')->get();
        return view('admin.magaza_users.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MagazaUserRequest $request)
    {
        $result = $this->auhtRepository->store($request->all());
        if (array_key_exists('success', $result)) {
            return Redirect::route('magazas.index');
        } else {
            \redirect()->back()->withErrors(['danger' => "Xeta bas verdi"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Stores $magaza)
    {
        $category = Category::orderBy('parent_id')->with(['children2' => function ($query) {
            $query->select('id', 'parent_id', 'name');
        }])->select('id', 'parent_id', 'name')->get();
        $magaza_user = User::where('seller_id', $magaza->id)->orderBy('id')->first();
        return view('admin.magaza_users.edit', compact('magaza', 'category', 'magaza_user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $client
     * @return Redirect
     */
    public function update(MagazaUserRequest $request, $client)
    {
        $this->auhtRepository->update($client, $request->all());
        return Redirect::route('magazas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($magaza)
    {
        $this->auhtRepository->destroy($magaza);
        return Redirect::route('magazas.index');
    }

    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'present']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            foreach (Stores::whereIn('id', $array)->get() as $item) {
                $this->auhtRepository->destroy($item->id);
            }
        }
        return response()->json(['message' => 'Əməliyyat uğurla tamamlandı.'], 200);
    }

    public function update_magaza_visibility(Stores $magaza)
    {
        $magaza->update([
            'active' => !$magaza->active
        ]);
        return Redirect::route('magazas.index');
    }
}
