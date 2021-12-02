<?php


namespace App\Repositories\V1\User;


use App\Models\Category;
use App\Models\Stores;
use App\Models\User;
use App\Repositories\V1\Contracts\MagazaUserRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class MagazaUserRepository implements MagazaUserRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        $users = Stores::query()->orderBy('created_at', 'desc');

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
        $data = request()->except('_token');
        if ($data['category_id']) {
            abort_if(!Category::where('id', $data['category_id'])->first(), 404);
        }
        $time = time();
        $file = request()->file('thumb_nail');
        $ext2 = $file->getClientOriginalExtension();
        $path2 = public_path('/uploads/magazas/' . $time . '.' . $ext2);
        Image::make($file->getRealPath())->save($path2);

        $file2 = request()->file('logo');
        $ext = $file2->getClientOriginalExtension();
        $path = public_path('/uploads/magazas/' . $time . '_logo.' . $ext);
        Image::make($file2->getRealPath())->save($path);
//        $user->full_name = $data['full_name'];
        $user = User::create([
            'email' => $data['username'],
            'password' => $data['password'],
            'ip_address' => request()->ip(),
        ]);
        $magaza = Stores::create([
            'category_id' => $data['category_id'],
            'full_name' => $data['full_name'],
            'about' => $data['about'],
            'url' => $data['url'],
            'active' => isset($data['active']) ? ($data['active'] == 'on' ? true : false) : false,
            'thumb_nail' => $time . '.' . $ext2,
            'logo' => $time . '_logo.' . $ext,
        ]);
        $user->assignRole('seller');
        $user->update([
            'seller_id' => $magaza->id
        ]);
        return ['success' => "Ugurla Elave olundu"];
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
        $user = Stores::where('id', $id)->first();
        abort_if(!$user, 404);
        $time = time();
        $ext = null;
        $ext2 = null;
        if ($data['category_id']) {
            abort_if(!Category::where('id', $data['category_id'])->first(), 404);
        }

        $store_admin = User::where('id', $data['user_id'])->where('seller_id', $user->id)->orderBy('id')->first();
        abort_if(!$store_admin, 404);

        if (isset($data['thumb_nail'])) {
            if ($data['thumb_nail']) {
                File::delete(public_path('uploads/magazas/') . $user->thumb_nail);
                $file = request()->file('thumb_nail');
                $ext = $file->getClientOriginalExtension();
                $path = public_path('/uploads/magazas/' . $time . '.' . $ext);
                Image::make($file->getRealPath())->save($path);
                $user->thumb_nail = $time . '.' . $ext;
            }
        }
        if (isset($data['logo'])) {
            if ($data['logo']) {
                File::delete(public_path('uploads/magazas/') . $user->logo);
                $file = request()->file('logo');
                $ext2 = $file->getClientOriginalExtension();
                $path2 = public_path('/uploads/magazas/' . $time . '_logo.' . $ext2);
                Image::make($file->getRealPath())->save($path2);
                $user->logo = $time . '_logo.' . $ext2;
            }
        }
        $user->active = isset($data['active']) ? ($data['active'] == 'on' ? true : false) : false;
        $user->url = $data['url'];
        $user->about = $data['about'];
        $user->full_name = $data['full_name'];
        $user->category_id = $data['category_id'];
        $user->save();
        $store_admin->email = $data['username'];
        if ($data['password_other']) {
            $store_admin->password = $data['password_other'];
        }
        $store_admin->save();

        return response()->json(['success' => "Ugurla Elave olundu"]);
    }

    public function destroy(int $id)
    {
        $store = Stores::where('id', $id)->first();
        abort_if(!$store, 404);
        File::delete(public_path('uploads/magazas/') . $store->thumb_nail);
        File::delete(public_path('uploads/magazas/') . $store->logo);
        foreach (User::where('seller_id', $store->id)->get() as $item) {
            $item->removeRole($item->roles[0]->name);
            $item->delete();
        }
        $store->delete();
    }
}
