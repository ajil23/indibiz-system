<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisProduk;
use Illuminate\Http\Request;

class JenisProdukController extends Controller
{
    public function index(){
        $jenisProduk = JenisProduk::paginate(10);
        return view('admin.jenisProduk.index', compact('jenisProduk'));
    }

    public function store(Request $request){
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        JenisProduk::create([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);
        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
        ]);

        $jenisProduk = JenisProduk::findOrFail($id);
        $jenisProduk->update([
            'nama' => $request->nama,
            'deskripsi' => $request->deskripsi,
        ]);
        return back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id){
        $jenisProduk = JenisProduk::findOrFail($id);
        $jenisProduk->delete();
        return back()->with('success', 'Data berhasil dihapus!');

    }
}
