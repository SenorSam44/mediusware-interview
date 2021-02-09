<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantPrice;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        $products=Product::paginate(2);
        $product_variant_prices = array();
        foreach ($products as $product){
            $product_variant_price= ProductVariantPrice::where('product_id', $product->id)->get()->first();
            array_push($product_variant_prices, $product_variant_price);

        }

        return view('products.index',[
            'products'=>$products,
            'product_variant_prices'=>$product_variant_prices,
            'variants'=>ProductVariant::all()->groupBy('variant')->keys(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function create()
    {
        $variants = Variant::all();
        return view('products.create', compact('variants'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        dd($request);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show($product)
    {


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $variants = Variant::all();
        return view('products.edit', compact('variants'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    public function filterProduct(Request $request){

        $product=Product::all();
        $title=$request->get('title');
//        $products=Product::where('title', 'like', '%'.$title.'%')
//            ->where('price', '>', $request->get('price_from'))
//            ->where('price', '<', $request->get('price_to'))
//            ->where('created_at', '<', $request->get('date'))->paginate(2);

        $products=DB::table('products')->join('product_variant_prices', 'products.id', '=', 'product_variant_prices.product_id' );
        if ($title!=null)
            $products=$products->where('products.title', 'like', '%'.$title.'%');

        if ($request->get('price_from')!=null)
            $products=$products->where('product_variant_prices.price', '>', $request->get('price_from'));

        if ($request->get('price_to')!=null)
            $products=$products->where('product_variant_prices.price', '<', $request->get('price_to'));

        if( $request->get('date')!=null)
            $products=$products->where('product_variant_prices.created_at', '=', $request->get('date'));

        $products=$products->select('products.*')->paginate(2);

        $product_variant_prices = array();
        foreach ($products as $product){
            $product_variant_price= ProductVariantPrice::where('product_id', $product->id)->get()->first();
            array_push($product_variant_prices, $product_variant_price);

        }

        return view('products.index',[
            'products'=>$products,
            'product_variant_prices'=>$product_variant_prices,
            'variants'=>ProductVariant::all()->groupBy('variant')->keys(),
        ]);


    }
}
