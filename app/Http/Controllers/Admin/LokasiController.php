<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index(){
        $lokasi = Lokasi::paginate(10);
        return view('admin.lokasi.index', compact('lokasi'));
    }

    public function store(Request $request){
        $request->validate([
            'nama_sektor' => 'required',
            'sub_sektor' => 'required'
        ]);
        
        Lokasi::create([
            'nama_sektor' => $request->nama_sektor,
            'sub_sektor' => $request->sub_sektor,
        ]);

        return back()->with('success', 'Data berhasil disimpan!');
    }

    public function update(Request $request, $id){
        $request->validate([
            'nama_sektor' => 'required',
            'sub_sektor' => 'required'
        ]);
        
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->update([
            'nama_sektor' => $request->nama_sektor,
            'sub_sektor' => $request->sub_sektor,
        ]);

        return back()->with('success', 'Data berhasil diubah!');
    }

    public function destroy($id){
        $lokasi = Lokasi::findOrFail($id);
        $lokasi->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}
