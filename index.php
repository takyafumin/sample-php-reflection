<?php

use App\UserFactory;

require_once "vendor/autoload.php";

$params = [
    'register_at' => '2023-1-31',
    'name'        => '深井',
    'login_id'    => 'username',
    'id'          => 1,
    'role'        => 1,
];


$factory = new UserFactory();
$user = $factory->create($params);

var_dump($user);

