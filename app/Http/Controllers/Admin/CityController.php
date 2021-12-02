<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\CityRequest;
use App\Models\City;
use App\Repositories\V1\Contracts\CityRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CityController extends Controller
{
    private $cityRepository;

    public function __construct(CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function index()
    {
        $result = $this->cityRepository->index();
        return $this->sendResourceResponse($result,CityResource::class);
    }

    public function FilterCitiesForAdmin()
    {
        if(request()->has('parent_id') && request()->input('next') == "Rayonlar"){
            $parent_id = request()->input('parent_id');
            $next = "Nişangah";
        }elseif(request()->has('parent_id') && request()->input('next') == "Nişangah"){
            $parent_id = request()->input('parent_id');
            $next = "";
        }else{
            $parent_id = 0;
            $next = "Rayonlar";
        }
        $cities = $this->cityRepository->FilterCitiesForAdmin($parent_id); 
        return view('admin.cities.index', compact('cities','parent_id', 'next'));
    }

    public function store(CityRequest $request)
    {
        return $this->cityRepository->store([]);
    }

    public function update_city(CityRequest $request)
    {
        return $this->cityRepository->update($request->city_id, []);
    }

    public function destroy($city)
    {
        $this->cityRepository->destroy($city);
        return redirect()->back();
    }

    public function update_city_visibility(City $city)
    {
        $city->update([
            'visible' => !$city->visible
        ]);
        return redirect()->back();
    }

    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'present']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            foreach ($array as $i) {
                $this->cityRepository->destroy($i);
            }
        }
        return response()->json(['message' => 'Əməliyyat uğurla tamamlandı.'], 200);
    }
}
