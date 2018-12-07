<?php

namespace App\Http\Controllers\Web;

use DB;
use Response;
use App\Models\Product;
use App\Models\ImagesProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('product','asc')->paginate(2);
    	return view('admin.product.index', compact('products'));
    }

    public function store(Request $request)
    {
/*    	dd($request->all());
*/
		$request->validate([
			'product'	 => 'required|max:60',
			'price'		 => 'required|min:0',
			'stock'		 => 'required|min:0',
			'images.*'		 => 'required|mimes:jpg,jpeg,png',
		]);

    	DB::beginTransaction();

    	try {

    		$product = Product::create([
    			'product' => $request->product,
    			'price' => $request->price,
    			'stock' => $request->stock,
    			'description' => $request->description,
    		]);

    		if ($request->hasFile('images')) {
    			$array = [];

    			foreach ($request->images as $key => $value) {
    				$path = $value->store('products');

    				$image = [
    					'product_id' => $product->id,
    					'image'	=> $path,
    				];

    				array_push($array, $image);
    			}

    			ImagesProduct::insert($array);
    		}

    		DB::commit();
    		
    	} catch (Exception $e) {

    		DB::rollback();

    		dd($e);

    	}

    	return redirect()->back();
    }

    public function show($id)
    {
        $product = Product::with('imageRelation')->where('id',$id)->first();
        return view('admin.product.detail', compact('product'));

    }
}
