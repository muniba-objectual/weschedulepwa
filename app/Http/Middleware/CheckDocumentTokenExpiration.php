<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class CheckDocumentTokenExpiration
{
    public function handle($request, Closure $next)
    {
        // Get the value of the 'token' parameter from the route
        $token = $request->route('token');

        // Retrieve the expiration time for the token from the session
        $tokenExpiration = Session::get("document_token_expires_at_{$token}");

        // Check if the token has an expiration time and if it has already expired
        if ($tokenExpiration && now() >= $tokenExpiration) {
            // If the token has expired, remove the session data related to the token
            Session::forget("document_token_{$token}");
            Session::forget("document_token_expires_at_{$token}");
        }

        // Check if the token value is present in the session
        if (!Session::has("document_token_{$token}")) {
            // If the token value is not found in the session, redirect to the login route with the token included in the URL and an error message
            return redirect()->route('document.login', ['token' => $token])->with('error', 'Please login to access the document');
        }

        // Extend the expiration time by 15 minutes (after 15min inactivity you will auto logout)
        $newExpirationTime = now()->addMinutes(15);
        Session::put("document_token_expires_at_{$token}", $newExpirationTime);


        // If the token is valid, allow the request to proceed to the next middleware or route
        return $next($request);

    }
}
