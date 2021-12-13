<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AuthenticateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class AuthenticateController extends Controller
{
    /**
     * @var authenticateService
     */
    protected $authenticateService;

    /**
     * AuthenticateController Constructor
     *
     * @param AuthenticateService $authenticateService
     *
     */
    public function __construct(AuthenticateService $authenticateService)
    {
        $this->authenticateService = $authenticateService;
    }

    /**
     *
     * Authenticate User
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function authenticate(Request $request): JsonResponse
    {
        [$data, $statusCode] = $this->authenticateService->getByUserPwd($request['username'], $request['password']);

        return response()->json($data, $statusCode);
    }

    /**
     *
     * Create User
     *
     * @param Request $request
     *
     * @return JsonResponse
     * @throws Throwable
     */
    public function create(Request $request): JsonResponse
    {
        [$data, $statusCode] = $this->authenticateService->createUser($request->all());

        return response()->json($data, $statusCode);
    }
}
