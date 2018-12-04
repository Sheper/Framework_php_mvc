<?php
class Database extends PDO{
    private $dbh;
    public function __construct(){
        // print_r (DB_CHAR);exit;
        parent::__construct(
            'mysql:host='.DB_HOST.
            ';dbname='.DB_NAME,DB_USER,DB_PASS,
            array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
        // $this->dbh= new PDO('mysql:host=localhost;dbname=mvc', "root", "");
    }
}
?>