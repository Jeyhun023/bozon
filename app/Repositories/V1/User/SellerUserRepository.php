<?php


namespace App\Repositories\V1\User;


use App\Models\Role;
use App\Models\User;
use App\Repositories\V1\Contracts\AdminUserRepositoryInterface;
use App\Repositories\V1\Contracts\SellerUserRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SellerUserRepository implements SellerUserRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
//        dd(Auth::guard('seller')->user()->seller_id);
        $users = User::query()->where('seller_id', Auth::guard('seller')->user()->seller_id)->orderBy('created_at', 'desc');
//dd("Kam");
        $users = app(Pipeline::class)
            ->send($users)
            ->through([
                \App\QueryFilters\FullName::class,
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
        $user->password = $data['password'];
        $user->full_name = $data['full_name'];
        $user->email = $data['email'];
        $user->ip_address = request()->ip();
        $user->seller_id = Auth::guard('seller')->user()->seller_id;
        $user->save();
        $user->assignRole('seller');
        return response()->json(['success' => "Ugurla Elave olundu"]);
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
        $user = User::where('id', $id)->where('seller_id', Auth::guard('seller')->user()->seller_id)->first();
        abort_if(!$user, 404);
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
        $user = User::where('id', $id)->where('seller_id', Auth::guard('seller')->user()->seller_id)->first();
        abort_if(!$user, 404);
        $user->removeRole('seller');
        $user->delete();
    }
}
