<?php

namespace System\Apps\Modules\ApiUser\Controllers;

use System\Apps\Modules\ApiUser\Models\modelUser;
use System\Core\Load;
use System\Middlewares\BeforeLayer;

class controllerUser extends Load
{
    private $beforeLayer;

    public function __construct()
    {
        $this->beforeLayer = new BeforeLayer();
    }

    // Example login method to generate JWT token
    public function login()
    {
        if (request_is_post()) {
            $username = secure_input(fetch_raw_json('username'));
            $password = secure_input(sha1(fetch_raw_json('password')));

            $user = Load::model(modelUser::class)->login($username, $password);

            if ($user) {
                $token = $this->beforeLayer->generate_jwt($user['username']);
                $d_json = fetch_json([
                    "status"   => 200,
                    "message" => "You have successfully logged in.",
                    "data" => [
                        "username" => $user['username'],
                        "token"    => $token
                    ]
                ], 200);
                echo $d_json;
                exit();
            } else {
                $d_json = fetch_json(["status" => 400, "message" => "Invalid username or password."], 400);
                echo $d_json;
                exit();
            }
        } else {
            $d_json = fetch_json(["status" => 400, "message" => "HTTP method incorrect."], 400);
            echo $d_json;
            exit();
        }
    }

    // Method to refresh JWT token
    public function refresh_token()
    {
        $this->beforeLayer->refresh_jwt();
    }

    // Example method secured with JWT middleware
    public function add_data_users()
    {
        $this->beforeLayer->verify_jwt();

        if (request_is_post()) {
            $generate_date = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);

            $param = [
                ":usercode"    => secure_input(fetch_raw_json('usercode')),
                ":username"    => secure_input(fetch_raw_json('username')),
                ":password"    => secure_input(sha1(fetch_raw_json('password'))),
                ":status"      => secure_input(fetch_raw_json('status')),
                ":create_date" => $generate_date,
                ":update_date" => $generate_date,
                ":delete_date" => $generate_date
            ];

            if (not_filled($param[':usercode']) || not_filled($param[':username']) || not_filled($param[':password']) || not_filled($param[':status'])) {
                $d_json = fetch_json(["status" => 400, "message" => "Parameter incomplete."], 400);
                echo $d_json;
                exit();
            } else {
                $d = Load::model(modelUser::class)->add_data_users($param);
                $d_json = fetch_json(["status" => 200, "message" => "Successfully entered data.", "data" => $d], 200);
                echo $d_json;
                exit();
            }
        } else {
            $d_json = fetch_json(["status" => 400, "message" => "HTTP method incorrect.", "data" => ""], 400);
            echo $d_json;
            exit();
        }
    }

    // Example method secured with JWT middleware
    public function show_data_users()
    {
        $this->beforeLayer->verify_jwt();

        $d = Load::model(modelUser::class)->data_users();
        $d_json = fetch_json(["status" => 200, "messages" => "Successfully retrieved all data.",  "data" => $d], 200);

        echo $d_json;
        exit();
    }

	// Example method secured with JWT middleware
    public function get_data_users($id)
    {
        $this->beforeLayer->verify_jwt();

        if (request_is_get()) {
            if (not_filled($id)) {
                $d_json = fetch_json(["status" => 400, "message" => "Data id is undefined or does not exist.", "data" => ""], 400);
                echo $d_json;
                exit();
            } else {
                $params = [
                    ':id' => $id
                ];

                $d = Load::model(modelUser::class)->get_data_users($params);
                $d_json = fetch_json(["status" => 200, "message" => "Success get the data detail.", "data" => $d], 200);
                echo $d_json;
                exit();
            }
        } else {
            $d_json = fetch_json(["status" => 400, "message" => "HTTP method incorrect.", "data" => ""], 400);
            echo $d_json;
            exit();
        }
    }

	// Example method secured with JWT middleware
    public function update_data_users($id)
    {
        $this->beforeLayer->verify_jwt();

        if (request_is_put()) {
            $generate_date = gmdate('Y-m-d H:i:s', time() + 60 * 60 * 7);

            $param = [
                ":id" => $id,
                ":usercode" => secure_input(fetch_raw_json('usercode')),
                ":username" => secure_input(fetch_raw_json('username')),
                ":password" => secure_input(sha1(fetch_raw_json('password'))),
                ":status" => secure_input(fetch_raw_json('status')),
                ":update_date" => $generate_date,
            ];

            if (not_filled($param[':id']) || not_filled($param[':usercode']) || not_filled($param[':username']) || not_filled($param[':password']) || not_filled($param[':status'])) {
                $d_json = fetch_json(["status" => 400, "message" => "Parameter incomplete.", "data" => ""], 400);
                echo $d_json;
                exit();
            } else {
                Load::model(modelUser::class)->update_data_users($param);
                $d_json = fetch_json(["status" => 200, "message" => "Successfully changed the data.", "data" => 1], 200);
                echo $d_json;
                exit();
            }
        } else {
            $d_json = fetch_json(["status" => 400, "message" => "HTTP method incorrect.", "data" => ""], 400);
            echo $d_json;
            exit();
        }
    }

    // Example method secured with JWT middleware
    public function search_data_users()
    {
        $this->beforeLayer->verify_jwt();

        if (request_is_post()) {
            $keywords = fetch_raw_json('keywords');

            if (not_filled($keywords)) {
                $d_json = fetch_json(["status" => 400, "message" => "Data keywords is undefined or does not exist.", "data" => ""], 400);
                echo $d_json;
                exit();
            }

            $string = [
                ':username' => '%' . $keywords . '%',
                ':usercode' => '%' . $keywords . '%'
            ];

            $d = Load::model(modelUser::class)->search_data_users($string);
            $d_json = fetch_json(["status" => 200, "message" => "Successfully retrieved the data.", "data" => $d], 200);

            echo $d_json;
            exit();
        } else {
            $d_json = fetch_json(["status" => 400, "message" => "HTTP method incorrect.", "data" => ""], 400);
            echo $d_json;
            exit();
        }
    }

    // Example method secured with JWT middleware
    public function delete_data_users($id)
    {
        $this->beforeLayer->verify_jwt();

        $params = [
            ':id' => $id
        ];

        Load::model(modelUser::class)->delete_data_users($params);
        $d_json = fetch_json(["status" => 200, "message" => "Successfully deleted data.", "data" => 1], 200);

        echo $d_json;
        exit();
    }
}
