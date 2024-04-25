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
		public function SendMessageFonnte(){
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$this->db->select('*');
			$this->db->from('blastmessage');
			$this->db->where('Sended',0);
			$blast = $this->db->get();

			if ($blast->num_rows() > 0) {
				$row = 1;
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
						$curl = curl_init();

						curl_setopt_array($curl, array(
						CURLOPT_URL => 'https://api.fonnte.com/send',
						CURLOPT_RETURNTRANSFER => true,
						CURLOPT_ENCODING => '',
						CURLOPT_MAXREDIRS => 10,
						CURLOPT_TIMEOUT => 0,
						CURLOPT_FOLLOWLOCATION => true,
						CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
						CURLOPT_CUSTOMREQUEST => 'POST',
						CURLOPT_POSTFIELDS => array(
						'target' => $key->Penerima,
						'message' => $key->Message,
						'url' => '',
						'filename' => '',
						'schedule' => '0',
						'typing' => true,
						'delay' => '300-600',
						'countryCode' => '62',
						'file' => '',
						'location' => ''
						),
						  CURLOPT_HTTPHEADER => array(
						    'Authorization: Ufe_aRt8Jbaru#mv#3Dz'
						  ),
						));

						$response = curl_exec($curl);
						if (curl_errno($curl)) {
						  $error_msg = curl_error($curl);
						}
						curl_close($curl);

						if ($response === false) {
							if (isset($error_msg)) {
							 // echo $error_msg;
							 $data['message'] = $error_msg;
							}
							// $error = curl_error($ch);
							
						}
						else{
							$data['success'] = true;
							$data['data'] = $response;
						}
						echo $response;
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

					sleep(300);
					$row += 1;
				}
			}
			else{
				$data['message'] = 'No Record';
			}
			echo json_encode($data);
		}
		public function SendMessage()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$this->db->select('*');
			$this->db->from('blastmessage');
			$this->db->where('Sended',0);

			$blast = $this->db->get();

			if ($blast->num_rows() > 0) {
				$row = 1;
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
						$sender = "";
						if ($row % 2 != 0) {
						    // echo "Hasil pembagian menghasilkan angka desimal.";
						    $sender= "628895796897";
						} else {
						    // echo "Hasil pembagian tidak menghasilkan angka desimal.";
						    $sender= "628895796938";
						}


						$sender = "6285291811663";


						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, 'https://whats.tiberias.id/send-message');
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
							'api_key'	=> 'cczWqmimNi10ZPUnO8rdNQl1nzBqlk',
							'sender'	=> $sender,
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

					sleep(60);
					$row += 1;
				}
			}

			echo json_encode($data);
		}
	}
?>