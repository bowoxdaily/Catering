<?php

namespace App\Http\Controllers\BE;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class BarangControllerBE extends Controller
{
    
    public function getBarang($id)
    {
        $barang = Barang::find($id);
        return response()->json($barang);
    }

    public function store(Request $request){

        $validate = $request ->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'string',
            'stock' => 'nullable|numeric',
            'gambar' => 'required|mimes:png,jpg,jpeg',
            'status' => 'required|string|max:50'

        ]);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('img/barang', $filename, 'public-direct');
            $validate['gambar'] = $path;
        }

        $Barang = Barang::create($validate);

        return redirect()->route('barang_index')->with('success','Barang berhasil di tambahkan');

    }

    public function update(Request $request,$id)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
            'category' => 'string|max:255',
            'stock' => 'nullable|numeric',
            'gambar' => 'nullable|mimes:png,jpg,jpeg|max:2048',
            'status' => 'required|string|max:50'
        ]);

        $barang = Barang::findOrFail($id);

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('img/barang', $filename, 'public-direct');

            // Hapus gambar lama jika ada
            if ($barang->gambar) {
                Storage::disk('public-direct')->delete($barang->gambar);
            }

            // Tambahkan path gambar baru ke data validasi
            $validate['gambar'] = $path;
        } else {
            // Jika tidak ada gambar baru, pertahankan gambar lama
            $validate['gambar'] = $barang->gambar;
        }

        // Update data barang dengan nilai validasi
        $barang->update($validate);

        return redirect()->route('barang_index')->with('message', 'Update Berhasil');
    }


        public function destroy($id)
    {
        // Cari barang berdasarkan ID
        $barang = Barang::findOrFail($id);

        // Hapus gambar jika ada
        if ($barang->gambar && Storage::disk('public-direct')->exists($barang->gambar)) {
            Storage::disk('public-direct')->delete($barang->gambar);
        }

        // Hapus data barang
        $barang->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('barang_index')->with('success', 'Barang berhasil dihapus');
    }





}
