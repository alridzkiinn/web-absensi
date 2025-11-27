<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helpers\VigenereCipher;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Helpers\CryptoHelper;


class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'pin' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->route('login')->with(['error' => 'Email tidak ditemukan']);
        }

        // Dekripsi password dari database dengan PIN
        $decryptedPassword = VigenereCipher::decrypt($user->password, $request->pin);

        // Bandingkan hasil dekripsi dengan input user
        if (strtoupper($decryptedPassword) === strtoupper($request->password)) {
            Auth::login($user);
            return redirect()->route('home');
        } else {
            return redirect()->route('login')->with(['error' => 'PIN atau Password salah']);
        }
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function register(Request $request): RedirectResponse
    {
        try {
            $request->validate([
                'full_name' => 'required',
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required',
                'gender' => 'required|integer|in:0,1',
                'address' => 'required',
                'phone' => 'required',
                'pin' => 'required|min:4|max:6'
            ]);

            $key = $request->pin;

            // Enkripsi name dan password pakai Vigenere
            $encryptedName = VigenereCipher::encrypt($request->name, $key);
            $encryptedPassword = VigenereCipher::encrypt($request->password, $key);

            $user = new User();
            $user->name = $encryptedName;
            $user->full_name = $request->full_name;
            $user->email = $request->email;
            $user->jenis_kelamin = $request->gender;
            $user->alamat = $request->address;
            $user->no_hp = $request->phone;
            $user->password = $encryptedPassword;
            $user->pin = $key;
            $user->save();

            return redirect()->route('login')->with(['success' => 'Pendaftaran akun sukses. Silakan login.']);
        } catch (\Throwable $th) {
            return back()->withErrors(['error' => 'Gagal membuat akun. ' . $th->getMessage()]);
        }
    }

    public function reset(Request $request): RedirectResponse
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }
}
