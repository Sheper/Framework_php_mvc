<?php
class registroController extends Controller
{
    private $_registro;
    public function __construct(){
        parent::__construct();
        $this->_registro = $this->loadModel('registro');
    }

    public function index(){
        if(Session::get('autenticado')){
            $this->redireccionar();
        }
        $this->_view->titulo = 'Registro';
        if($this->getInt("enviar") == 1){
            $this->_view->datos = $_POST;
            if (!$this->getSql('nombre')){
                $this->_view->_error = 'Debe introducir su nombre';
                $this->_view->renderizar('index','registro');
                exit;
            }
            if (!$this->getAlphaNum('usuario')){
                $this->_view->_error = 'Debe introducir su nombre de usuario';
                $this->_view->renderizar('index','registro');
                exit;
            }
            if ($this->_registro->verificarUsuario($this->getAlphaNum('usuario'))){
                $this->_view->_error = 'El usuario ' . $this->getAlphaNum('usuario'). ' ya existe';
                $this->_view->renderizar('index','registro');
                exit;
            }
            if (!$this->validarEmail($this->getPostParam('email'))){
                $this->_view->_error = 'La dirección de email es inválida';
                $this->_view->renderizar('index','registro');
                exit;
            }
            if ($this->_registro->verificarEmail($this->getPostParam('email'))){
                $this->_view->_error = 'Está Dirección de correo ya esta registrada';
                $this->_view->renderizar('index','registro');
                exit;
            }
            if (!$this->getSql('pass')){
                $this->_view->_error = 'Debe introducir su contraseña';
                $this->_view->renderizar('index','registro');
                exit;
            }
            if ($this->getPostParam('pass') != $this->getPostParam('confirmar')){
                $this->_view->_error = 'Las contraseñas deben ser iguales';
                $this->_view->renderizar('index','registro');
                exit;
            }
            $this->getLibrary('PHPMailer');
            $this->getLibrary('SMTP');
            $this->getLibrary('POP3');
            $mail = new PHPMailer\PHPMailer\PHPMailer();
            // $mail = new PHPMailer();
            $this->_registro->registrarUsuario(
                $this->getSql('nombre'),
                $this->getAlphaNum('usuario'),
                $this->getSql('pass'),
                $this->getPostParam('email')
            );
            $usuario = $this->_registro->verificarUsuario($this->getAlphaNum('usuario'));
            if (!$usuario){
                $this->_view->_error = 'Error al registrar el Usuario';
                $this->_view->renderizar('index','registro');
                exit;
            }
            //Server settings
            // $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = 'smtp.office365.com';  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = 'daniel23_71@hotmail.com';                 // SMTP username
            $mail->Password = 'tyctyc80';                           // SMTP password
            $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587;                                    // TCP port to connect to
            //Recipients
            $mail->setFrom('daniel23_71@hotmail.com', 'Mailer');
            $mail->addAddress($this->getPostParam('email'), 'Mailer');     // Add a recipient
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = 'Correo de Contacto';
            $mail->FromName = 'José Segovia';
            $mail->Body = 'Hola <strong>'.$this->getSql('nombre').'</strong>,' . 
                            '<p>Se ha registrado en www.mvc.Framenworkmvc.com para activar'.
                            'su cuenta haga click sobre el siguiente enlace:<br>'.
                            '<a href="'.BASE_URL.'registro/activar/'.
                            $usuario['id'].'/'.$usuario['codigo'].'">'.
                            BASE_URL.'registro/activar/'.
                            $usuario['id'].'/'.$usuario['codigo'].'</a></p>';
            $mail->AltBody = 'Su servidor de correo no soporta html';
            $mail->Send();
            $this->_view->datos = false;
            $this->_view->_mensaje = 'Registro Completado!!!, revise su email para activar su cuenta';
        }
        $this->_view->renderizar('index','registro');
    }
    public function activar($id, $codigo){
        if(!$this->filtrarInt($id) || !$this->filtrarInt($codigo)){
            $this->_view->_error = "Está cuenta no existe";
            $this->_view->renderizar('activar','registro');
            exit;
        }
        $row = $this->_registro->getUsuario(
            $this->filtrarInt($id),
            $this->filtrarInt($codigo)
        );
        if(!$row){
            $this->_view->_error = "Está cuenta no existe";
            $this->_view->renderizar('activar','registro');
            exit;
        }
        if(!$row['estado']==1){
            $this->_view->_error = "Está cuenta y ha sido Activada";
            $this->_view->renderizar('activar','registro');
            exit;
        }
        $this->_registro->activarUsuario(
            $this->filtrarInt($id),
            $this->filtrarInt($codigo)
        );
        $row = $this->_registro->getUsuario(
            $this->filtrarInt($id),
            $this->filtrarInt($codigo)
        );
        if($row['estado']==0){
            $this->_view->_error = "Error al activar la cuenta, por favor intente más tarde";
            $this->_view->renderizar('activar','registro');
            exit;
        }
        $this->_view->_mensaje = "Su cuenta ha sido activada";
        $this->_view->renderizar('activar','registro');
    }
}
?>