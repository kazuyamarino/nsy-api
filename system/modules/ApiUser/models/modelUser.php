<?php
namespace System\Modules\ApiUser\Models;

use System\Core\DB;

class modelUser
{

	public function data_users()
	{
		$q = "SELECT * FROM tbl_users";
		$d = DB::connect()->query($q)->fetch_all();

		return $d;
	}

	public function get_data_users($params)
	{
		$q = "SELECT * FROM tbl_users where id = :id";
		$d = DB::connect()->query($q)->vars($params)->fetch_all();

		return $d;
	}

	public function search_data_users($string)
	{
		$q = "SELECT * FROM tbl_users WHERE user_name LIKE :user_name";
		$d = DB::connect()->query($q)->vars($string)->fetch();

		return $d;
	}

	public function add_data_users($param)
	{
		$q = "INSERT INTO tbl_users(
								user_code,
								user_name,
								user_password,
								user_status,
								create_date,
								update_date,
								adds_date )
							VALUES(
								:user_code,
								:user_name,
								:user_password,
								:user_status,
								:create_date,
								:update_date,
								:adds_date )";
		$d = DB::connect()->query($q)->vars($param)->exec();

		return $d;
	}

	public function update_data_users($param)
	{
		$q = "UPDATE tbl_users SET
					user_name     = :user_name,
					user_password = :user_password,
					user_status   = :user_status,
					create_date   = create_date,
					update_date   = :update_date,
					adds_date     = adds_date
				WHERE id = :id";
		$d = DB::connect()->query($q)->vars($param)->exec();

		return $d;
	}

	public function delete_data_users($param)
	{
		$query = "DELETE FROM tbl_users WHERE id = :id";
		DB::connect()->query($query)->vars($param)->exec();
	}

}
