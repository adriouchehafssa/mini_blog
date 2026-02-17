<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * hady kataffecher lik login from.
     */
    public function showLoginForm(): Response
    {
        return Inertia::render('Admin/Auth/Login');
    }

    /**
     * validate and attempt to log the admin in. If successful, regenerate the session and redirect to the intended page. If not, throw a validation exception with an error message.
     */
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');
   //vérifie si la case "Remember me" est cochée.
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            $request->session()->regenerate();
      //Si l’admin essayait d’accéder à une page protégée avant login, Laravel le renvoie vers cette page.
            return redirect()->intended(route('admin.dashboard'));
        }
//Laravel retourne une erreur sur le champ email.
        throw ValidationException::withMessages([
            'email' => __('The provided credentials do not match our records.'),
        ]);
    }

    /**
     * Handle admin logout request.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}