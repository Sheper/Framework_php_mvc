<?php
class registroModel extends Model
{
    public function __construct(){
        parent::__construct();
    }

    public function verificarUsuario($usuario){
        // echo $usuario;exit;
        $id = $this->_db->query(
            "select id, codigo from usuarios where usuario = '$usuario'"
        );        
        return $id->fetch();
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
        $random = rand(1782598471, 9999999999);
        $this->_db->prepare(
            "insert into usuarios values" .
            "(null, :nombre, :usuario, :pass, :email,now(), 'usuario', 1 , :codigo)"
            )
            ->execute(array(
                ':nombre' => $nombre,
                ':usuario' => $usuario,
                ':pass' => Hash::getHash('sha1',$password,HASH_KEY),
                ':email' => $email,
                ':codigo' => $random
            ));
    }

    public function getUsuario($id , $codigo){
        $usuario = $this->_db->query(
            "select * from usuarios where id = $id and codigo = '$codigo'"
        );
        return $usuario->fetch();
    }
    public function activarUsuario($id , $codigo){
        $this->_db->query(
            "update usuarios set estado= 1" . 
            "where id = $id and codigo = '$codigo'"
        );
    }
}
?>