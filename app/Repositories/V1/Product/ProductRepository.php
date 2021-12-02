<?php


namespace App\Repositories\V1\Product;


use App\Models\File;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Models\ProductAttributeVariation;
use App\Models\ProductColor;
use App\Models\ProductFeature;
use App\Models\Variation;
use App\Repositories\V1\Contracts\ProductRepositoryInterface;
use App\Traits\ApiResponder;
use App\Traits\FileUpload;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Str;

class ProductRepository implements ProductRepositoryInterface
{
    use ApiResponder, FileUpload;

    public function index()
    {
        $products = app(Pipeline::class)
            ->send(Product::query()->visible(true))
            ->through([
                \App\QueryFilters\IncludeRelation::class,
                \App\QueryFilters\TextQuery::class,
                \App\QueryFilters\Price::class,
                \App\QueryFilters\Colors::class,
                \App\QueryFilters\Size::class,
                \App\QueryFilters\Discount::class,
                \App\QueryFilters\Category::class,
                \App\QueryFilters\Feature::class,
                \App\QueryFilters\DailyOpportunity::class,
                \App\QueryFilters\MostSale::class,
                \App\QueryFilters\IsNew::class,
                \App\QueryFilters\Store::class,
            ])
            ->thenReturn()
            ->paginate(getPaginationLimit(9));
        $this->data = $products;
        return $this->returnData();
    }

    public function getProductsByStore()
    {
        $sellerUserId = auth('seller')->check() ? auth('seller')->user()->detail->id : 0;

        $products = app(Pipeline::class)
            ->send(Product::query()->with('brand')->where('seller_id',$sellerUserId))
            ->through([
                \App\QueryFilters\TextQuery::class,
            ])
            ->thenReturn()
            ->paginate(getPaginationLimit());
        $this->data = $products;
        return $this->returnData();
    }

    public function getCatalogs()
    {
        $products = app(Pipeline::class)
            ->send(
                Product::with('brand','category')
                    ->whereNull('seller_id')
            )
            ->through([
                \App\QueryFilters\TextQuery::class,
            ])
            ->thenReturn()
            ->paginate(getPaginationLimit());
        $this->data = $products;
        return $this->returnData();
    }

    public function store(array $data)
    {
        $colors = $data['colors'];
        $images = $data['images'];
        $attributes = $data['attributes'];
        $variations = $data['variations'];
        $prices = $data['prices'];
        $qtys = $data['qtys'];

        $meta = $data['meta'];
        $product = new Product;
        $path = null;
        $sellerId = auth('seller')->check() ?  auth('seller')->user()->detail->id : null;
        try {
            if (isset($data['thumbnail'])){
                $path = $this->upload('products',$data['thumbnail'],true,false);
            }
            $product->seller_id = $sellerId;
            $product->visible =  0;
            $product->thumbnail =  $path;
            $product->category_id = $data['category'];
            $product->brand_id = $data['brand'];
            $product->name = $data['title'];
            $product->description = $data['description'];
            $product->meta = json_encode($meta);
            $product->price = $data['price'];
            $product->qty = $data['qty'];
            $product->discount_price = isset($data['discount']) ? $data['discount'] : null;
            $product->discount_type = $data['discount_type'];
            $product->featured = 0;
            $product->sale_count = 0;
            $product->save();
            $product->slug = Str::slug($data['title']) . $product->id;
            $product->save();

            if (isset($data['features'])){
                $features = [];
                foreach ($data['features'] as $label => $feature){
                    if (!is_null($feature)){
                        $features[] = [
                            'product_id' => $product->id,
                            'label' => $label,
                            'feature' => $feature,
                        ];
                    }
                }
                ProductFeature::insert($features);
            }

            if ($images) {
                $images = explode(',', $images);
                File::whereIn('id', $images)->update([
                    'model_id' => $product->id,
                ]);
            }

            if (is_array($colors) && count($colors) > 0) {
                foreach ($colors as $color) {
                    ProductColor::query()->insert([
                        'product_id' => $product->id,
                        'color_id' => $color,
                    ]);
                }
            }

            if (is_array($attributes) && count($attributes) > 0) {
                foreach ($attributes as $attribute) {
                    $pa = ProductAttribute::query()->insertGetId([
                        'product_id' => $product->id,
                        'attribute_id' => $attribute,
                    ]);
                    $vars = json_decode($variations[$attribute]);
                    if (count($vars) > 0) {
                        foreach ($vars as $var) {
                            ProductAttributeVariation::query()->insert([
                                'product_attribute_id' => $pa,
                                'name' => strtoupper($var->value),
                            ]);
                        }
                    }
                }
            }
            $__v = array();
            if ($colors && count($colors) > 0) {
                foreach ($colors as $i => $color) {
                    $firstAttribute = $attributes[0] ?? null;
                    $fv = json_decode($variations[$firstAttribute]);
                    if (isset($firstAttribute) && count($fv) > 0) {
                        foreach ($fv as $key => $firstVariation) {
                            if ($attributes && count($attributes) > 1) {
                                $secondAttribute = $attributes[1];
                                $sv = json_decode($variations[$secondAttribute]);
                                foreach ($sv as $kk => $secondVariation) {
                                    array_push($__v, [
                                        'color' => (int) $color,
                                        'attribute' => (int) $firstAttribute,
                                        'parent' => $firstVariation->value,
                                        'child' => $secondVariation->value,
                                        'price' => (float) $prices[$firstAttribute][$key][$kk],
                                        'qty' => (int) $qtys[$firstAttribute][$key][$kk],
                                    ]);
                                }
                            } else {
                                array_push($__v, [
                                    'color' => (int) $color,
                                    'parent' => $firstVariation->value,
                                    'attribute' => (int) $firstAttribute,
                                    'child' => 0,
                                    'price' => (float) $prices[$firstAttribute][$key],
                                    'qty' => (int) $qtys[$firstAttribute][$key],
                                ]);
                            }
                        }
                    }
                }
            } else {
                //comment
            }

            if (count($__v) >= 1) {
                foreach ($__v as $v) {
                    Variation::query()->insert([
                        'product_id' => $product->id,
                        'color_id' => $v['color'],
                        'attribute_id' => $v['attribute'],
                        'variation' => $v['child'],
                        'sku' =>  $v['attribute'] . 'xx' . $v['parent'] . 'xx' . $v['child'],
                        'price' => $v['price'] ?? $data['price'],
                        'qty' => $v['qty'],
                    ]);
                }
            }
            $this->message = trans('messages.created');
            $this->status = JsonResponse::HTTP_CREATED;
            return $this->returnData();
        }catch (\Exception $e){
            dd($e->getMessage());
        }
    }

    public function show(int $id)
    {
        $product = Product::with([
            'rating','category','category.products',
            'category.products.images','seller',
            'images','attributes',
            'attributes.attribute','attributes.variations',
            'colors','brand'])->withCount('rates')->findOrFail($id);
        $this->data = $product;
        return $this->returnData();
    }

    public function copyProductFromCatalog($data)
    {
        if (isset($data['productId'])){
            $product = Product::with('colors')->whereNull('seller_id')->where('id',$data['productId'])->get();
            if ($product->isNotEmpty()){
                $product = $product->first();
                $newProduct = $product->replicate();
                $newProduct->seller_id = auth('seller')->user()->detail->id;
                $newProduct->price = $data['price'];
                $product->slug = Str::slug($product->name) . ($product->id + 1);
                $newProduct->push();

//                if ($product->colors()->count() > 0)
//                {
//                    foreach ($product->colors as $color) {
//                        $newColor = $color->replicate();
//                        $newColor->product_id = $newProduct->id;
//                        $newColor->push();
//                    }
//
//                }

                if ($product->attributes()->count() > 0)
                {
                    foreach ($product->attributes as $attribute) {
                        $newAttribute = $attribute->replicate();
                        $newAttribute->product_id = $newProduct->id;
                        $newAttribute->push();
                    }

                }
                dd($product);
            }
        }
        dd($data);
    }

    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
    }

    public function destroy(int $id)
    {
        // TODO: Implement destroy() method.
    }

    public function getVariations()
    {
        if (request()->has('product_id') && request()->has('color_id')) {
            $variations = Variation::where(
                [
                    'product_id' => request('product_id'),
                    'color_id' => request('color_id'),
                ])
                ->get();
            $this->data = $variations;
        } else {
            $this->status = JsonResponse::HTTP_NOT_FOUND;
            $this->message = trans('messages.model_not_found');
        }

        return $this->returnData();
    }

    public function visibleUp($product)
    {
        $product->update([
            'visible' => !$product->visible
        ]);
    }
}
