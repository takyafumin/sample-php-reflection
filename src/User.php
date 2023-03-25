<?php

namespace App;

use App\Types\Role;
use Carbon\CarbonImmutable;

/**
 * User class
 */
class User
{
    /**
     * @param null|int        $id          ID
     * @param string          $name        名前
     * @param Role            $role        権限
     * @param string          $login_id    ログインID
     * @param CarbonImmutable $register_at 登録日
     */
    public function __construct(
        private ?int $id,
        private string $name,
        private Role $role,
        private string $login_id,
        private CarbonImmutable $register_at,
    ) {
    }
}

