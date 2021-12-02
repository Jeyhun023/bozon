<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\ClientRequest;
use App\Models\User;
use App\Repositories\V1\Contracts\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    private $auhtRepository;

    public function __construct(AuthRepositoryInterface $auhtRepository)
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
        return view('admin.clients.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        return $this->auhtRepository->store($request->all());
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $client
     * @return Redirect
     */
    public function update(ClientRequest $request, $client)
    {
        return $this->auhtRepository->update($client, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($client)
    {
        $this->auhtRepository->destroy($client);
        return Redirect::route('clients.index');
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
