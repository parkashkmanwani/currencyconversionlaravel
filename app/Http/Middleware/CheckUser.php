<?php

namespace App\Http\Middleware;

use App\Repositories\AuthenticateRepository;
use Closure;
use Illuminate\Http\Request;

class CheckUser
{
    protected AuthenticateRepository $authenticateRepo;

    public function __construct(AuthenticateRepository $authenticateRepo)
    {
        $this->authenticateRepo = $authenticateRepo;
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$this->authenticateRepo->getByUserPwd($request['username'], $request['password'])) {
            $result = [
                'status' => 401,
                'error' => "User authentication failed"
            ];
            return response()->json($result, $result['status']);
        }
        return $next($request);
    }
}
