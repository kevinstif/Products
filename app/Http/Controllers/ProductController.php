<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    
    // It returns all the products of the database
    public function index()
    {
        return Product::all();
    }

    /**
     * It receives a request, validates it, and if it's valid, it creates a new product and saves it to
     * the database
     * 
     * @param Request request The request object.
     * 
     * @return The product that was created.
     */
    public function store(Request $request)
    {
        $rules=[
            'name'=>'required',
            'description'=>'required',
            'price'=>'required',
            'stock'=>'required',
        ];
        $validador = Validator::make($request->all(),$rules);

        if($validador->fails()){
            $res = [
                'estate'=>false,
                'errors'=>$validador->errors()->all()
            ];
            return response()->json($res,400);
        }

        $product = new Product;
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->save();

        return $product;
    }


    /**
     * > The function show() will return the product with the id passed as parameter or a 404 error if
     * the product doesn't exist
     * 
     * @param id The id of the product you want to show.
     * 
     * @return The product with the id that was passed in the url.
     */
    public function show($id)
    {
        $product = Product::find($id);
        return $product?? response()->json("The Product with id: $id not exist",404);
    }

    /**
     * This function is used to update the product.
     * 
     * @param Request request The request object.
     * @param id The id of the product you want to update.
     * 
     * @return The product updated
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (is_null($product)){
            return response()->json("The Product with id: $id not exist",404);
        }

        $rules=[
            'name'=>'required',
            'description'=>'required',
            'price'=>'required',
            'stock'=>'required',
        ];
        $validador = Validator::make($request->all(),$rules);

        if($validador->fails()){
            $res = [
                'estate'=>false,
                'errors'=>$validador->errors()->all()
            ];
            return response()->json($res,400);
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->update();

        return $product;
    }

    /**
     * It deletes the product with the given id
     * 
     * @param id The id of the product to be deleted.
     * 
     * @return A 204 No Content response.
     */
    public function destroy($id)
    {
        $product = Product::find($id);

        if (is_null($product)){
            return response()->noContent();
        }

        $product->delete();
        return response()->noContent();
    }
}
