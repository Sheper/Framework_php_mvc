<?php
class registroModel extends Model
{
    public function __construct(){
        parent::__construct();
    }

    public function verificarUsuario($usuario){
        $id = $this->_db->query(
            "select id from usuarios where usuario = '$usuario'"
        );
        if($id->fetch()){
            return true;
        }
        return false;
    }
    public function verificarEmail($email){
        $id = $this->_db->query(
            "select id from usuarios where email = '$email'"
        );
        if($id->fetch()){
            return true;
        }
        return false;
    }
    public function registrarUsuario($nombre,$usuario,$password,$email){        
        $this->_db->prepare(
            "insert into usuarios values" .
            "(null, :nombre, :usuario, :pass, :email,now(), 'usuario', 1)"
            )
            ->execute(array(
                ':nombre' => $nombre,
                ':usuario' => $usuario,
                ':pass' => Hash::getHash('sha1',$password,HASH_KEY),
                ':email' => $email
            ));
    }
}
?>