<?php
class loginModel extends Model{
    public function __construct(){
        parent::__construct();
    }
    public function getUsuario($usuario, $password){
        // print_r("password");exit;
        // print_r($usuario);
        // print_r($password);exit;
        $datos = $this->_db->query(
            "select * from usuarios " .
            "where usuario = '$usuario' ".
            "and pass = '". Hash::getHash('sha1',$password,HASH_KEY) ."'"
        );
        return $datos->fetch();
    }
}
?>