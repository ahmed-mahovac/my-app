<?php

namespace App\Http\Controllers;

use App\Exceptions\UserException;
use App\Http\Requests\ActivateProductRequest;
use App\Http\Requests\AddVariantRequest;
use App\Http\Requests\GetProductsRequest;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductSearchObject;
use App\Http\Requests\RemoveVariantRequest;

class ProductController extends Controller
{

    protected $productService;

    // add a constructor with dependecy to ProductService
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GetProductsRequest $request)
    {
        // validate request

        $request->validated();

        // search object
        $searchObject = new ProductSearchObject(
            $request->query->count() > 0 ? $request->query->all() : []
        );

        return $this->productService->getAllProducts($searchObject);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->productService->getProduct($id);
    }

    public function showWithNewestVariant($id)
    {
        return $this->productService->getProductWithNewestVariant($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function activateProduct(ActivateProductRequest $request, $id)
    {
        $product = $this->productService->activateProduct($id, $request->all());

        return response()->json([
            'message' => 'Successfully activated product!',
            'product' => $product
        ]);

    }

    public function addVariant(AddVariantRequest $request, $productId)
    {
        $this->productService->addVariant($productId, $request->all());
    }

    public function removeVariant(RemoveVariantRequest $request, $productId, $variantId)
    {
        $this->productService->removeVariant($productId, $variantId);
    }
}
