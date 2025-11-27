<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Helpers\VigenereCipher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class DataGuruController extends Controller
{
    public function index()
    {
        $url = URL::current();
        $url = explode('/', $url);

        $users = User::where('role', 'USER')->get();

        return view('admin.guru.data-guru', with([
            'url' => end($url),
            'users' => $users,
            'sidebar_data' => parent::sidebarMenu()
        ]));
    }

    public function detailGuru($id)
    {
        $url = URL::current();
        $url = explode('/', $url);

        $user = User::find($id);

        return view('admin.guru.edit', with([
            'url' => end($url),
            'user' => $user,
            'sidebar_data' => parent::sidebarMenu()
        ]));
    }

    public function updateGuru(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'full_name' => 'required',
            'email' => 'required|email',
            'gender' => 'required',
            'alamat' => 'required',
            'hp' => 'required',
            'password' => 'required',
            'pin' => 'required|min:4|max:6'
        ]);

        $user = User::find($request->id);
        $key = $request->pin;

        // Enkripsi data menggunakan Vigenère Cipher
        $encryptedName = VigenereCipher::encrypt($request->name, $key);
        $encryptedPassword = VigenereCipher::encrypt($request->password, $key);

        $user->name = $encryptedName;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->jenis_kelamin = $request->gender;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->hp;
        $user->password = $encryptedPassword;
        $user->pin = $key;

        $user->save();

        session()->put('success', 'Update data guru sukses');

        return redirect()->route('data-guru');
    }

    public function tambahGuru()
    {
        $url = URL::current();
        $url = explode('/', $url);

        return view('admin.guru.edit', with([
            'url' => end($url),
            'sidebar_data' => parent::sidebarMenu()
        ]));
    }

    public function storeTambahGuru(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'full_name' => 'required',
            'email' => 'required|email|unique:users',
            'gender' => 'required',
            'alamat' => 'required',
            'hp' => 'required',
            'password' => 'required',
            'pin' => 'required|min:4|max:6'
        ]);

        $key = $request->pin;

        // Enkripsi dengan Vigenere Cipher
        $encryptedName = VigenereCipher::encrypt($request->name, $key);
        $encryptedPassword = VigenereCipher::encrypt($request->password, $key);

        $user = new User;
        $user->name = $encryptedName;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->jenis_kelamin = $request->gender;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->hp;
        $user->password = $encryptedPassword;
        $user->pin = $key;
        $user->role = 'USER';
        $user->save();

        session()->put('success', 'Tambah data guru sukses');

        return redirect()->route('data-guru');
    }

    public function delete(Request $request)
{
    $user = User::find($request->id);
    if ($user) {
        $user->delete(); // Soft delete
        session()->put('success', 'Data Siswa berhasil dihapus.');
    } else {
        session()->put('error', 'Data Siswa tidak ditemukan.');
    }

    return redirect()->route('data-guru');
}

public function trashed()
{
    $users = User::onlyTrashed()->get(); // Mengambil data yang telah di-soft delete
    return view('admin.guru.trashed', ['users' => $users]);
}

public function restore($id)
{
    $user = User::withTrashed()->find($id);
    if ($user) {
        $user->restore(); // Mengembalikan data
        session()->put('success', 'Data Siswa berhasil dikembalikan.');
    } else {
        session()->put('error', 'Data Siswa tidak ditemukan.');
    }

    return redirect()->route('data-guru');
}

public function forceDelete($id)
{
    $user = User::withTrashed()->find($id);
    if ($user) {
        $user->forceDelete(); // Menghapus permanen
        session()->put('success', 'Data Siswa berhasil dihapus secara permanen.');
    } else {
        session()->put('error', 'Data Siswa tidak ditemukan.');
    }

    return redirect()->route('data-guru');
}

}
