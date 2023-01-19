<?php

namespace App\Models;
use App\Models\Model;

class User extends Model
{
    protected static $table = "users";

    static public function new_hash()
    {
        return bin2hex(random_bytes(10));
    }

    static public function hash_passwd($password)
    {
        return md5(md5(trim($password)));
    }
}
