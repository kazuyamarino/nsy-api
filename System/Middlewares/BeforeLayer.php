<?php

namespace System\Middlewares;

use Optimus\Onion\LayerInterface;
use \Firebase\JWT\JWT;
use \Firebase\JWT\Key;

class BeforeLayer implements LayerInterface
{
    private $secret_key = "abcde1234567890"; // Change this to your secret key

    public function peel($object, \Closure $next)
    {
        // Your middleware logic goes here
        $this->verify_jwt();

        // Call the next layer in the middleware stack
        return $next($object);
    }

    // Function to generate JWT token
    public function generate_jwt($username)
    {
        $payload = [
            'iss' => "https://nsyframework.com/", // Issuer
            'aud' => "https://nsyframework.com/", // Audience
            'iat' => time(), // Issued at
            'exp' => time() + (5 * 60), // Expiration time (5 minutes)
            'data' => [
                'username' => $username
            ]
        ];

        return JWT::encode($payload, $this->secret_key, 'HS256');
    }

    // Middleware to verify JWT token
    public function verify_jwt()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1];

            if ($jwt) {
                try {
                    $decoded = JWT::decode($jwt, new Key($this->secret_key, 'HS256'));
                    return $decoded->data->username;
                } catch (\Exception $e) {
                    $this->respondUnauthorized("Access denied: " . $e->getMessage());
                }
            } else {
                $this->respondUnauthorized("Token not found");
            }
        } else {
            $this->respondUnauthorized("Authorization header not found");
        }
    }

    // Helper method to respond with unauthorized status
    private function respondUnauthorized($message)
    {
        $d_json = fetch_json(["status" => "Access denied", "message" => $message], 401);
        echo $d_json;
        exit();
    }
}
