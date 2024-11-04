<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'jenis_ikan' => 'required|string',
            'harga_ikan' => 'required|numeric',
            'jumlah_ikan' => 'required|numeric',
            'foto_ikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi_ikan' => 'nullable|string',
            'habitat_ikan' => 'required|string',
        ]);

        if ($request->hasFile('foto_ikan')) {
            $path = $request->file('foto_ikan')->store('foto_ikan', 'public');
            $validatedData['foto_ikan'] = $path;
        }

        $product = Product::create($validatedData);
        return response()->json($product, 201);
        // return response()->json($validatedData);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        $validateData = $request->validate([
            'jenis_ikan' => 'string',
            'harga_ikan' => 'string',
            'jumlah_ikan' => 'numeric',
            'foto_ikan' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'deskripsi_ikan' => 'nullable|string',
            'habitat_ikan' => 'string',
        ]);


        if ($request->hasFile('foto_ikan')) {
            if ($product->foto_ikan) {
                Storage::disk('public')->delete($product->foto_ikan);
            }
            $path = $request->file('foto_ikan')->store('foto_ikan', 'public');
            $validatedData['foto_ikan'] = $path;
        }

        $product->update($validateData);
        return response()->json($product);
        // return response()->json($validateData);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Produk tidak ditemukan'], 404);
        }

        if ($product->foto_ikan) {
            Storage::disk('public')->delete($product->foto_ikan);
        }

        $product->delete();
        return response()->json(['message' => 'Produk berhasil dihapus']);

    }
}
