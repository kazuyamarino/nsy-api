# Example API with NSY PHP Framework
NSY is a simple PHP Framework that works well on MVC or HMVC mode.

[![Build Status](https://travis-ci.org/kazuyamarino/nsy.svg?branch=master)](https://travis-ci.org/kazuyamarino/nsy)

Site example :
[https://nsy.kazuyamarino.com/](https://nsy.kazuyamarino.com/)

See further explanation here... [NSY Documentation](https://github.com/kazuyamarino/nsy-docs/blob/master/README.md)

## Route Api (URI | method | Description)
* http://localhost/api/users | get | Get all data user
* http://localhost/api/users | post | Insert data user ( form-data : usercode, username, password, status )
* http://localhost/api/users/search | post | Search data user ( form-data : keywords )
* http://localhost/api/users/{id} | get | Get data user by id ( form-data : id )
* http://localhost/api/users/{id} | post | Update data user by id ( form-data : id )
* http://localhost/api/users/{id} | delete | Delete data user by id ( form-data : id )

## Database Example
There is an example database (sql file) in the `dump` folder. You can restore the sql file to a database that you created by yourself.

## License
The code is available under the [MIT license](LICENSE.txt)
