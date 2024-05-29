<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PaginateAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        $content = $response->getContent();
        try {
            $data = json_decode($content);
            if (property_exists($data, 'links')) {
                unset($data->links);
            }
            if (property_exists($data, 'meta') && property_exists($data->meta, 'links')) {
                unset($data->meta->links);
            }

            $response->setContent(json_encode($data));
        } catch (\Exception $e) {
            return $response;
        }

        return $response;
    }
}
