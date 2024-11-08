<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Pass;
use Illuminate\Support\Facades\Hash;

class PassController extends Controller
{
    public function verifySecretWord(Request $request)
    {
        // Validar los datos entrantes
        $request->validate([
            'email' => 'required|email',
            'secret_word' => 'required',
        ]);

        // Buscar el usuario por el email
        $user = User::where('email', $request->email)->first();

        // Verificar si el usuario existe
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        // Verificar si la secret_word ingresada coincide con la almacenada
        if (Hash::check($request->secret_word, $user->secret_word)) {
            return response()->json(['message' => 'Palabra secreta verificada correctamente'], 200);
        } else {
            return response()->json(['message' => 'Palabra secreta incorrecta'], 401);
        }
    }

    public function savePassword(Request $request)
    {
        try {
            // Validar los datos entrantes
            $request->validate([
                'password' => 'required|string',
                'sistema' => 'required|string',
                'user' => 'required|string',
            ]);

            $user = User::where('id', $request->user_id)->first();

            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            $secret_word = $user->secret_word;
            $encryptionKey = hash('sha256', $secret_word);

            // Generar un IV aleatorio de 16 bytes
            $iv = openssl_random_pseudo_bytes(16);

            // Cifrar la contraseña usando el IV generado
            $encryptedPassword = openssl_encrypt($request->password, 'aes-256-cbc', $encryptionKey, 0, $iv);

            // Guardar el IV concatenado con la contraseña cifrada
            $encryptedData = base64_encode($iv . $encryptedPassword);

            // Crear una nueva contraseña
            $password = $user->passwords()->create([
                'password' => $encryptedData,
                'sistema' => $request->sistema,
                'user' => $request->user,
            ]);

            return response()->json([
                'message' => 'Contraseña guardada correctamente',
                'password' => $password,
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function decryptPassword($encryptedData, $key)
    {
        // Crear una clave segura utilizando el hash de la palabra clave
        $encryptionKey = hash('sha256', $key);

        // Decodificar la cadena base64
        $encryptedData = base64_decode($encryptedData);

        // Separar el IV y la contraseña cifrada
        $iv = substr($encryptedData, 0, 16);
        $encryptedPassword = substr($encryptedData, 16);

        // Descifrar la contraseña usando el IV extraído
        $decryptedPassword = openssl_decrypt($encryptedPassword, 'aes-256-cbc', $encryptionKey, 0, $iv);

        return $decryptedPassword;
    }

    public function getpassword(Request $request)
    {
        try {
            // Validar que se proporcione la palabra clave
            $request->validate([
                'secret_word' => 'required',
                'sistema_id' => 'required'
            ]);

            $user = User::where('id', $request->user_id)->first();

            if (!$user) {
                return response()->json(['message' => 'Usuario no encontrado'], 404);
            }

            // Verificar si la secret_word ingresada coincide con la almacenada
            if (Hash::check($request->secret_word, $user->secret_word)) {
                $pass = Pass::where('user_id', $user->id)->where('id', $request->sistema_id)->first();
                if ($pass) {
                    $decryptedPassword = $this->decryptPassword($pass->password, $user->secret_word);
                    return response()->json(['password' => $decryptedPassword], 200);
                } else {
                    return response()->json(['message' => 'Contraseña no encontrada'], 404);
                }
            } else {
                return response()->json(['message' => 'Palabra secreta incorrecta'], 401);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function suggestPassword ()
    {
        $length = 12;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return response()->json(['password' => $randomString], 200);
    }

    public function getSistemsUser(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $sistems = $user->passwords()->select('id','sistema','user')->distinct()->get();

        return response()->json(['sistems' => $sistems], 200);
    }
}
