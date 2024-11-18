<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the medicines.
     */
    public function index()
    {
        $medicines = Medicine::orderBy('name', 'asc')->simplePaginate(5);
        return view('medicine.index', compact('medicines'));
    }

    /**
     * Show the form for creating a new medicine.
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created medicine in the database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|min:3|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ], [
            'name.required' => 'Nama obat harus diisi!',
            'type.required' => 'Tipe obat harus diisi!',
            'price.required' => 'Harga obat harus diisi!',
            'stock.required' => 'Stok obat harus diisi!',
            'name.max' => 'Nama obat maksimal 100 karakter!',
            'type.min' => 'Tipe obat minimal 3 karakter!',
            'price.numeric' => 'Harga obat harus berupa angka!',
            'stock.numeric' => 'Stok obat harus berupa angka!',
        ]);

        Medicine::create($validated);
        
        return redirect()->back()->with('success', 'Berhasil menambahkan data obat!');
    }

    /**
     * Show the form for editing a medicine.
     */
    public function edit($id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return redirect()->route('medicine.home')->with('error', 'Medicine not found!');
        }

        return view('medicine.edit', compact('medicine'));
    }

    /**
     * Update the specified medicine in the database.
     */
    public function update(Request $request, $id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return redirect()->route('medicine.home')->with('error', 'Medicine not found!');
        }

        $validated = $request->validate([
            'name' => 'required|max:100',
            'type' => 'required|min:3',
            'price' => 'required|numeric',
        ], [
            'name.required' => 'Nama obat harus diisi!',
            'type.required' => 'Tipe obat harus diisi!',
            'price.required' => 'Harga obat harus diisi!',
            'name.max' => 'Nama obat maksimal 100 karakter!',
            'type.min' => 'Tipe obat minimal 3 karakter!',
            'price.numeric' => 'Harga obat harus berupa angka!',
        ]);

        $medicine->update($validated);

        return redirect()->route('medicine.home')->with('success', 'Berhasil mengubah data obat');
    }

    /**
     * Remove the specified medicine from the database.
     */
    public function destroy($id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return redirect()->back()->with('error', 'Medicine not found!');
        }

        $medicine->delete();
        return redirect()->back()->with('deleted', 'Data berhasil dihapus!');
    }

    /**
     * Show a list of medicines ordered by stock.
     */
    public function stockIndex()
    {
        $medicines = Medicine::orderBy('stock', 'ASC')->get();
        return view('medicine.stock', compact('medicines'));
    }

    /**
     * Show the form for editing the stock of a specific medicine.
     */
    public function stockEdit($id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return response()->json(['message' => 'Medicine not found'], 404);
        }

        return response()->json($medicine);
    }

    /**
     * Update the stock of a specific medicine.
     */
    public function stockUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'stock' => 'required|numeric',
        ]);

        $medicine = Medicine::find($id);
        if (!$medicine) {
            return response()->json(['message' => 'Medicine not found'], 404);
        }

        if ($request->stock <= $medicine->stock) {
            return response()->json(['message' => 'Stock input cannot be less than the current stock'], 400);
        }

        $medicine->update(['stock' => $request->stock]);

        return response()->json(['message' => 'Stock updated successfully'], 200);
    }
}
