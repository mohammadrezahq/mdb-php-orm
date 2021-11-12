# MSQL / PHP-SQL-ORM

### Setup

Require the class:

`require_once ('msql.php');`

Get an instance of class:

`$msql = new Msql($dbname, $username, $password, $servername, $charset);` 

$dbname = your database name

$username = your database username (default = root)

$password = your database password (default = "")

$servername = server name (default = localhost)

$charset = database's default charset (default = "utf8mb4")

----------------------------------

### Create Table

    
    $tableName = "users";
    $args = [
        "id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
        "email VARCHAR(50)",
        "firstname VARCHAR(30) NOT NULL",
        "lastname VARCHAR(30) NOT NULL"
    ];

    $msql->createTable($tableName, $args);

For this in args, you should know how sql defines it's cols.


### Insert Data
    
    $table = "users";
    $data = [
        "email"=>"thingsome@email.com",
        "firstname"=>"somefirstname",
        "lastname"=>"somelastname"
    ];
    
    $msql->table($table)->insert($data);

### Update Data

    $table = "users";
    $data = [
        "email"=>"something@email.com"
    ];
    
    $msql->table($table)->where('email', 'thingsome@email.com')->update($data);
    
### Get Data

    $table = "users";
    
    $msql->table($table)->getAll(); // Gets all rows
    $msql->table($table)->first(); // Gets first row
    $msql->table($table)->last(); // Gets last row
    
#### Get All
    
    $cols = "firstname,lastname"; // Columns - default is *
    $limit = "2" // Limit of rows - default is 0 (unlimited)
    
    $msql->table('users')->getAll($cols, $limit);
    // For first() and last() method, they only get $cols parameter.

#### Where

    $msql->table('users')->where('id', 1)->getAll();
    
You can use where method as many as you want.

    $msql->table('users')->where('firstname', "somefirstname")->where("lastname","somelastname")->getAll();
    
##### Where with operator

    $msql->table('users')->where('id', 1, ">")->getAll();
    
#### orWhere

    $msql->table('users')->where('id', 1)->orWhere('id', 2)->getAll();
    // orWhere with operator is the same as where.
    
#### Where with Array

You can pass an array with data to whereArray method.

    $data = [
        "firstname"=>"somefirstname",
        "lastname"=>"somelastname"
    ];
    
    $msql->table('users')->whereArray($data)->first();

#### Order By

    $msql->table('users')->order('id', 'DESC')->getALL();


#### Get Count of rows

    $msql->table('users')->where('id',1,'>')->countOfRows(); // return int


### Delete data

    $msql->table('users')->where('email','something@email.com')->delete();
