<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tnkb;
use Illuminate\Http\Request;

class TnkbController extends Controller
{
    public function index(){
        $tnkb = Tnkb::paginate(10);
        return view('admin.tnkb.index', compact('tnkb'));
    }

    public function store(Request $request){
        $request->validate([
            'nomor_polisi' => 'required',
            'kendaraan' => 'required',
            'jenis' => 'required',
        ]);

        Tnkb::create([
            'nomor_polisi' => $request->nomor_polisi,
            'kendaraan' => $request->kendaraan,
            'jenis' => $request->jenis,
        ]);
        return back()->with('success', 'Data berhasil diambahkan!');

    }

    public function update(Request $request, $id){
        $request->validate([
            'nomor_polisi' => 'required',
            'kendaraan' => 'required',
            'jenis' => 'required',
        ]);

        $tnkb = Tnkb::findOrFail($id);
        $tnkb->update([
            'nomor_polisi' => $request->nomor_polisi,
            'kendaraan' => $request->kendaraan,
            'jenis' => $request->jenis,
        ]);
        return back()->with('success', 'Data berhasil diubah!');
    }
    
    public function destroy($id){
        $tnkb = Tnkb::findOrFail($id);
        $tnkb->delete();
        return back()->with('success', 'Data berhasil dihapus!');
    }
}
