<?php

namespace App\Http\Middleware;

use Closure;

class Cors {
  public function handle($request, Closure $next)
  {
    /** Added for local development to prevent CORS issue in Chrome. */
    $allowedDomain = env('APP_URL');
    $origin = $request->server('HTTP_ORIGIN');

    /** This makes sure that we allow requests from localhost, regardless of the port. */
    if(env('APP_ENV') === 'local'){
      if($request->isMethod('OPTIONS'))
        $response = response('', 200);
      else
        $response = $next($request);

      $response->headers->set('Access-Control-Allow-Origin', $origin);
      $response->headers->set('Access-Control-Allow-Methods', 'OPTIONS, HEAD, GET, POST, PUT, PATCH, DELETE');
      $response->headers->set('Access-Control-Allow-Headers', $request->header('Access-Control-Request-Headers'));
    } else {
      $response = $next($request);
    }

    return $response;
  }
}
