<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BahanBakar;
use Illuminate\Http\Request;

class BahanBakarController extends Controller
{
    public function index(){
        $bbm = BahanBakar::paginate(10);
        return view('admin.bahanBakar.index', compact('bbm'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_bbm' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required'
        ]);
        
        BahanBakar::create([
            'nama_bbm' => $request->nama_bbm,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama_bbm' => 'required',
            'harga' => 'required',
            'deskripsi' => 'required'
        ]);
        
        $bbm = BahanBakar::findOrFail($id);
        $bbm->update([
            'nama_bbm' => $request->nama_bbm,
            'harga' => $request->harga,
            'deskripsi' => $request->deskripsi,
        ]);

        return back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id){
        $bbm = BahanBakar::findOrFail($id);
        $bbm->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}
