<?php
namespace System\Modules\ApiUser\Controllers;

use System\Core\Load;

class controllerUser extends Load
{

	public function show_data_users()
	{
		$d = Load::model('ApiUser\modelUser')->data_users();
		$d_json = fetch_json(["status" => "success", "data" => $d], 200);
		echo $d_json;
		exit();
	}

	public function get_data_users($id)
	{
		if ( is_request_get() ) {
			if ( not_filled($id) ) {
				$d_error = fetch_json(["status" => "no parameter", "data" => 0], 400);
				echo $d_error;
				exit();
			}
		} else {
			$d_json = fetch_json(["status" => "method incorrect", "data" => 0], 400);
			echo $d_json;
			exit();
		}

		$params = [
			':id' => $id
		];
		$d = Load::model('ApiUser\modelUser')->get_data_users($params);
		$d_json = fetch_json(["status" => "success", "data" => $d], 200);
		echo $d_json;
		exit();
	}

	public function search_data_users()
	{
		if ( is_request_post() ) {
			$array = get_parsed_array();
		} else {
			$d_json = fetch_json(["status" => "method incorrect", "data" => 0], 400);
			echo $d_json;
			exit();
		}

		$keywords = $array['keywords'];
		if ( not_filled($keywords) ) {
			$d_error = fetch_json(["status" => "no parameter", "data" => 0], 400);
			echo $d_error;
			exit();
		}

		$string = [ ':user_name' => '%'.$keywords.'%' ];
		$d = Load::model('ApiUser\modelUser')->search_data_users($string);
		$d_json = fetch_json(["status" => "success", "data" => $d], 200);
		echo $d_json;
		exit();
	}

	public function add_data_users()
	{
		$user_code     = secure_input(post('usercode'));
		$user_name     = secure_input(post('username'));
		$user_password = secure_input(sha1(post('password')));
		$user_status   = secure_input(post('status'));
		$date          = gmdate('Y-m-d H:i:s',time()+60*60*7);

		$param = [
			":user_code"     => $user_code,
			":user_name"     => $user_name,
			":user_password" => $user_password,
			":user_status"   => $user_status,
			":create_date"   => $date,
			":update_date"   => $date,
			":adds_date"     => $date
		];

		if ( not_filled($user_code) || not_filled($user_name) || not_filled($user_password) || not_filled($user_status) ) {
			$d_error = fetch_json(["status" => "no parameter", "data" => 0], 400);
			echo $d_error;
			exit();
		}

		$d = Load::model('ApiUser\modelUser')->add_data_users($param);
		$d_json = fetch_json(["status" => "success", "data" => $d], 200);
		echo $d_json;
		exit();
	}

	public function update_data_users($id)
	{
		if ( is_request_post() ) {
			$array = get_parsed_array();
		} else {
			$d_json = fetch_json(["status" => "method incorrect", "data" => 0], 400);
			echo $d_json;
			exit();
		}

		$user_name     = secure_input($array['username']);
		$user_password = secure_input(sha1($array['password']));
		$user_status   = secure_input($array['status']);

		$date          = gmdate('Y-m-d H:i:s',time()+60*60*7);

		$param = [
			":id"            => $id,
			":user_name"     => $user_name,
			":user_password" => $user_password,
			":user_status"   => $user_status,
			":update_date"   => $date
		];

		if ( not_filled($param) ) {
			$d_error = fetch_json(["status" => "no parameter", "data" => 0], 400);
			echo $d_error;
			exit();
		}

		$d = Load::model('ApiUser\modelUser')->update_data_users($param);
		$d_json = fetch_json(["status" => "success", "data" => $d], 200);
		echo $d_json;
		exit();
	}

	public function delete_data_users($id)
	{
		$params = [
			':id' => $id
		];

		$d = Load::model('ApiUser\modelUser')->delete_data_users($params);
		$d_json = fetch_json(["status" => "success", "data" => 1], 200);
		echo $d_json;
		exit();
	}

}
