<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\AdminUserRequest;
use App\Http\Requests\Admin\V1\ClientRequest;
use App\Http\Requests\Admin\V1\SellerUserRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\V1\Contracts\AdminUserRepositoryInterface;
use App\Repositories\V1\Contracts\SellerUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SellerUsersController extends Controller
{
    private $auhtRepository;

    public function __construct(SellerUserRepositoryInterface $auhtRepository)
    {
        $this->auhtRepository = $auhtRepository;
    }

    public function index()
    {
        $users = $this->auhtRepository->index();
        return view('admin.seller_user.index', compact('users'));
    }

    public function create()
    {
        //
    }

    public function store(SellerUserRequest $request)
    {
        return $this->auhtRepository->store($request->all());
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(SellerUserRequest $request, $client)
    {
        return $this->auhtRepository->update($client, $request->all());
    }

    public function destroy($client)
    {
        $this->auhtRepository->destroy($client);
        return Redirect::route('seller_users.index');
    }

    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'present']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            foreach (User::whereIn('id', $array)->get() as $item) {
                $this->auhtRepository->destroy($item->id);
            }
        }
        return response()->json(['message' => 'Əməliyyat uğurla tamamlandı.'], 200);
    }
}
