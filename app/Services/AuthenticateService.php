<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\AuthenticateRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;
use Illuminate\Http\Request;
use Exception;

class AuthenticateService extends BaseService
{
    protected AuthenticateRepository $authenticateRepository;

    /**
     * AuthenticateService constructor.
     *
     * @param AuthenticateRepository $authenticateRepository
     */
    public function __construct(AuthenticateRepository $authenticateRepository)
    {
        $this->authenticateRepository = $authenticateRepository;
    }

    /**
     * Get user by username and password
     *
     * @param string $username
     * @param string $password
     *
     * @return array
     */
    public function getByUserPwd(string $username, string $password): array
    {
        try {
            $user = $this->authenticateRepository->getByUserPwd($username, $password);
            if (!$user) {
                throw new Exception("User not found", 404);
            }
            return $this->sendSuccessResponse($user);
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return $this->sendFailureResponse($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Create a User
     * Store to DB if there are no errors.
     *
     * @param array $data
     *
     * @return array
     */
    public function createUser(array $data): array
    {
        DB::beginTransaction();

        try {
            if ($this->authenticateRepository->getByUser($data['username'])) {
                throw new Exception('User already exists', 404);
            }
            $user = $this->authenticateRepository->save($data);
        } catch (Throwable $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return $this->sendFailureResponse($e->getMessage(), $e->getCode());
        }

        DB::commit();

        return $this->sendSuccessResponse('User Created Successfully');
    }
}
