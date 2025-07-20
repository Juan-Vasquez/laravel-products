<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Traits\formmaterBase64Trait;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    use formmaterBase64Trait;

    public function index()
    {
        return view('products.index');
    }
    
    public function getProducts(Request $request)
    {
        
        $page_limit = $request->input('page_limit') ?? 1;
        $sortField = $request->input('sort') ?? 'created_at';

        $sortDirection = Str::of($sortField)->startsWith('-') 
            ? 'desc' 
            : 'asc';

        $sortField = ltrim($sortField, '-');

        $products = Product::orderBy($sortField, $sortDirection)->paginate($page_limit);

        $pagination = [
            'total_items' => $products->total(),
            'limit_page' => $page_limit,
            'total_pages' => $products->lastPage(),
        ];

        $productInformation = collect($products->items())->map(function ($product) {
            return [
                'id' => $product->id,
                'code_product' => $product->code_product,
                'name_product' => $product->name_product,
                'quantity' => $product->quantity,
                'currency' => $product->currency,
                'price' => $product->price,
                'entry_date' => Carbon::parse($product->entry_date)->format('d-m-Y'),
                'expiration_date' => Carbon::parse($product->expiration_date)->format('d-m-Y'),
                'photo_product' => empty($product->photo_product) ? '/images/default.png' : $product->photo_product,
            ];
        });

        return response()->json(['code' => 200, 'data' => $productInformation, 'pagination' => $pagination], 200);

    }

    public function store(ProductRequest $request)
    {

        $urlImage = $this->pushBase64Image($request->photo_product);

        $dateExpiration = Carbon::parse($request->expiration_date);
        $entryDate = Carbon::parse($request->entry_date);

        if( $entryDate->gt($dateExpiration) ){

            return response()->json(['code' => 400, 'message' => 'La fecha de ingreso no puede ser mayor a la de vencimiento'], 400);

        }

        $saveProduct = Product::create([
            'code_product' => $request->code_product,
            'name_product' => $request->name_product,
            'quantity' => $request->quantity,
            'photo_product' => $urlImage,
            'price' => $request->price,
            'currency' => $request->currency,
            'entry_date' => $entryDate->toDateString(),
            'expiration_date' => $dateExpiration,
        ]);

        if( $saveProduct ){
            return response()->json(['code' => 200, 'message' => 'Se ha creado el producto exitosamente', 'data' => $saveProduct], 200);
        }

        return response()->json(['code' => 400, 'message' => 'Error al crear el producto', 'data' => $saveProduct], 400);
        
    }

    public function show($product)
    {
        $product = Product::find($product);

        if( !$product ){
            return response()->json(['code' => 404, 'message' => 'Producto no encontrado'], 404);
        }

        $product->expiration_date = Carbon::parse($product->expiration_date)->format('Y-m-d');

        return response()->json(['code' => 200, 'message' => 'Producto encontrado', 'data' => $product], 200);
    }

    public function update(ProductRequest $request, Product $product)
    {

        if( !empty($request->photo_product) ){
        
            $urlImage = $this->pushBase64Image($request->photo_product);

        }

        $dateExpiration = Carbon::parse($request->expiration_date);
        $entryDate = Carbon::parse($request->entry_date);

        if( $entryDate->gt($dateExpiration) ){

            return response()->json(['code' => 400, 'message' => 'La fecha de ingreso no puede ser mayor a la de vencimiento'], 400);

        }

        $product->update([
            'code_product' => $request->code_product,
            'name_product' => $request->name_product,
            'quantity' => $request->quantity,
            'photo_product' => $urlImage ?? $product->photo_product,
            'price' => $request->price,
            'currency' => $request->currency,
            'entry_date' => $entryDate,
            'expiration_date' => $dateExpiration,
        ]);

        return response()->json(['code' => 200, 'message' => 'Producto actualizado', 'data' => $product], 200);

    }

    public function destroy(Product $product)
    {
        Storage::disk('public')->delete('products/' . $product->photo_product);

        $product->delete();

        return response()->json(['code' => 200, 'message' => 'Producto eliminado', 'data' => $product], 200);
    }

}
