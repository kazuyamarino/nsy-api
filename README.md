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
>    │       │   ├──modelrUser.php
>    │       └── Views
>    │           
>```

Don't forget, I also created a Routing to create an endpoint for data access, here I created a Route with the name `Api.php` in the `System/Routes` folder, then registered the **User Defined Routes** parameter in `Config/App.php`.

```php
Route::group('/users', function() {
 // Show all data users
 Route::get('/data', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'show_data_users']);

 // Search user data based on username
 Route::post('/data', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'search_data_users']);

 // Insert new user data
 Route::post('/insert', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'add_data_users']);

 // Get user data based on id
 Route::get('/(:num)', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'get_data_users']);

 // Update user data based on id
 Route::put('/(:num)', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'update_data_users']);

 // Delete user data based on id
 Route::delete('/(:num)', [System\Apps\Modules\ApiUser\Controllers\controllerUser::class, 'delete_data_users']);
});
```

---

## Endpoint

**To read all records from the table the request can be written in URL format as:**

```php
GET /users/data
```

**To search for records in the table the request can be written in URL format as:**

```text
POST /users/data

Create Body -> form-data : keywords
```

**To insert records into the table the request can be written in URL format as:**

```text
POST /users/insert

Create Body -> form-data : 
1. usercode
2. username
3. password
4. status
```

**To read a record by id from the table the request can be written in URL format as:**

```php
GET /users/10

// Get data where id = 10
```

**To update a record by id from the table the request can be written in URL format as:**

```php
PUT /users/10

// Update data where id = 10

Create Body -> form-data : 
1. usercode
2. username
3. password
4. status
```

**To remove a record by id from the table the request can be written in URL format as:**

```php
DELETE /users/10

// remove data where id = 10
```

---

## Database Example

There is an example mysql or mariadb database (for test the API process) in the `Migrations` folder. You can restore it to a database with this way [NSY Migration](https://github.com/kazuyamarino/nsy-docs/blob/master/NSY_MIGRATION.md).

---

Of course, this is just an example of a simple API which is not equipped with adequate data access security, so I made this just as an example of how to create an API and implement it in the NSY Framework.

Thank you for your attention.
