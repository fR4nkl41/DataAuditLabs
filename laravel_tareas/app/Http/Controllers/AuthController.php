<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Cargar la vista de login
    public function index() {
       // Si el usuario ya está logueado, lo sacamos de aquí
        if (Auth::check()) {
            return redirect('/tareas');
        }
        return view('auth.login');
    }

    // Procesar el login
    public function login(Request $request) {
        // Validamos que los campos no vengan vacíos
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Auth::attempt hace la magia de validar contra la base de datos y crear la sesión
        if (Auth::attempt($credentials)) {
            // Regeneramos la sesión por seguridad (evita ataques de fijación de sesión)
            $request->session()->regenerate();

            // Redirigimos a las tareas
            return redirect()->intended('/tareas');
        }

        // Si falla, lo regresamos al login con un error
        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ]);
    }

    public function showRegister() {
       // Si ya está logueado, tampoco necesita ver el registro
        if (Auth::check()) {
            return redirect('/tareas');
        }
        return view('auth.register');
    }
    public function register(Request $request) {
        // Validamos los datos. 
        // unique:usuarios,email asegura que no se repitan correos en tu tabla 'usuarios'
        $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:usuarios,email'],
            'password' => ['required', 'min:6'], 
            'rol' => ['required'] // Ej: Administrador, Auditor, etc.
        ]);

        // Creamos el usuario en la base de datos
        User::create([
            'nombre' => $request->nombre,
            'email' => $request->email,
            // Aquí ocurre la magia: Encriptamos la contraseña y la guardamos en tu columna personalizada
            'password_hash' => Hash::make($request->password),
            'rol' => $request->rol,
        ]);

        // Redirigimos al login con un mensaje de éxito
        return redirect('/login')->with('mensaje', 'Usuario creado exitosamente. Ya puedes iniciar sesión.');
    }
     public function logout(Request $request) {
        Auth::logout(); // Destruye la sesión de Auth

        $request->session()->invalidate(); // Limpia los datos de sesión
        $request->session()->regenerateToken(); // Regenera el token CSRF

        return redirect('/login');
    }

}

   


