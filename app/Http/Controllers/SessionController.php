<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SessionController extends Controller
{
    // عرض صفحة تسجيل الدخول
    public function create()
    {
        return view('auth.login');
    }

    // تنفيذ عملية تسجيل الدخول
    public function store()
    {
        $attrs = request()->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if (!Auth::attempt($attrs)) {
            throw ValidationException::withMessages([
                'email' => 'Invalid Email',
                'password' => 'Invalid Password',
            ]);
        }

        // إعادة توليد السيشن
        request()->session()->regenerate();

        // توجيه المستخدم حسب نوع الدور
        $role = Auth::user()->role->name;

        if ($role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        } elseif ($role === 'student') {
            return redirect()->route('student.dashboard');
        } else {
            Auth::logout();
            abort(403, 'Unknown user role.');
        }
    }

    // تنفيذ تسجيل الخروج
    public function destroy()
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
