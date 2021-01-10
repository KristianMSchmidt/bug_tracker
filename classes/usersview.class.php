<?php
class UsersView extends Users
{
    public function showUsers()
    {
        $results = $this->getUsers();
        foreach ($results as $user) {
            echo $user['username'] . '<br>';
        }
    }

    public function showUsersByRoleID($role_id)
    {
        $results = $this->getUsersByRoleID($role_id);
        return $results;
        foreach ($results as $user) {
            echo $user['username'] . '<br>';
        }
    }
}
