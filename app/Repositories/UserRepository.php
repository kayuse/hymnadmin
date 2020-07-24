<?php
/**
 * Created by IntelliJ IDEA.
 * User: user
 * Date: 4/14/20
 * Time: 1:32 AM
 */

namespace App\Repositories;


use App\AppUser;
use App\User;

class UserRepository
{
    public function create(array $data)
    {
        $userData = array('name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['email']),
            'api_token' => md5($data['name'] . $data['email'])
        );
        $appUserData = $data;
        unset($appUserData['name'], $appUserData['email']);

        $user = User::create($userData);
        $appUser = $user->appUser()->create($appUserData);
        return User::with('appUser')->find($user->id);
    }
}
