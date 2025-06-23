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
        
        $hargaBersih = preg_replace('/[^0-9]/', '', $request->harga);
        BahanBakar::create([
            'nama_bbm' => $request->nama_bbm,
            'harga' => $hargaBersih,
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
        $hargaBersih = preg_replace('/[^0-9]/', '', $request->harga);
        $bbm->update([
            'nama_bbm' => $request->nama_bbm,
            'harga' => $hargaBersih,
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
