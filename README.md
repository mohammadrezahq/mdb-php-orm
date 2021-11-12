# MDB / PHP-database-ORM

### Setup

Require mdb with composer:

`composer require mor/mdb`

`use Mor\Mdb as Mdb` 

change yoyr mysql server details in mdb.php file:

```
    protected static $database = [
        "server" => "localhost",
        "name" => "test",
        "username" => "root",
        "password" => "",
        "charset" => "utf8mb4"
    ];

```

----------------------------------

### Create Table

    
    $tableName = "users";
    $args = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "email VARCHAR(50)",
        "firstname VARCHAR(30) NOT NULL",
        "lastname VARCHAR(30) NOT NULL"
    ];

    Mdb::createTable($tableName, $args);

For this in args, you should know how sql defines it's cols.


### Insert Data
    
    $table = "users";
    $data = [
        "email"=>"thingsome@email.com",
        "firstname"=>"somefirstname",
        "lastname"=>"somelastname"
    ];
    
    Mdb::table($table)->insert($data);

### Update Data

    $table = "users";
    $data = [
        "email"=>"something@email.com"
    ];
    
    Mdb::table($table)->where('email', 'thingsome@email.com')->update($data);
    
### Get Data

    $table = "users";
    
    Mdb::table($table)->getAll(); // Gets all rows
    Mdb::table($table)->first(); // Gets first row
    Mdb::table($table)->last(); // Gets last row
    
#### Get All
    
    $cols = "firstname,lastname"; // Columns - default is *
    $limit = "2" // Limit of rows - default is 0 (unlimited)
    
    Mdb::table('users')->getAll($cols, $limit);
    // For first() and last() method, they only get $cols parameter.

#### Where

    Mdb::table('users')->where('id', 1)->getAll();
    
You can use where method as many as you want.

    Mdb::table('users')->where('firstname', "somefirstname")->where("lastname","somelastname")->getAll();
    
##### Where with operator

    Mdb::table('users')->where('id', 1, ">")->getAll();
    
#### orWhere

    Mdb::table('users')->where('id', 1)->orWhere('id', 2)->getAll();
    // orWhere with operator is the same as where.
    
#### Where with Array

You can pass an array with data to whereArray method.

    $data = [
        "firstname"=>"somefirstname",
        "lastname"=>"somelastname"
    ];
    
    Mdb::table('users')->whereArray($data)->first();

#### Order By

    Mdb::table('users')->order('id', 'DESC')->getALL();


#### Get Count of rows

    Mdb::table('users')->where('id',1,'>')->countOfRows(); // return int


### Delete data

    Mdb::table('users')->where('email','something@email.com')->delete();
