<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['error' => 'Token tidak ditemukan'], 401);
        }

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            // Cek role
            if ($decoded->role !== 'admin') {
                return response()->json(['error' => 'Unauthorized: Bukan admin'], 403);
            }

            // Simpan data user ke request untuk dipakai nanti (opsional)
            $request->merge([
                'user' => [
                    'id' => $decoded->sub,
                    'role' => $decoded->role,
                ]
            ]);

            return $next($request);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Token tidak valid', 'message' => $e->getMessage()], 401);
        }
    }
}
