<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order.kasir.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // karna di create blade memerlukan data obat untuk select nya, maka diambil terlebih dahulu datanya
        $medicines = Medicine::all();
        return view('order.kasir.create', compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'medicines' => 'required',
        ]);
        // mencari jumlah item yang sama pada array, strukturnya :
        // ["item" => jumlah]
        $arrayDistinct = array_count_values($request->medicines);
        // menyiapkan array kosong untuk menampung format array baru
        $arrayAssocMedicines = [];
        // looping hasil perhitungan item distinct (duplikat)
        // key akan berupa value dari input medicines (id), item array berupa jumlah perhitungan item duplikat
        foreach ($arrayDistinct as $id => $count) {
            // mencari data obat berdasarkan id (obat yang dipilih)
            $medicine = Medicine::where('id', $id)->first();
            // ambil bagian column price dari hasil pencarian lalu kalikan dengan jumlah item duplikat sehingga akan menghasilkan total harga dari pembelian obat tersebut
            $subPrice = $medicine['price'] * $count;
            // struktur value column medicines menjadi multidimensi dengan dimensi kedua berbentuk array assoc dengan key "id", "name_medicine", "qty", "price"
            $arrayItem = [
                "id" => $id,
                "name_medicine" => $medicine['name'],
                "qty" => $count,
                "price" => $medicine['price'],
                "sub_price" => $subPrice,
            ];
            // masukkan struktur array tersebut ke array kosong yang tersedia sebelumnya
            array_push($arrayAssocMedicines, $arrayItem);
        }
        // total harga pembelian dari obat-obat yang dipilih
        $totalPrice = 0;
        // looping format array medicines baru
        foreach ($arrayAssocMedicines as $item) {
            // total harga pembelian ditambahkan dari keseluruhan sub_price dan medicines
            $totalPrice += (int)$item['sub_price'];
        }
        // tambah data ke database
        $proses = Order::create([
            // data user_id diambil dari id akun kasir yang sedang login
            'user_id' => Auth::user()->id,
            'medicines' => $arrayAssocMedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $totalPrice,
        ]);

        if ($proses) {
            // jika proses tambah data berhasil, ambil data order yang dibuat oleh kasir yang sedang login (where), dengan tanggal paling terbaru (orderBy), ambil hanya satu data (first) 
            $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            // kirim data order yang diambil tadi, bagian column id sebagai parameter path dari route print
            return redirect()->route('kasir.order.print', $order['id']);
        } else {
            // jika tidak berhasil maka akan diarahkan kembali ke halaman form dengan pesan pemberitahuan
            return redirect()->back()->with('failed', 'Gagal membuat data pembelian. Silahkan coba kembali dengan data yang sesuai!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = Order::find($id);
        return view('order.kasir.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }

    public function downloadPDF($id) 
    {
        // ambil data yang diperlukan, dan pastikan data berformat array
        $order = Order::find($id)->toArray();

        // mengirim inisial variable dari data yang akan digunakan pada layout pdf
        view()->share('order', $order);

        // panggil blade yang akan di download 
        $pdf = PDF::loadview('order.kasir.download-pdf', $order);

        // kembalikan atau hasilkan bentuk pdf dengan nama file tertentu
        return $pdf->download('receipt.pdf');
    }
}
