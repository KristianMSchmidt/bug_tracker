<?php
/*
This is the Controller in the MCV model. This is where we
- update, insert, delete, change database
*/

class UsersContr extends Users
{
    public function createUser(string $username, string $pwd, string $email, int $role_id)
    {

        $usersModel = new Users();
        $usersModel->setUser($username, $pwd, $email, $role_id);
    }
}
