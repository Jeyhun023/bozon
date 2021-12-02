<?php


namespace App\Repositories\V1\User;


use App\Models\Role;
use App\Models\User;
use App\Repositories\V1\Contracts\AdminUserRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;

class AdminUserRepository implements AdminUserRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        $users = User::query()->whereHas('roles', function ($query) {
            $query->whereNotIn('role_id', [2, 3]);
        })->orderBy('created_at', 'desc');

        $users = app(Pipeline::class)
            ->send($users)
            ->through([
                \App\QueryFilters\FullName::class,
                \App\QueryFilters\PhoneNumber::class,
                \App\QueryFilters\CreateDate::class,
            ])
            ->thenReturn()
            ->paginate(getPaginationLimit());
        return $users;
    }

    public function store(array $data)
    {
        $user = new User();
        $data = request()->except('_token');
        $role = Role::where('name', request('role'))->first();
        abort_if(!$role, 404);
        $user->phone_number = $data['phone_number'];
        $user->password = $data['password'];
        $user->full_name = $data['full_name'];
        $user->email = $data['email'];
        $user->ip_address = request()->ip();
        $user->save();
        $user->assignRole($role->name);
        return response()->json(['success' => "Ugurla Elave olundu"]);
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
        $user = User::where('id', $id)->whereHas('roles', function ($query) {
            $query->whereNotIn('role_id', [2, 3]);
        })->first();
        abort_if(!$user, 404);
        if ($data['role']) {
            $role = Role::where('name', request('role'))->first();
            abort_if(!$role, 404);
            $user->removeRole($user->roles[0]->name);
            $user->assignRole(request('role'));
        }
        if ($data['phone_number']) {
            $user->phone_number = $data['phone_number'];
        }
        if ($data['password']) {
            $user->password = $data['password'];
        }
        $user->full_name = $data['full_name'];
        $user->email = $data['email'];
        $user->ip_address = request()->ip();
        $user->save();
        return response()->json(['success' => "Ugurla Elave olundu"]);
    }

    public function destroy(int $id)
    {
        $user = User::where('id', $id)->whereHas('roles', function ($query) {
            $query->whereNotIn('role_id', [2, 3]);
        })->first();
        abort_if(!$user, 404);
        $user->removeRole($user->roles[0]->name);
        $user->delete();
    }
}
