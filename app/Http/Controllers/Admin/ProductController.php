<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\ProductRequest;
use App\Models\Product;
use App\Repositories\V1\Contracts\AttributeRepositoryInterface;
use App\Repositories\V1\Contracts\BrandRepositoryInterface;
use App\Repositories\V1\Contracts\CategoryRepositoryInterface;
use App\Repositories\V1\Contracts\ColorRepositoryInterface;
use App\Repositories\V1\Contracts\FeatureRepositoryInterface;
use App\Repositories\V1\Contracts\ProductRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ApiResponder;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;
    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepository;
    /**
     * @var ColorRepositoryInterface
     */
    private $colorRepository;
    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepository;
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var FeatureRepositoryInterface
     */
    private $featureRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        BrandRepositoryInterface $brandRepository,
        ColorRepositoryInterface $colorRepository,
        AttributeRepositoryInterface $attributeRepository,
        ProductRepositoryInterface $productRepository,
        FeatureRepositoryInterface $featureRepository
    )
    {

        $this->categoryRepository = $categoryRepository;
        $this->brandRepository = $brandRepository;
        $this->colorRepository = $colorRepository;
        $this->attributeRepository = $attributeRepository;
        $this->productRepository = $productRepository;
        $this->featureRepository = $featureRepository;
    }

    public function index()
    {
        $products = $this->productRepository->getProductsByStore()['data'];

        return view('admin.products.index', compact('products'));
    }

    public function catalogs()
    {
        $products = $this->productRepository->getCatalogs()['data'];
        return view('admin.catalogs.index',compact('products'));
    }

    /**
     * TODO: add to repository
     * @return array
     */
    public function getVariation($productId)
    {
        $product = Product::with('variations')->find($productId);
        return view('admin.catalogs.variations',compact('product'));
    }

    public function copyProduct(Request $request)
    {
        $result = $this->productRepository->copyProductFromCatalog($request->all());
        dd($result);
    }

    public function getFeaturesByCategory($categoryId)
    {
        $features = $this->featureRepository->getFeaturesByCategory($categoryId)['data'];
        return view('admin.products.features', compact('features'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->index()['data'];
        $brands = $this->brandRepository->index()['data'];
        $colors = $this->colorRepository->getAllColors()['data'];
        $attributes = $this->attributeRepository->index()['data'];
        return view('admin.products.create', compact('categories', 'brands', 'colors', 'attributes'));
    }

    public function store(ProductRequest $request)
    {
        $result = $this->productRepository->store($request->all());
        return $this->sendResponse($result);
    }

    public function updateVisible(Product $product)
    {
        $this->productRepository->visibleUp($product);
        return redirect()->back();
    }
}
