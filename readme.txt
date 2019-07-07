/*
Create Mysql Database and table for below
*/

//Run following command

create database company;

use company;


CREATE  TABLE IF NOT EXISTS `Coupon` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `name` VARCHAR(150) NOT NULL ,
  `brand` VARCHAR(150) NOT NULL ,
  `value` INT ,
  `createdAt` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `expiry` DATETIME NOT NULL,
  PRIMARY KEY (`id`)
  );


INSERT INTO Coupon (name, brand, value, createdAt, expiry)
VALUES ('Save £20 at Tesco', 'Tesco', '20', '2018-03-01 10:15:53', '2019-03-01 10:15:53');


CREATE  TABLE IF NOT EXISTS `Users` (
  `id` INT  AUTO_INCREMENT ,
  `first_name` VARCHAR(150) NOT NULL ,
  `last_name` VARCHAR(150) NOT NULL ,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(255),
  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) );


INSERT INTO Users (first_name, last_name, email, password, type)
   VALUES ('Admin', 'preeti', 'preeti@admin.com', 'test123', '1'),
   ('Customer', 'Preeti', 'preeti@user.com', 'test123', '0')
   ;

---------------------------------------------------------------------------
/*
  SETUP
*/

PHP 7
PHPUnit
php-jwt library
mysql database
postman to test API


HOW TO RUN API

1.Launch POSTMAN.

2.Enter the API url as the request URL

ex:http://localhost/php_test/api/user_login.php

3. Click "Body" tab. Click "raw". Enter input JSON value:

4. Click "Send" button ND  Output will be displayed.


OUTPUT:
output folder shows screenshot of testing API in postman as per bdd.txt

/* API
*/
 ---------------------------------------------------------------------------
//1. USER LOGIN
http://localhost/php_test/api/user_login.php
Input Json:
    {	"email":"preeti@admin.com",
        "password":"test123"
    }
On Success output:
    {
        "message": "Successful login.",
        "status": "Success",
        "code": "200",
        "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJJU1NVRVIiLCJhdWQiOiJBVURJRU5DRSIsImlhdCI6MTU2MjUzNTMxMywibmJmIjoxNTYyNTM1MzIzLCJleHAiOjE1NjI1MzUzNzMsImRhdGEiOnsidHlwZSI6IjEiLCJlbWFpbCI6InByZWV0aUBhZG1pbi5jb20ifX0.xTIg-nYkI3WnBrUSWTAQldBwMPh8dmdBciNHsoCxWw0"
    }
 ---------------------------------------------------------------------------
//2. CREATE COUPON

http://localhost/php_test/api/create_coupon.php
INPUT:

    {
        "name" : " TESCO 5 points",
        "brand" : "tesco ",
        "value" : "5",
        "expiry" : "2019-03-01 10:15:53",
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJJU1NVRVIiLCJhdWQiOiJBVURJRU5DRSIsImlhdCI6MTU2MjUzNTE4NywibmJmIjoxNTYyNTM1MTk3LCJleHAiOjE1NjI1MzUyNDcsImRhdGEiOnsidHlwZSI6IjEiLCJlbWFpbCI6InByZWV0aUBhZG1pbi5jb20ifX0.qdvA6OscBTNNZenxxpls2W8FSw_61maWu3nhT7zV6R0"

    }
OUTPUT on success:
    {
        "message": "Access granted. Coupon was created.",
        "status": "Success",
        "code": "200"
    }

---------------------------------------------------------------------------
 //3. UPDATE COUPON

 http://localhost/php_test/api/update_coupon.php

INPUT:
{
    "name" : "Wickes 5",
    "brand" : "Wickes",
    "value" : "15",
    "expiry" : "2019-07-08 23:00:00",
    "id":15,
	"jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJJU1NVRVIiLCJhdWQiOiJBVURJRU5DRSIsImlhdCI6MTU2MjUzNTE4NywibmJmIjoxNTYyNTM1MTk3LCJleHAiOjE1NjI1MzUyNDcsImRhdGEiOnsidHlwZSI6IjEiLCJlbWFpbCI6InByZWV0aUBhZG1pbi5jb20ifX0.qdvA6OscBTNNZenxxpls2W8FSw_61maWu3nhT7zV6R0"

}

OUTPUT:
{
    "message": "Access granted. Coupon was updated.",
    "status": "Success",
    "code": "200"
}
 
 ---------------------------------------------------------------------------
//4. RETRIEVE

http://localhost/php_test/api/find_coupon.php

INPUT:
    {"id":2,
    "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJJU1NVRVIiLCJhdWQiOiJBVURJRU5DRSIsImlhdCI6MTU2MjUzNTMxMywibmJmIjoxNTYyNTM1MzIzLCJleHAiOjE1NjI1MzUzNzMsImRhdGEiOnsidHlwZSI6IjEiLCJlbWFpbCI6InByZWV0aUBhZG1pbi5jb20ifX0.xTIg-nYkI3WnBrUSWTAQldBwMPh8dmdBciNHsoCxWw0"
    }
OUTPUT:
    {
        "message": "Success",
        "data": [
            {
                "id": "2",
                "name": "asda 5 points",
                "brand": "asda",
                "value": "5",
                "createdAt": "2019-07-08 22:58:28",
                "expiry": "2019-08-02 23:00:00"
            }
        ]
    }

---------------------------------------------------------------------------
 //5. FIND ALL
      FIND WITH PARAMETERS
---------------------------------------------------------------------------
http://localhost/php_test/api/find_all.php
FIND ALL INPUT:
    {
     "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJJU1NVRVIiLCJhdWQiOiJBVURJRU5DRSIsImlhdCI6MTU2MjUzNTMxMywibmJmIjoxNTYyNTM1MzIzLCJleHAiOjE1NjI1MzUzNzMsImRhdGEiOnsidHlwZSI6IjEiLCJlbWFpbCI6InByZWV0aUBhZG1pbi5jb20ifX0.xTIg-nYkI3WnBrUSWTAQldBwMPh8dmdBciNHsoCxWw0"
    }

OUTPUT:
    ALL list data

FIND WITH PARAMETERS INPUT:
    {
        "name" : "tesco",
        "limit" : "2",
        "sortbydate" : "asc",
        "jwt": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJJU1NVRVIiLCJhdWQiOiJBVURJRU5DRSIsImlhdCI6MTU2MjUzNTMxMywibmJmIjoxNTYyNTM1MzIzLCJleHAiOjE1NjI1MzUzNzMsImRhdGEiOnsidHlwZSI6IjEiLCJlbWFpbCI6InByZWV0aUBhZG1pbi5jb20ifX0.xTIg-nYkI3WnBrUSWTAQldBwMPh8dmdBciNHsoCxWw0"

    }

OUTPUT:
    {"message":"Success",
    "count":10,
    "data":[
    {"id":1,"name":"Save £20 at Tesco","brand":"Tesco","value":20,"createdAt":"2018-03-01 10:15:53","expiry":"2019-03-01 10:15:53"},
    {"id":5,"name":"tesco 5 points","brand":"tesco","value":5,"createdAt":"2019-07-08 22:04:23","expiry":"2019-07-20 23:00:00"}]
    }
---------------------------------------------------------------------------