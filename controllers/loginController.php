<?php
class loginController extends Controller
{
    private $_login;
    public function __construct(){
        parent::__construct();
        $this->_login = $this->loadModel('login');
    }
    public function index(){        
        if (Session::get('autenticado')) 
        {
            $this->redireccionar();
        }
        $this->_view->titulo = 'Iniciar Sesion';
        if($this->getInt('enviar') == 1){            
            $this->_view->datos =  $_POST;
            if(!$this->getAlphaNum('usuario')){
                $this->_view->_error = 'Debe introducir el nombre de usuario';
                $this->_view->renderizar('index','login');
                exit;
            }
            if(!$this->getSql('pass')){
                $this->_view->_error = 'Debe introducir la password de usuario';
                $this->_view->renderizar('index','login');
                exit;
            }            
            $row = $this->_login->getUsuario(
                $this->getAlphaNum('usuario'),
                $this->getSql('pass')
            );
            
            if(!$row){
                $this->_view->_error = 'Usuario y/o Password incorrectos';
                $this->_view->renderizar('index','login');
            }
            if($row['estado']!=1){
                $this->_view->_error = 'Este Usuario no está habilitado';
                $this->_view->renderizar('index','login');
            }

            Session::set('autenticado',true);
            Session::set('level',$row['role']);
            Session::set('usuario',$row['usuario']);
            Session::set('id_usuario',$row['id']);
            Session::set('tiempo',time());
            $this->redireccionar();
        }
        $this->_view->renderizar('index','login');
        

        // Session::set('var1','var1');
        // Session::set('var2','var2');
        // $this->redireccionar('login/mostrar');
    }
    // public function mostrar(){
    //     echo 'Level:'.Session::get('level').'<br>';
    //     echo 'Var1:'.Session::get('var1').'<br>';
    //     echo 'Var2:'.Session::get('var2').'<br>';
    // }

    public function cerrar(){
        Session::destroy();
        $this->redireccionar();
    }
}
?>