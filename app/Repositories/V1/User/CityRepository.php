<?php


namespace App\Repositories\V1\User;


use App\Models\City;
use App\Repositories\V1\Contracts\CityRepositoryInterface;
use App\Traits\ApiResponder;

class CityRepository implements CityRepositoryInterface
{
    use ApiResponder;

    public function getAllCities()
    {
        $cities = City::visible(true)->with('children')->get();
        $this->data = $cities;
        return $this->returnData();
    }

    public function index()
    {
        $cities = City::visible(true)->with('children')->get();
        $this->data = $cities;
        return $this->returnData();
    }

    public function FilterCitiesForAdmin($parent_id = 0)
    {
        return City::where('parent_id', $parent_id)->orderByDesc('created_at')->paginate(getPaginationLimit());
    }

    public function store(array $data)
    {
        City::create([
            'parent_id' => request('parent_id'),
            'name' => request('name'),
            'deliver_price' => request('price'),
            'visible' => true,
        ]);

        return response()->json(['success' => "Ugurla Elave olundu"]);
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
        $city = City::where('id', $id)->first();
        abort_if(!$city, 404);
        $city->update([
            'name' => request('name'),
            'price' => request('price')
        ]);
        return response()->json(['success' => "Ugurla Redacte olundu"]);
    }

    public function destroy(int $id)
    {
        $city = City::where('id', $id)->first();
        abort_if(!$city, 404);
        $city->delete();
    }
}
