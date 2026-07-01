<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:web')->except('do_logout');
    }
    public function index()
    {
        return view('pages.auth.login');
    }
    public function register()
    {
        return view('pages.auth.register');
    }

    public function forgot()
    {
        return view('pages.auth.forgot');
    }
public function do_login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|min:8',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validator->errors()->first(),
        ]);
    }

    if (!Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
    ])) {

        return response()->json([
            'status' => 'error',
            'message' => 'Email atau Password salah'
        ]);
    }

    return response()->json([
        'status' => 'success',
        'message' => 'Selamat Datang '.Auth::user()->fullname,
        'redirect' => $this->getRedirectPath(Auth::user())
    ]);
}
    public function do_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                'status' => 'error',
                'message' => $errors->first(),
            ]);
        }

        $user = new User;
        $user->name = explode(' ', $request->fullname)[0];
        $user->fullname = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi Berhasil',
            'redirect' => route('auth.index'),
        ]);
    }
    public function do_logout()
    {
        $user = Auth::user();
        Auth::logout($user);
        return redirect('dashboard')->with('success', 'Berhasil Logout');
    }
public function do_forgot(Request $request)
{
    $request->validate([
        'email' => 'required|email'
    ]);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return response()->json([
        'status' => $status === Password::RESET_LINK_SENT
            ? 'success'
            : 'error',
        'message' => __($status)
    ]);
}

    public function reset_password(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
        ]);

        $existing = User::where('email', $request->email)->first();
        $isNew = false;

        if ($existing) {
            $user = $existing;
            $user->password = Hash::make($request->password);
            $user->save();

            return response()->json([
                'status' => 'success',
                'message' => 'Password berhasil direset.',
                'redirect' => route('auth.index'),
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan. Silakan coba lagi.',
            ]);
        }
    }

    protected function broker()
    {
        return Password::broker();
    }

public function handleFirebaseAuth(Request $request)
{
    $isNew = false;

    $request->validate([
        'email' => 'required|email',
        'name' => 'required',
        'provider_id' => 'required'
    ]);

    // Cek apakah email sudah ada
    $user = User::where('email', $request->email)->first();

    if ($user) {

        // Admin dan operator wajib login menggunakan email/password
        if (in_array($user->role, ['admin', 'operator'])) {
            return response()->json([
                'status' => 'error',
                'message' => 'Admin dan Operator wajib login menggunakan Email dan Password.'
            ], 403);
        }

        // Simpan informasi provider jika belum ada
        if (empty($user->provider)) {
            $user->provider = 'google';
            $user->provider_id = $request->provider_id;
        }

        // Lengkapi nama jika kosong
        if (empty($user->fullname)) {
            $user->fullname = $request->name;
            $user->name = explode(' ', $request->name)[0];
        }

        $user->save();

    } else {

        // Buat akun baru dari Google
        $user = User::create([
            'name' => explode(' ', $request->name)[0],
            'fullname' => $request->name,
            'email' => $request->email,
            'password' => Hash::make(Str::random(24)),
            'provider' => 'google',
            'provider_id' => $request->provider_id,
            'role' => 'user'
        ]);

        $isNew = true;
    }

    // Jika user baru, arahkan ke halaman login
    if ($isNew) {
        return response()->json([
            'status' => 'success',
            'message' => 'Registrasi dengan Google berhasil. Silakan login menggunakan akun Google Anda.',
            'redirect' => route('auth.index'),
        ]);
    }

    // Login user lama
    Auth::login($user, true);

    return response()->json([
        'status' => 'success',
        'message' => 'Login Google berhasil',
        'redirect' => $this->getRedirectPath($user),
    ]);
}
    private function getRedirectPath($user)
    {
        if ($user->role === 'admin') {
            return route('admin.dashboard');
        } elseif ($user->role === 'operator') {
            return route('operator.dashboard');
        } else {
            return route('web.dashboard');
        }
    }
}
