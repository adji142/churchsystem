<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

	class NotificationController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');

			require APPPATH.'libraries/phpmailer/src/Exception.php';
	        require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
	        require APPPATH.'libraries/phpmailer/src/SMTP.php';
		}

		public function SendMessage()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$this->db->select('*');
			$this->db->from('blastmessage');
			$this->db->where('Sended',0);

			$blast = $this->db->get();

			if ($blast->num_rows() > 0) {
				foreach ($blast->result() as $key) {
					if ($key->Chanel == "email") {
						$response = false;
				        $mail = new PHPMailer();
				        $mail->SMTPOptions = array(
						    'ssl' => array(
						        'verify_peer' => false,
						        'verify_peer_name' => false,
						        'allow_self_signed' => true,
						        'debug' => true // Enable SSL/TLS debugging
						    )
						);

						$mail->isSMTP();
				        $mail->Host     = 'smtp.gmail.com'; //sesuaikan sesuai nama domain hosting yang digunakan
				        $mail->SMTPAuth = true;
				        $mail->Username = 'aissystemsolo@gmail.com'; // user email
				        $mail->Password = 'dpydlswynftsmgme'; // password email
				        $mail->SMTPSecure = 'ssl';
				        $mail->Port     = 465;
				        $mail->Timeout = 60; 
				        $mail->SMTPKeepAlive = true;

				        $mail->setFrom('aissystemsolo@gmail.com', '');

				        $mail->addAddress($key->Penerima);
				        $mail->Subject = 'Email Konfirmasi Kehadiran';
				        $mail->isHTML(true);

				        $mail->Body = $key->Message;

				        if(!$mail->send()){
				            $data['message']= $mail->ErrorInfo;
				        }else{
				            $data['success'] = true;
				        }

					}
					elseif ($key->Chanel == "whats") {
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, 'https://whats.tiberias.id/send-message');
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
							'api_key'	=> 'sYCiOOQ7aMIe1RLkazq0dHIq3j7i4F',
							'sender'	=> '6285950484669',
							'number'	=> $key->Penerima,
							'message'	=> $key->Message
						]));

						$response = curl_exec($ch);

						if ($response === false) {
							$error = curl_error($ch);
							$data['message'] = $error;
						}
						else{
							$data['success'] = true;
							$data['data'] = $response;
						}
						curl_close($ch);
					}
					else{
						$data['message'] = 'Unknown Chanel';
					}

					// Update Status

					$oUpdateObject = array(
						'Sended'=> 1,
						'SendedOn' => date('Y-m-d h:i:s'),
						'ReturnMessage' => json_encode($data)
					);

					$this->ModelsExecuteMaster->ExecUpdate($oUpdateObject,array('id'=> $key->id),'blastmessage');
				}
			}

			echo json_encode($data);
		}
	}
?>