<?php

namespace System\Apps\Modules\ApiUser\Models;

use System\Core\DB;

class modelUser extends DB
{

    public function data_users()
    {
        $q = "SELECT * FROM api_table";
        $d = DB::connect()->query($q)->vars()->style(FETCH_ASSOC)->fetch_all();

        return $d;
    }

    public function get_data_users($params)
    {
        $q = "SELECT * FROM api_table where id = :id";
        $d = DB::connect()->query($q)->vars($params)->style(FETCH_ASSOC)->fetch_all();

        return $d;
    }

    public function search_data_users($string)
    {
        $q = "SELECT * FROM api_table WHERE (username LIKE :username OR usercode LIKE :usercode);";
        $d = DB::connect()->query($q)->vars($string)->style(FETCH_ASSOC)->fetch_all();

        return $d;
    }

    public function add_data_users($param)
    {
        $q = "INSERT INTO api_table(
            usercode,
            username,
            `password`,
            `status`,
            create_date,
            update_date,
            delete_date )
        VALUES(
            :usercode,
            :username,
            :password,
            :status,
            :create_date,
            :update_date,
            :delete_date )";
        $d = DB::connect()->query($q)->vars($param)->exec();

        return $d;
    }

    public function update_data_users($param)
    {
        $q = "UPDATE api_table SET
            usercode    = :usercode,
            username    = :username,
            `password`  = :password,
            `status`    = :status,
            create_date = create_date,
            update_date = :update_date,
            delete_date = delete_date
        WHERE id = :id";
        $d = DB::connect()->query($q)->vars($param)->exec();

        return $d;
    }

    public function delete_data_users($param)
    {
        $query = "DELETE FROM api_table WHERE id = :id";
        DB::connect()->query($query)->vars($param)->exec();
    }

    public function login($username, $password)
    {
        $q = "SELECT * FROM api_table WHERE username = :username AND password = :password AND status = 'Y' LIMIT 1";
        $params = [
            ':username' => $username,
            ':password' => $password
        ];
        $d = DB::connect()->query($q)->vars($params)->style(FETCH_ASSOC)->fetch();

        return $d;
    }
}
