<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category')->get();

        return response()->json(
            [
                'status' => 'success',
                'data' => $products
            ],
            200
        );


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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'qty' => 'required|numeric',
            'category_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'validation failed',
                    'data' => $validator->errors()
                ],
                422
            );
        }

        // create product
        $product = Product::create($request->all());

        return response()->json(
            [
                'message' => 'success create product',
                'data' => $product
            ],
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(
                [
                    'message' => 'product not found',
                    'data' => $product
                ],
                404
            );
        }
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
        $product = Product::find($id);

        // if porduct not found
        if (!$product) {
            return response()->json(
                [
                    'message' => 'product not found',
                    'data' => $product
                ],
                404
            );
        }

        // validator
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'qty' => 'required|numeric',
            'category_id' => 'required|numeric',
        ]);

        // validator error
        if ($validator->fails()) {
            return response()->json(
                [
                    'message' => 'validation failed',
                    'data' => $validator->errors()
                ],
                422
            );
        }

        // update product
        $product->update($request->all());

        // return response
        return response()->json(
            [
                'message' => 'success update product',
                'data' => $product
            ],
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // find product
        $product = Product::find($id);

        // if product not found
        if (!$product) {
            return response()->json(
                [
                    'message' => 'product not found',
                    'data' => $product
                ],
                404
            );
        }

        // delete product
        $product->delete();

        // return response
        return response()->json(
            [
                'message' => 'success delete product',
                'data' => $product
            ],
        );
    }
}
