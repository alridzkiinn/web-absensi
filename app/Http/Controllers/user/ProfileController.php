<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Storage;
use URL;
use App\Helpers\VigenereCipher;

class ProfileController extends Controller
{
    public function index()
    {
        $url = URL::current();
        $url = explode('/', $url);
        $user = Auth::user();
                // Dekripsi nama panggilan menggunakan pin
        if ($user->pin && $user->name) {
            $user->name = VigenereCipher::decrypt($user->name, $user->pin);
        }

        return view('user_app.profile.profile', with([
            'route' => end($url),
            'user' => $user,
            'sidebar_data' => parent::sidebarMenu()
        ]));
    }

    public function update()
    {
        $user = Auth::user();
        // Dekripsi nama panggilan menggunakan pin
        if ($user->pin && $user->name) {
            $user->name = VigenereCipher::decrypt($user->name, $user->pin);
        }

        return view('user_app.profile.edit', with([
            'user' => $user,
            'sidebar_data' => parent::sidebarMenu()
        ]));
    }

    public function goUpdate(Request $request)
    {
        $id = Auth::user()->id;

        $file = $request->file('ava');

        if (isset($file)) {
            $extension = $file->getClientOriginalExtension();
            $filename = "ava_{$id}.$extension";

            $path = $file->storeAs(
                'public/avatar',
                $filename
            );

            // Return the file path or URL
            $path = Storage::url('avatar/' . $filename);
        }


        $user = User::find($request->id);
        $user->name = $request->name;
        $user->full_name = $request->full_name;
        $user->email = $request->email;
        $user->jenis_kelamin = $request->gender;
        $user->alamat = $request->alamat;
        $user->no_hp = $request->hp;
        if (isset($request->password)) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        if (isset($file)) {
            $user->profile_photo_path = $path;
        }

        $user->save();

        return redirect()->route('profile')->with(['user' => $user]);

    }

    public function showPinForm()
    {
        return view('user_app.profile.verifikasi-pin');
    }

    public function verifyPin(Request $request)
    {
        $request->validate([
            'pin' => 'required|string'
        ]);

        $user = Auth::user();

        if ($request->pin === $user->pin) {
            // Simpan PIN di session untuk sementara (hanya sesi ini)
            session(['verified_pin' => $request->pin]);
            return redirect()->route('lihat-password');
        }

        return back()->withErrors(['pin' => 'PIN yang Anda masukkan salah.']);
    }

    public function lihatPassword()
    {
        $user = Auth::user();

        // Pastikan sudah verifikasi PIN
        if (!session('verified_pin')) {
            return redirect()->route('verifikasi.pin')->with('warning', 'Silakan verifikasi PIN terlebih dahulu.');
        }

        // Dekripsi password menggunakan PIN dari session
        $decryptedPassword = VigenereCipher::decrypt($user->password, session('verified_pin'));

        return view('user_app.profile.lihat-password', compact('user', 'decryptedPassword'));
    }
}
