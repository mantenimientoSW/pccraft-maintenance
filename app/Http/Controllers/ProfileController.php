<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        // Cargar el usuario y todas sus direcciones
        $user = $request->user();
        $direcciones = $user->direcciones;

        return view('profile.edit', [
            'user' => $user,
            'direcciones' => $direcciones,
        ]);
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'cellphone' => 'nullable|string|max:15',
        ]);
    
        $user = $request->user();
        $user->update([
            'name' => $request->input('name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'cellphone' => $request->input('cellphone'),
        ]);
    
        return Redirect::route('profile.update')->with('status', '¡Información del perfil actualizada correctamente!');
    }    

    /**
     * Show the update form for the profile (including adding addresses).
     */
    public function showUpdateForm(Request $request): View
    {
        $user = $request->user();
        $direcciones = $user->direcciones; // Todas las direcciones del usuario

        return view('profile.update', [
            'user' => $user,
            'direcciones' => $direcciones,
        ]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed', // Si las contraseñas no coinciden, Laravel arroja un error automáticamente.
        ]);
    
        $user = $request->user();
        $user->password = bcrypt($request->password); // Encriptar la nueva contraseña
        $user->save();
    
        return Redirect::route('profile.update')->with('status', '¡Contraseña actualizada correctamente!');
    }    

    /**
     * Add a new address for the user.
     */
    public function addAddress(Request $request): RedirectResponse
    {
        $user = $request->user();

        // Validar los campos de la dirección
        $validatedData = $request->validate([
            'ciudad' => 'required|string|max:255',
            'calle_principal' => 'required|string|max:255',
            'cruzamientos' => 'nullable|string|max:255',
            'numero_exterior' => 'required|string|max:10',
            'numero_interior' => 'nullable|string|max:10',
            'detalles' => 'nullable|string',
            'codigo_postal' => 'required|string|max:10',
        ]);

        // Crear la nueva dirección
        $user->direcciones()->create([
            'ciudad' => $validatedData['ciudad'],
            'calle_principal' => $validatedData['calle_principal'],
            'cruzamientos' => $validatedData['cruzamientos'],
            'numero_exterior' => $validatedData['numero_exterior'],
            'numero_interior' => $validatedData['numero_interior'],
            'detalles' => $validatedData['detalles'],
            'codigo_postal' => $validatedData['codigo_postal'],
            'ID_Usuario' => $user->id,
            'is_default' => false,  // Esta nueva dirección no será predeterminada
        ]);

        return Redirect::route('profile.update')->with('status', '¡Dirección agregada correctamente!');
    }

    /**
     * Edit an existing address.
     */
    public function editAddress($direccionId): View
    {
        $user = Auth::user();
        $direccion = $user->direcciones()->where('ID_Direccion', $direccionId)->firstOrFail();

        return view('profile.editAddress', [
            'direccion' => $direccion,
        ]);
    }

    /**
     * Update an existing address.
     */
    public function updateAddress(Request $request, $direccionId): RedirectResponse
    {
        $user = Auth::user();
        $direccion = $user->direcciones()->where('ID_Direccion', $direccionId)->firstOrFail();

        // Validar los campos de la dirección
        $validatedData = $request->validate([
            'ciudad' => 'required|string|max:255',
            'calle_principal' => 'required|string|max:255',
            'cruzamientos' => 'nullable|string|max:255',
            'numero_exterior' => 'required|string|max:10',
            'numero_interior' => 'nullable|string|max:10',
            'detalles' => 'nullable|string',
            'codigo_postal' => 'required|string|max:10',
        ]);

        // Actualizar la dirección
        $direccion->update($validatedData);

        return Redirect::route('profile.update')->with('status', '¡Dirección actualizada correctamente!');
    }

    /**
     * Delete an address by its ID.
     */
    public function deleteAddress($direccionId): RedirectResponse
    {
        $user = Auth::user();

        // Verificar que la dirección pertenece al usuario
        $direccion = $user->direcciones()->where('ID_Direccion', $direccionId)->firstOrFail();

        // No permitir eliminar la dirección predeterminada
        if ($direccion->is_default) {
            return Redirect::back()->with('error', 'No puedes eliminar la dirección predeterminada.');
        }

        // Eliminar la dirección
        $direccion->delete();

        return Redirect::route('profile.update')->with('status', '¡La Dirección se ha eliminado correctamente!');
    }

    /**
     * Set a specific address as the default one.
     */
    public function setDefaultAddress(Request $request, $direccionId): RedirectResponse
    {
        $user = $request->user();
    
        // Verificar que la dirección seleccionada pertenece al usuario
        $direccion = $user->direcciones()->where('ID_Direccion', $direccionId)->firstOrFail();
    
        // Desmarcar todas las direcciones predeterminadas del usuario
        $user->direcciones()->update(['is_default' => false]);
    
        // Marcar la dirección seleccionada como predeterminada
        $direccion->update(['is_default' => true]);
    
        return Redirect::route('profile.edit')->with('status', '¡La Dirección Predetermianda actualizada correctamente!');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}