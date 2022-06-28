<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Product;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $product = Product::all();

        return response()->json($product);
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);

        $jwt = $request->bearerToken();
        $result = JWT::decode($jwt, new Key(config('jwt.key'), 'HS256'));

        $request->merge([
            'user_id' => $result->user_id
        ]);

        $product = Product::create($request->all());
        return response()->json([
            'message' => 'Data has been created',
            'data' => $product
        ]);
    }

    public function show($id)
    {
        $product = Product::with('user')->find($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $credentials = $this->validate($request, [
            'name' => 'required',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric'
        ]);

        $product = Product::find($id);
        $product->name = $request->name;
        $product->price = $request->price;
        $product->quantity = $request->quantity;
        $product->save();

        return response()->json([
            'message' => 'Data has been updated',
            'data' => $product
        ]);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        
        return response()->json([
            'message' => 'Data has been deleted',
            'data' => $product
        ]);
    }

}
