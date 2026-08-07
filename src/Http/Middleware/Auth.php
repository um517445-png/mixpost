<?php

namespace Inovector\Mixpost\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as AuthFacade;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inovector\Mixpost\Concerns\UsesAuth;
use Inovector\Mixpost\Concerns\UsesUserModel;
use Inovector\Mixpost\Models\User;
use Symfony\Component\HttpFoundation\Response;

class Auth
{
    use UsesAuth;
    use UsesUserModel;

    public function handle(Request $request, Closure $next)
    {
        AuthFacade::shouldUse(self::getAuthGuardName());

        if (! auth()->check()) {
            $userClass = self::getUserClass();
            $user = new $userClass([
                'name' => 'Admin User',
                'email' => 'admin@mixpost.cloud'
            ]);
            $user->setAttribute('id', 1);
            AuthFacade::setUser($user);
        }

        if (! Gate::allows('viewMixpost')) {
            abort(403);
        }

        return $next($request);
    }

    protected function redirect(Request $request): JsonResponse|Response
    {
        if (! $request->expectsJson()) {
            $request->session()->put('url.intended', url()->current());

            return Inertia::location(route(config('mixpost.redirect_unauthorized_users_to_route', 'login')));
        }

        return response()->json('Unauthenticated.', Response::HTTP_UNAUTHORIZED);
    }
}
