<?php
defined('BASEPATH') OR exit('No se permite el acceso directo.');

class Acceso extends CI_Controller{

	public function __construct(){
		parent::__construct();
		$this->load->model('Acceso_model');
		$this->load->model('Usuario_model');
	}

	public function login(){
		$this->form_validation->set_rules('email', 'Email', 'min_length[4]|max_length[100]|required|htmlspecialchars|trim|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'min_length[4]|max_length[100]|required|htmlspecialchars|trim');

		if($this->form_validation->run()){
			$email = $this->input->post('email');
			$password = $this->input->post('password');

			if($this->Acceso_model->login($email) != NULL){
				$user = $this->Acceso_model->login($email);
				//Si existe el correo y se recibe el usuario completo
				if($user->pass == md5($password)){
						//La contraseña también coincide
						$data = array(
							'email' => $email,
							'id' => $user->idUsuario,
							'rol' => $user->rol,
							'login' => true
						);

						$this->session->set_userdata($data);

						$respuesta = array();
						$respuesta['resultado'] = 'true';
						$respuesta['mensaje'] = 'Sesión iniciada';
						$respuesta['usuario'] = $user;
						echo json_encode($respuesta);
					}
				else{
					$respuesta = array();
					$respuesta['resultado'] = 'false';
					$respuesta['mensaje'] = 'La contraseña no es correcta';
					echo json_encode($respuesta);
				}
			}
			else{
				//No existe el correo
				$respuesta = array();
				$respuesta['resultado'] = 'false';
				$respuesta['mensaje'] = 'El correo electrónico no está registrado';
				echo json_encode($respuesta);
			}

		}
		else{
			$this->form_validation->set_error_delimiters('','');
			$respuesta = array();
			$respuesta['resultado'] = 'false';
			$respuesta['mensaje'] = validation_errors();
			echo json_encode($respuesta);
		}
	}

	public function register(){
		$this->form_validation->set_rules('name', 'Name', 'min_length[4]|max_length[100]|required|htmlspecialchars|trim');
		$this->form_validation->set_rules('email', 'Email', 'min_length[4]|max_length[100]|required|htmlspecialchars|trim|valid_email|is_unique[user.email_use]');
		$this->form_validation->set_rules('password', 'Password', 'min_length[4]|max_length[100]|required|htmlspecialchars|trim');
		$this->form_validation->set_rules('empresa', 'empresa', 'min_length[1]|max_length[100]|required|htmlspecialchars|trim');

		if($this->form_validation->run()){
			$name = $this->input->post('name');
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));
			$empresa = $this->input->post('empresa');

			$data_user = array(
				'nom_use' => $name,
				'email_use' => $email,
				'pass_use' => $password,
				'emp_use' => $empresa,
			);

			$user = $this->Acceso_model->register($data_user);

			if($user != NULL){

				$respuesta = array();
				$respuesta['resultado'] = 'true';
				$respuesta['mensaje'] = 'Se creó correctamente la cuenta, <font color="red">avisa a un administrador del sistema para que active tu cuenta</font>';
				echo json_encode($respuesta);
			}
			else{
				$respuesta = array();
				$respuesta['resultado'] = 'false';
				$respuesta['mensaje'] = 'Hubo un error al insertar el usuario';
				echo json_encode($respuesta);
			}

		}
		else{
			$this->form_validation->set_error_delimiters('','');
			$respuesta = array();
			$respuesta['resultado'] = 'false';
			$respuesta['mensaje'] = validation_errors();
			echo json_encode($respuesta);
		}
	}

	public function recovery() {
		$this->form_validation->set_rules('email', 'Email', 'min_length[4]|max_length[100]|required|htmlspecialchars|trim|valid_email');

		if($this->form_validation->run()){
			$to_email = $this->input->post('email');

			if($this->Usuario_model->getByEmail($to_email) != NULL){
				$user_send = "Inventarios TAQ";
		        $asunto = "Recuperación de contraseña";
		        //Generar contraseña
		        $key = "";
			    $pattern = "1234567890abcdefghijklmnopqrstuvwxyz";
			    $max = strlen($pattern)-1;
			    for($i = 0; $i < 10; $i++){
			        $key .= substr($pattern, mt_rand(0,$max), 1);
			    }

			    if($this->Usuario_model->updatePasswordByEmail($to_email, $key) != NULL){
			    	$html = 'Este correo es para recuperar la contraseña de tu cuenta, si no solicitaste esa operación por favor ignora el correo.<br>Tu nueva contraseña es: ' . $key;
			        $attach = null;

			        $CI = &get_instance();
			        $CI->load->library('email', null, 'ci_email');

			        $config['protocol'] = 'smtp';
			        $config['charset'] = 'utf-8';
			        $config['wordwrap'] = true;
			        $config['smtp_host'] = 'smtp.gmail.com';
			        $config['smtp_user'] = 'mialanuteq@gmail.com';
			        $config['smtp_pass'] = 'mialan123';
			        $config['smtp_port'] = 587;
			        $config['smtp_crypto'] = 'tls';
			        $config['mailtype'] = 'html';
			        $config['newline'] = "\r\n";
			        $config['crlf'] = "\r\n";
			        $CI->ci_email->initialize($config);

			        $from_email = 'mialanuteq@gmail.com';

			        $CI->ci_email->from($from_email, $user_send);
			        $CI->ci_email->to($to_email);
			        $CI->ci_email->subject($asunto);
			        if (!is_null($attach)) {
			            // var_dump($attach);
			            $CI->ci_email->attach($attach);
			        }
			        $CI->ci_email->message($html);
			        $CI->ci_email->send();

					$this->form_validation->set_error_delimiters('','');
					$respuesta = array();
					$respuesta['resultado'] = 'false';
					$respuesta['mensaje'] = 'En caso de ser correcto el email, recibirás tu nueva contraseña ahí';
					echo json_encode($respuesta);
			    }
			}
			else{
				$this->form_validation->set_error_delimiters('','');
				$respuesta = array();
				$respuesta['resultado'] = 'false';
				$respuesta['mensaje'] = 'En caso de ser correcto el email, recibirás tu nueva contraseña ahí';
				echo json_encode($respuesta);
			}
    	}
	    else{
			$this->form_validation->set_error_delimiters('','');
			$respuesta = array();
			$respuesta['resultado'] = 'false';
			$respuesta['mensaje'] = validation_errors();
			echo json_encode($respuesta);
		}
    }

	public function logout(){
		$this->session->sess_destroy();
		redirect(base_url());
	}

}
?>