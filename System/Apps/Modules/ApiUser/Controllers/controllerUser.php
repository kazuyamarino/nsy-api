<?php

namespace System\Apps\Modules\ApiUser\Controllers;

use System\Apps\Modules\ApiUser\Models\modelUser;
use System\Core\Load;

class controllerUser extends Load
{

	public function show_data_users()
	{
		$d = Load::model(modelUser::class)->data_users();
		$d_json = json_fetch(["status" => "Success", "data" => $d], 200);

		echo $d_json;
		exit();
	}

	public function search_data_users()
	{
		if (request_is_post()) {
			$array    = request_as_array();
			$keywords = $array['keywords'];

			if (not_filled($keywords)) {
				$d_json = json_fetch(["status" => "Data keywords is undefined or does not exist", "data" => 0], 400);

				echo $d_json;
				exit;
			}

			$string = [
				':username' => '%' . $keywords . '%',
				':usercode' => '%' . $keywords . '%'
			];

			$d = Load::model(modelUser::class)->search_data_users($string);
			$d_json = json_fetch(["status" => "Success", "data" => $d], 200);

			echo $d_json;
			exit();
		} else {
			$d_json = json_fetch(["status" => "HTTP method incorrect", "data" => 0], 400);

			echo $d_json;
			exit;
		}
	}

	public function add_data_users()
	{
		if (request_is_post()) {
			$array         = request_as_array();
			$generate_date = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);

			$param = [
				":usercode"    => secure_input($array['usercode']),
				":username"    => secure_input($array['username']),
				":password"    => secure_input(sha1($array['password'])),
				":status"      => secure_input($array['status']),
				":create_date" => $generate_date,
				":update_date" => $generate_date,
				":delete_date" => $generate_date
			];

			if (not_filled($param[':usercode']) || not_filled($param[':username']) || not_filled($param[':password']) || not_filled($param[':status'])) {
				$d_json = json_fetch(["status" => "Parameter incomplete", "data" => 0], 400);

				echo $d_json;
				exit();
			} else {
				$d = Load::model(modelUser::class)->add_data_users($param);
				$d_json = json_fetch(["status" => "Success", "data" => $d], 200);

				echo $d_json;
				exit();
			}
		} else {
			$d_json = json_fetch(["status" => "HTTP method incorrect", "data" => 0], 400);

			echo $d_json;
			exit();
		}
	}

	public function get_data_users($id)
	{
		if (request_is_get()) {
			if (not_filled($id)) {
				$d_json = json_fetch(["status" => "Data id is undefined or does not exist", "data" => 0], 400);

				echo $d_json;
				exit();
			} else {
				$params = [
					':id' => $id
				];

				$d = Load::model(modelUser::class)->get_data_users($params);
				$d_json = json_fetch(["status" => "Success", "data" => $d], 200);

				echo $d_json;
				exit();
			}
		} else {
			$d_json = json_fetch(["status" => "HTTP method incorrect", "data" => 0], 400);

			echo $d_json;
			exit();
		}
	}

	public function update_data_users($id)
	{
		if (request_is_put()) {
			$array         = request_as_array();
			$generate_date = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);

			$param = [
				":id"          => $id,
				":usercode"    => secure_input($array['usercode']),
				":username"    => secure_input($array['username']),
				":password"    => secure_input(sha1($array['password'])),
				":status"      => secure_input($array['status']),
				":update_date" => $generate_date,
			];

			if (not_filled($param[':id']) || not_filled($param[':usercode']) || not_filled($param[':username']) || not_filled($param[':password']) || not_filled($param[':status'])) {
				$d_json = json_fetch(["status" => "Parameter incomplete", "data" => 0], 400);

				echo $d_json;
				exit();
			} else {
				Load::model(modelUser::class)->update_data_users($param);
				$d_json = json_fetch(["status" => "Success", "data" => 1], 200);

				echo $d_json;
				exit();
			}
		} else {
			$d_json = json_fetch(["status" => "HTTP method incorrect", "data" => 0], 400);

			echo $d_json;
			exit();
		}
	}

	public function delete_data_users($id)
	{
		$params = [
			':id' => $id
		];

		Load::model(modelUser::class)->delete_data_users($params);
		$d_json = json_fetch(["status" => "Success", "data" => 1], 200);

		echo $d_json;
		exit();
	}
}
