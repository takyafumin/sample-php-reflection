<?php

namespace App\Types;

/**
 * 権限
 */
enum Role: int
{
    case ADMIN = 1;
    case USER = 2;
}
