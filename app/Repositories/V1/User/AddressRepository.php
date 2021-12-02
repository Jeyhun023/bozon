<?php


namespace App\Repositories\V1\User;


use App\Models\UserAddress;
use App\Repositories\V1\Contracts\AddressRepositoryInterface;
use App\Traits\ApiResponder;

class AddressRepository implements AddressRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
       $this->data = auth()->user()->addresses;
       return $this->returnData();
    }

    public function store(array $data)
    {
        $user = auth()->user();
        $address = new UserAddress;
        $address->fill($data);
        $user->addresses()->save($address);
        if ($user->addresses()->count() == 1) {
            $address->update(['is_default' => true]);
        }
        $address->load('city');
        $this->data = $address;

       return $this->returnData();
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
        $user = auth()->user();
        $address  = UserAddress::findOrFail($id);
        if ($user->id == $address->user_id){
            $address->fill($data);
            $address->update();

            $this->data = $address;
        }
        return $this->returnData();
    }

    public function destroy(int $id)
    {
        $user = auth()->user();
        $address  = UserAddress::findOrFail($id);
        if ($user->id == $address->user_id){
            if ($address->is_default) {
                if ($user->addresses->count() > 1) {
                    $user->addresses()->where('id', '!=', $address->id)->first()->update(['is_default' => true]);
                }
            }
            $address->delete();
            $this->data = $address;
        }
        return $this->returnData();
    }

    public function setDefault($id)
    {
        $user = auth()->user();
        $address  = UserAddress::findOrFail($id);
        if ($user->id == $address->user_id){
            $user->addresses()->update(['is_default' => 0]);
            $address->update(['is_default' => 1]);
            $this->data = $address;
        }

        return $this->returnData();
    }
}
