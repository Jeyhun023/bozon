<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\FeatureRequest;
use App\Models\FeatureSchema;
use App\Repositories\V1\Contracts\FeatureRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class FeatureController extends Controller
{
    private $featureRepository;

    public function __construct(FeatureRepositoryInterface $featureRepository)
    {
        $this->featureRepository = $featureRepository;
    }

    public function FilterFeaturesForAdmin($id)
    {
        $features = $this->featureRepository->FilterFeaturesForAdmin($id); 
        return view('admin.features.index', compact('features','id'));
    }

    public function create($id)
    {
        return view('admin.features.create',compact('id'));
    }


    public function store(FeatureRequest $request)
    {
        return $this->featureRepository->store($request->except('_token'));
        return redirect()->route('features.index', ['category_id', $id]);
    }

    public function edit($id, FeatureSchema $feature)
    {
        return view('admin.features.edit', compact('feature', 'id'));
    }

    public function update($cat, $id, FeatureRequest $request)
    {
        return $this->featureRepository->update($id, $request->except('_token','_method'));
    }

    public function destroy($feature, $id)
    {
        $this->featureRepository->destroy($id);
        return redirect()->back();
    }

    public function destroyFeatureValue($id)
    {
        $this->featureRepository->destroyFeatureValue($id);
        return redirect()->back();
    }

    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'present']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            foreach ($array as $i) {
                $this->featureRepository->destroy($i);
            }
        }
        return response()->json(['message' => 'Əməliyyat uğurla tamamlandı.'], 200);
    }

    public function update_features_visibility($id)
    {
        $feature = FeatureSchema::where('id', $id)->first();
        $feature->update(['visible' => 1 - $feature->visible]);
      
        return redirect()->back();
    }
}
