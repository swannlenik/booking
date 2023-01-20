<?php

namespace App\Services;

use App\Models\Type;
use App\Models\UserType;

class UserService
{

    public function userIsAdmin(int $userID): bool {
        $type = Type::where('name', '=', 'admin')->first();
        $userType = UserType::where('id_user', '=', $userID)->where('id_type', '=', $type->id)->first();

        return !empty($userType);
    }
}
