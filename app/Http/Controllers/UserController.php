<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::simplePaginate(10);
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // menampilkan halaman form
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' =>'required|min:3',
            'email' => 'required',
            'role' => 'required',
        ]);

        // ambil 3 karakter awal dari name dan email
        $namePart = substr($request->name, 0, 3); // ambil 3 karakter awal dari name
        $emailPart = substr($request->email, 0, 3); // ambil 3 karakter awal dari email

        // membuat default password secara otomatis
        $password = $namePart . $emailPart; // password dibuat dengan menggabungkan 3 karakter awal name dan email

        $existingEmail = User::where('email', $request->email)->first(); // mencari email yang sama dengan inputan email

        // jika input email sudah tersedia di database, maka akan error
        if ($existingEmail) {
            return redirect()->back()->with('failed', 'Email sudah digunakan!');
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($password),
        ]);

        return redirect()->back()->with('success', 'Berhasil menambah data pangguna!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email|unique:users,email,' . $id, 
            'role' => 'required',
            'password' => 'nullable|min:6', // Password tidak wajib
        ], [
            'email.unique' => 'Email sudah digunakan!', // Pesan khusus untuk email yang sudah digunakan
        ]);

        
        $dataToUpdate = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];
        
        // Periksa apakah password diisi dan tidak kosong
        if ($request->filled('password')) {
            $dataToUpdate['password'] = Hash::make($request->password); // Mengenkripsi password
        }
        
        $update = User::where('id', $id)->update($dataToUpdate);
        
        if($update > 0) {
            return redirect()->route('user.index')->with('success', 'Data berhasil diubah!');
        } else {
            return redirect()->route('user.index')->with('failed', 'Tidak ada data yang diubah!');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
          // dicari (where) berdasarkan id, lalu hapus
          $proses = User::where('id', $id)->delete();
          if ($proses) {
              return redirect()->back()->with('deleted', 'Berhasil Menghapus Data User!');
          } else {
              return redirect()->back()->with('failed', 'Gagal Menghapus Data User!');
          }
    }

    public function showLogin() {
        return view('login');
    }

    public function login(Request $request) {

        $credential = $request->only('email', 'password');

        if (Auth::attempt($credential)) { 
            return redirect()->route('home.page');
        } else {
            return redirect()->back()->with('failed', 'Login gagal!');
        }
    }

    public function logout() {

        // Menghapus session login
        Auth::logout();

        // lalu mengembaliakan ke halaman login
        return redirect()->route('login')->with('logout', 'Logout Berhasil');

    }
}
