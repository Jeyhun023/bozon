<?php


namespace App\Repositories\V1\User;


use App\Models\FeatureSchema;
use App\Models\FeatureSchemaValue;
use App\Repositories\V1\Contracts\FeatureRepositoryInterface;
use App\Traits\ApiResponder;

class FeatureRepository implements FeatureRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        $features = FeatureSchema::visible(true)->with('values')->get();
        $this->data = $features;
        return $this->returnData();
    }

    public function FilterFeaturesForAdmin($category_id)
    {
        $features = FeatureSchema::where('category_id', $category_id)->orderByDesc('created_at')->get();
        return $features;
    }

    public function getFeaturesByCategory($categoryId)
    {
        $features = FeatureSchema::visible(true)
            ->with('values')
            ->where('category_id',$categoryId)
            ->orderBy('sort','asc')
            ->get();
        $this->data = $features;
        return $this->returnData();
    }

    public function store(array $data)
    {
        foreach(request()->except('_token') as $item){
            $schema_id = FeatureSchema::create([
                    'category_id' => request()->category_id,
                    'visible' => true,
                    'name' => $item['name'],
                    'sort' => $item['sort']
                ]);
            
            if (!empty($item['values'])) {
                foreach($item['values'] as $key => $value){
                    if($value != null){
                        FeatureSchemaValue::create([
                            'schema_id' => $schema_id->getAttribute('id'),
                            'name' => $value
                        ]);
                    }
                }
            }

        }
        return response()->json(['success' => "Ugurla Elave olundu"]);
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
        $feature = FeatureSchema::findOrFail($id);
        $feature->update([
            'name' => $data[1]['name'],
            'sort' => $data[1]['sort']
        ]);
        if(!empty($data['edit'])){
            foreach($data['edit'] as $key => $value){
                if($value != null){
                    FeatureSchemaValue::where('id', $key)->update([
                        'name' => $value
                    ]);
                }
            }
        }
        if(!empty($data['1']['values'])){
            foreach($data['1']['values'] as $key => $value){
                if($value != null){
                    FeatureSchemaValue::create([
                        'schema_id' => $id,
                        'name' => $value
                    ]);
                }
            }
        }
        return redirect()->back();
    }

    public function destroy(int $id)
    {
        $feature = FeatureSchema::where('id', $id)->with('values')->first();
        if(!empty($feature->values)){
            foreach($feature->values as $value){
                $value->delete();
            }
        }
        abort_if(!$feature, 404);
        $feature->delete();
    }
    
    public function destroyFeatureValue(int $id)
    {
        $value = FeatureSchemaValue::findOrFail($id);
        $value->delete();
    }
}
