<?php

namespace App\Http\Middleware;

use Closure;

class CheckPusherSignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->headers->has('X-Pusher-Key') && $request->headers->has('X-Pusher-Signature')) {
            $app_secret = ENV('PUSHER_APP_SECRET');
            $app_key = $request->header('X-Pusher-Key');
            $webhook_signature = $request->header('X-Pusher-Signature');

            $payLoad = $request->getContent();
            $expected_signature = hash_hmac('SHA256', $payLoad, $app_secret, false);

            if($webhook_signature == $expected_signature) {
                return $next($request);
            }
            else {
                return response()->json(['Status' => '401 Not authenticated']);
            }
        }
        return response()->json(['Status' => '401 Not authenticated']);
    }
}
