<?php

namespace App\Imports;

use App\Models\User;


class UsersImport
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function getUsers(array $row)
    {
        return [
            User::where('email',$row[2])
        ];
    }
}
