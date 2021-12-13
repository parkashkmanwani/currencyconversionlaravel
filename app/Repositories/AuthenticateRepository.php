<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthenticateRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * AuthenticateRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get user by username and password
     *
     * @param string $username
     * @param string $password
     *
     * @return mixed
     */
    public function getByUserPwd(string $username, string $password)
    {
        $user = $this->user
            ->where('username', $username)
            ->where('password', $password)->first();

        return $user;
    }

    /**
     * Get user by username
     *
     * @param string $username
     *
     * @return mixed
     */
    public function getByUser(string $username)
    {
        $user = $this->user
            ->where('username', $username)
            ->first();

        return $user;
    }

    /**
     * Save User
     *
     * @param array $data
     * @return User
     */
    public function save(array $data): User
    {
        return $this->user->create($data);
    }
}
