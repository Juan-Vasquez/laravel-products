<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index()
    {
        return view('products.index');
    }
    
    public function getProducts(Request $request)
    {
        
        $page_limit = $request->input('page_limit') ?? 1;
        $sortField = $request->input('sort') ?? 'created_at';

        $sortDirection = Str::of($sortField)->startsWith('desc') 
            ? 'desc' 
            : 'asc';

        $sortField = ltrim($sortField, '-');

        $products = Product::orderBy($sortField, $sortDirection)->paginate($page_limit);

        $pagination = [
            'total_items' => $products->total(),
            'limit_page' => $page_limit,
            'total_pages' => $products->lastPage(),
        ];

        return response()->json(['code' => 200, 'data' => $products->items(), 'pagination' => $pagination], 200);

    }

    public function store(Request $request)
    {

        // $request->validate();

        $base64 = $request->photo_product;
        $binaryData = base64_decode( $base64 );

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $binaryData);

        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif'
        ];

        if ( !isset($extensions[$mimeType]) ) {
            return response()->json(['error' => 'Tipo de imagen no soportado'], 415);
        }

        $filename= time() . '.' . $extensions[$mimeType];
        $extension = $extensions[$mimeType];
        $image = base64_encode($base64);
        $image = base64_decode($image);
        $path = 'products/' . $filename;
        Storage::put($path, $image);

        // Paso 7: Obtener la URL pública (si usas storage:link)
        $url = Storage::url('products/' . $filename);

        $dateExpiration = Carbon::createFromFormat('d/m/Y', $request->expiration_date)->format('Y-m-d');
        $entryDate = Carbon::createFromFormat('d/m/Y', $request->entry_date)->format('Y-m-d H:i:s');

        $dateExpiration = Carbon::parse($dateExpiration);
        $entryDate = Carbon::parse($entryDate);

        if( $entryDate->gt($dateExpiration) ){

            return response()->json(['code' => 400, 'message' => 'La fecha de ingreso no puede ser mayor a la de vencimiento'], 400);

        }

        $saveProduct = Product::create([
            'code_product' => $request->code_product,
            'name_product' => $request->name_product,
            'quantity' => $request->quantity,
            'photo_product' => $url,
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

        return response()->json(['code' => 200, 'message' => 'Producto encontrado', 'data' => $product], 200);
    }

    public function update(Request $request, Product $product)
    {
        // $request->validate();

        $base64 = $request->photo_product;
        $binaryData = base64_decode( $base64 );

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_buffer($finfo, $binaryData);

        $extensions = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png',
            'image/gif' => 'gif'
        ];

        if ( !isset($extensions[$mimeType]) ) {
            return response()->json(['error' => 'Tipo de imagen no soportado'], 415);
        }

        $filename= time() . '.' . $extensions[$mimeType];
        $extension = $extensions[$mimeType];
        $image = base64_encode($base64);
        $image = base64_decode($image);
        $path = 'products/' . $filename;
        Storage::put($path, $image);

        // Paso 7: Obtener la URL pública (si usas storage:link)
        $url = Storage::url('products/' . $filename);

        $dateExpiration = Carbon::createFromFormat('d/m/Y', $request->expiration_date)->format('Y-m-d');
        $entryDate = Carbon::createFromFormat('d/m/Y', $request->entry_date)->format('Y-m-d H:i:s');

        $dateExpiration = Carbon::parse($dateExpiration);
        $entryDate = Carbon::parse($entryDate);

        if( $entryDate->gt($dateExpiration) ){

            return response()->json(['code' => 400, 'message' => 'La fecha de ingreso no puede ser mayor a la de vencimiento'], 400);

        }

        $product->update([
            'code_product' => $request->code_product,
            'name_product' => $request->name_product,
            'quantity' => $request->quantity,
            'photo_product' => $url,
            'price' => $request->price,
            'currency' => $request->currency,
            'entry_date' => $entryDate,
            'expiration_date' => $dateExpiration,
        ]);

        return response()->json(['code' => 200, 'message' => 'Producto actualizado', 'data' => $product], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['code' => 200, 'message' => 'Producto eliminado', 'data' => $product], 200);
    }

}
