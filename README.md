# NSY Framework

NSY is a simple PHP Framework that works well on MVC or HMVC mode.

Site example :
[https://nsyframework.com/](https://nsyframework.com/)

See further explanation here... [NSY Documentation](https://github.com/kazuyamarino/nsy-docs/blob/master/README.md) *(Documentation is undercontruction, sorry for many information have been missed)*

## License

The code is available under the [MIT license](LICENSE.txt)

---

## Example of Creating an API With NSY Framework

I will give an example of how to create a simple API in the NSY Framework.

I created it in HMVC mode with the following path:

```text
System/Apps/Modules/ApiUser
```

Yes, I created a module called `ApiUser` which contains MVC.

Because this time I only created an API, so I only used Models and Controllers, and in the `ApiUser` module it looks like this:

>```text
>Modules
>    │   └── ApiUser
>    │       ├── Controllers
>    │       │   ├──controllerUser.php
>    │       ├── Models
>    │           ├──modelUser.php
>    │      
>    │           
>```

Don't forget, I also created a Routing to create an endpoint for data access, here I created a Route with the name `Api.php` in the `System/Routes` folder, then registered the **User Defined Routes** parameter in `Config/App.php`.

```php
use System\Middlewares\BeforeLayer;

// Login endpoint
Route::post('/login', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'login']);

// Api Route
Route::group('/users', function() {
    $middleware = [new BeforeLayer()];

    // Show all data users
    Route::get('/data', function () use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'show_data_users']);
    });

    // Search user data based on username
    Route::post('/data', function () use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'search_data_users']);
    });

    // Insert new user data
    Route::post('/insert', function () use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'add_data_users']);
    });

    // Get user data based on id
    Route::get('/(:num)', function ($id) use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'get_data_users'], $id);
    });

    // Update user data based on id
    Route::put('/(:num)', function ($id) use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'update_data_users'], $id);
    });

    // Delete user data based on id
    Route::delete('/(:num)', function ($id) use ($middleware) {
        Route::middleware($middleware)->for([System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'delete_data_users'], $id);
    });
});
```

Below is the middleware for the JWT function which is in the folder `System/Middlewares/` with the file name `BeforeLayer.php`.

```php
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
            'iss' => "https://your_site.com/", // Issuer
            'aud' => "https://your_site.com/", // Audience
            'iat' => time(), // Issued at
            'exp' => time() + (5 * 60), // Expiration time (5 minutes)
            'data' => [
                'username' => $username // using username from database table
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
```

---

## Endpoint

**To generated the token from the table the request can be written in URL format as:**

```php
URL: /nsy-api/nsy-api/login
Method: POST
Authorization: Bearer your_generated_token
```

In the body, select raw and JSON, then provide this:

```json
{
  "username": "vikry",
  "password": "timnas"
}
```

**To read all records from the table the request can be written in URL format as:**

```php
URL: /nsy-api/users/data
Method: GET
Authorization: Bearer your_generated_token
```

**To search for records in the table the request can be written in URL format as:**

```php
URL: /nsy-api/users/data
Method: POST
Authorization: Bearer your_generated_token
```

In the body, select raw and JSON, then provide this:

```json
{
    "keywords": "your_search_query"
}
```

**To insert records into the table the request can be written in URL format as:**

```php
URL: /nsy-api/users/insert
Method: POST
Authorization: Bearer your_generated_token
```

In the body, select raw and JSON, then provide this:

```json
{
    "usercode": "20",
    "username": "persib",
    "password": "maung",
    "status": "N"
}
```

**To read a record by id from the table the request can be written in URL format as:**

```php
URL: /nsy-api/users/10
Method: GET
Authorization: Bearer your_generated_token

// Get data where id = 10
```

**To update a record by id from the table the request can be written in URL format as:**

```php
URL: /nsy-api/users/10
Method: PUT
Authorization: Bearer your_generated_token

// Update data where id = 10
```

In the body, select raw and JSON, then provide this:

```json
{
    "usercode": "20",
    "username": "persib",
    "password": "timnas",
    "status": "Y"
}
```

**To remove a record by id from the table the request can be written in URL format as:**

```php
URL: /nsy-api/users/10
Method: DELETE
Authorization: Bearer your_generated_token

// remove data where id = 10
```

---

## Database Example

There is an example mysql or mariadb database (for test the API process) in the `Migrations` folder. You can restore it to a database with this way [NSY Migration](https://github.com/kazuyamarino/nsy-docs/blob/master/NSY_MIGRATION.md).

---

Of course, this is just an example of a simple API which is not equipped with adequate data access security, so I made this just as an example of how to create an API and implement it in the NSY Framework.

Thank you for your attention.
