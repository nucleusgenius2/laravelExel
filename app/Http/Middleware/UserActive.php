<?php

namespace App\Http\Middleware;

use App\Models\Ban;
use App\Traits\ResponseController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;


class UserActive
{
    use ResponseController;


    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = request()->user();

        if ($user->status == 1) {
            return $next($request);
        } else {
            return $this->responseJsonApi();
        }
    }
}
