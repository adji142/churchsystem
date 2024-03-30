<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class home extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct()
	{
		parent::__construct();
		$this->load->model('ModelsExecuteMaster');
		$this->load->model('GlobalVar');
		$this->load->model('Notification');
		// $this->load->model('deficeinfo');
		// require APPPATH.'libraries/phpmailer/src/Exception.php';
  //       require APPPATH.'libraries/phpmailer/src/PHPMailer.php';
  //       require APPPATH.'libraries/phpmailer/src/SMTP.php';
	}
	public function testEmail()
	{
		 $response = false;
         $mail = new PHPMailer();
      
        // SMTP configuration
        // $mail->SMTPDebug = 3;
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

        $mail->setFrom('aissystemsolo@gmail.com', ''); // user email
        // $mail->addReplyTo('xxx@hostdomain.com', ''); //user email

        // Dynamic Section

        $lastTRX = 'JDW1240318000003';
		// $CabangID = $json_data['CabangID'];

		$subquery = $this->db->select("penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID, Count(*) JumlahPelayan, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 1 THEN 1 ELSE NULL END) JumlahKonfirmasi, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 0 THEN 1 ELSE NULL END) BelumKonfirmasi")
			->from('penugasanjadwalpelayanan')
			->join('cabang','penugasanjadwalpelayanan.CabangID = cabang.id','left')
			->group_by('penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID')->get_compiled_select();

		$this->db->select("jadwalpelayanan.NoTransaksi, jadwalpelayanan.TglTransaksi,CASE WHEN jadwalpelayanan.JenisTransaksi = 1 THEN 'IBADAH' ELSE 'EVENT' END JenisJadwal, jadwalpelayanan.CabangID, cabang.CabangName,COALESCE(jadwalibadah.NamaIbadah,dataevent.NamaEvent) AS NamaJadwal,COALESCE(DATE_FORMAT(jadwalibadah.MulaiJam,'%T'),DATE_FORMAT(dataevent.TglEvent,'%T')) AS JamMulai, COALESCE(DATE_FORMAT(jadwalibadah.SelesaiJam,'%T'),'SELESAI') AS JamSelesai, sub.JumlahPelayan, sub.JumlahKonfirmasi, sub.BelumKonfirmasi,personel.NoHP, personel.Email, defaulthari.NamaHari,personel.NamaLengkap,penugasanjadwalpelayanan.KonfirmasiID");
		$this->db->from('jadwalpelayanan');
		$this->db->join('jadwalibadah','jadwalpelayanan.JadwalIbadahID=jadwalibadah.id AND jadwalpelayanan.CabangID = jadwalibadah.CabangID','left');
		$this->db->join('dataevent','jadwalpelayanan.EventID=dataevent.NoTransaksi AND jadwalpelayanan.CabangID = dataevent.CabangID','left');
		$this->db->join('cabang','jadwalpelayanan.CabangID = cabang.id','left');
		$this->db->join("($subquery) as sub","jadwalpelayanan.NoTransaksi = sub.NoTransaksi and jadwalpelayanan.CabangID = sub.CabangID",'left');
		$this->db->join('defaulthari','defaulthari.KodeHari = COALESCE(jadwalibadah.Hari,dayname(dataevent.TglEvent))','left');
		$this->db->join('penugasanjadwalpelayanan', 'jadwalpelayanan.NoTransaksi = penugasanjadwalpelayanan.NoTransaksi AND jadwalpelayanan.CabangID = penugasanjadwalpelayanan.CabangID','left');
		$this->db->join('personel','personel.NIK = penugasanjadwalpelayanan.PIC and personel.CabangID = penugasanjadwalpelayanan.CabangID','left');

		$this->db->where('jadwalpelayanan.NoTransaksi', $lastTRX);
		// $this->db->where('jadwalpelayanan.CabangID', $CabangID);

		$saved = $this->db->get();

		// var_dump($saved->result());

		foreach ($saved->result() as $key) {
			// var_dump($key);
			$mail->addAddress($key->Email);
	        $mail->Subject = 'Email Konfirmasi Kehadiran';
	        $mail->isHTML(true);
	        
	        $mailContent = '
	        	<h3><center><b>GTI System</b></center></h3><br>
	            <p>
	            	<b>Hallo '.$key->NamaLengkap.'</b><br>
	            	Anda Mendapat Jadwal Pelayanan Pada :
	            </p>
	            <pre>
	            	Hari 		: '.$key->NamaHari.' <br>
	            	Tanggal 	: '.$key->TglTransaksi.'<br>
	            	Jam 		: '.$key->JamMulai. ' Sampai '.$key->JamSelesai.'<br>
	            <p>
	            Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.
	            <a href="'.base_url().'pelayanan/konfirmasi/'.$key->KonfirmasiID.'">Klik disini</a>
	            Best Regards<br><br>
	            </p>
	        ';
	        $mail->Body = $mailContent;

	        if(!$mail->send()){
	            echo 'Message could not be sent.';
	            echo 'Mailer Error: ' . $mail->ErrorInfo;
	        }else{
	            echo 'Message has been sent to '.$key->Email.'<br>' ;
	        }
		}

        // Send email
        
	}
	public function test()
	{
		// echo $this->GlobalVar->systemInfo();
		$defTime = strtotime('00:00:01');
		$Jam = strtotime('01:44:05');
		$TanggalDetail = getDate($Jam);

		$oLokasi = $this->ModelsExecuteMaster->FindData(array('LocationID'=>'1','RecordOwnerID'=> 'CL0001'), 'tshift');
		$tempDate = '2023-07-26';

		// var_dump(getDate($Tanggal));

		foreach ($oLokasi->result() as $key) {

			if ($key->GantiHari == "1") {
				$mulai = strtotime($key->MulaiBekerja);
				$selesai = strtotime($key->SelesaiBekerja);

				if ($defTime < $Jam && $Jam < $selesai ) {
					echo "Ganti Hari";
				}
			}

			// if ($Jam > $defTime && $Jam < $selesai && $selesai < $defTime) {
			// 	# code...
			// 	echo 'Shift: '.$key->NamaShift.' Standar : '.$defTime. ' Mulai: '.$mulai. " Selesai: ".$selesai."<BR>";
			// }

			// echo $Tanggal > $mulai;
			// echo $Tanggal < $selesai;
		}
	}

	public function testSendNotif()
	{
		$this->Notification->BroadcastTopic('SOSTopic1');
	}
	public function index()
	{

		if ($this->session->userdata('UserID') == "") {
			delete_cookie('ci_session');
      		$this->session->sess_destroy();
      		echo "<script>location.replace('".base_url()."');</script>";
		}
		else{
			$rs = $this->ModelsExecuteMaster->GetCabang();
		
			$data['CabangID'] = $this->session->userdata('CabangID');
			$data['CabangName'] = $this->session->userdata('CabangName');
			$data['Cabang'] = $rs->result();
			$this->load->view('Dashboard', $data);
		}
	}
	public function generatePascode()
	{
		$data = array('success' => false ,'message'=>array(),'data'=>array());
		$passcode = $this->input->post('passcode');
		$validTo = $this->input->post('validTo');

		$nowDate = date("y-m-d h:i:s");
		$validDate = date("y-m-d h:i:s",strtotime($nowDate. ' + '.$validTo.' days'));
		$oParam = array(
			'Passcode'	=> $this->encryption->encrypt($passcode),
			'ValidTo'	=> $validDate,
			'Status'	=> 1
		);

		$rs = $this->ModelsExecuteMaster->ExecInsert($oParam,'pascode');

		if ($rs) {
			$data['success'] = true;
			$data['message'] = 'This Passcode Valid Until : '.$validDate;
		}
		else{
			$data['success'] = false;
			$data['message'] = 'failed to create passcode';	
		}

		echo json_encode($data);
	}
	public function verifikasiPascode()
	{
		$data = array('success' => false ,'message'=>'','data'=>array());
		$passcode = $this->input->post('passcode');

		$nowDate = date("y-m-d h:i:s");

		$SQL = "SELECT * FROM pascode WHERE ValidTo > '".$nowDate."' AND Status = 1 ";

		$rs = $this->db->query($SQL);
		// var_dump($rs->result());
		$message = '';
		if ($rs->num_rows() > 0) {
			foreach ($rs->result() as $key) {
				if ($this->encryption->decrypt($key->Passcode) == $passcode) {
					$data['success'] = true;
					$message = 'Passcode Valid';

					$this->ModelsExecuteMaster->ExecUpdate(array('Status'=>'0'),array('id'=>$key->id),'pascode');

					// Set Session
					$sess_data['passcode'] = $key->id;
					$this->session->set_userdata($sess_data);
					goto jump;
				}
			}
		}
		else{
			$data['success'] = false;
			$data['message'] = 'Pascode Expired';
		}

		if ($message == '') {
			$data['success'] = false;
			$message = 'Invalid Passcode';
			// var_dump($message.' - - - ');
		}

		jump:
		$data['message'] = $message;

		echo json_encode($data);
	}
	public function register()
	{
		$this->load->view('passcode');
	}
	public function complateregister()
	{
		$this->load->view('applyDocument');
	}

	public function LoadPerformaPatroli()
	{
		$data = array('success' => false ,'message'=>'','data'=>array());

		$TglAwal = $this->input->post('TglAwal');
		$TglAkhir = $this->input->post('TglAkhir');
		$RecordOwnerID = $this->input->post('RecordOwnerID');
		$LocationID = $this->input->post('LocationID');

		$targetPatroli =array();
		$realisasiPatroli =array();

		$output = array();

		// Target
		$oWhereTarget = array(
			'RecordOwnerID' => $RecordOwnerID
		);

		if ($LocationID != "") {
			$oWhereTarget['LocationID'] = $LocationID;
		}

		$target = $this->ModelsExecuteMaster->FindData($oWhereTarget,'tcheckpoint');

		if ($target->num_rows() > 0) {
			for ($i=0; $i < 12 ; $i++) {
				$year = explode("-", $TglAwal);
				$d=cal_days_in_month(CAL_GREGORIAN, $i+1 ,$year[0]);
				array_push($targetPatroli, $target->num_rows() * $d);
			}
		}
		else{
			for ($i=0; $i < 12 ; $i++) { 
				array_push($targetPatroli, 0);
			}
		}

		$data['data']['target'] = $targetPatroli;

		// end Target

		// Realisasi

		$owhere = array(
            'RecordOwnerID'     		=> $RecordOwnerID,
            'CAST(TanggalPatroli AS DATE) >='  => $TglAwal,
            'CAST(TanggalPatroli AS DATE) <='	=> $TglAkhir
        );

        if ($LocationID != "") {
			$owhere['LocationID'] = $LocationID;
		}

		$this->db->select('MONTH(TanggalPatroli) as Bulan, COUNT(*) as Realisai ');
		$this->db->from('patroli');
		$this->db->where($owhere);
		$this->db->group_by('MONTH(TanggalPatroli)');
		$this->db->order_by('MONTH(TanggalPatroli)');

		$rs = $this->db->get();

		if ($rs->num_rows() > 0) {
			foreach ($rs->result() as $key) {
				// var_dump($key['Realisai']);
				array_push($realisasiPatroli, intval($key->Realisai));
			}

			for ($i=0; $i < 12 - $rs->num_rows() ; $i++) { 
				array_push($realisasiPatroli, 0);
			}

			$data['data']['realisasi'] = $realisasiPatroli;
			$data['success'] = true;
			$data['message'] = '';
		}

		echo json_encode($data);
	}
	// --------------------------------------- Master ----------------------------------------------------
	public function permission()
	{
		$this->load->view('V_Auth/permission');
	}
	public function role()
	{
		$this->load->view('V_Auth/roles');
	}
	public function permissionrole($value)
	{
		$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$value),'roles');
		$data['roleid'] = $value;
		$data['rolename'] = $rs->row()->rolename;
		$this->load->view('V_Auth/permissionrole',$data);	
	}
	public function user()
	{
		$this->load->view('V_Auth/users');
	}
	public function login()
	{
		$this->load->view('Index');
	}
	public function changePass()
	{
		$this->load->view('changepassword');
	}

	// Master
	public function cabang()
	{
		$this->load->view('V_Master/Cabang');
	}
	public function checkpoint()
	{
		$this->load->view('V_Master/CheckPoint');
	}
	public function security()
	{
		$this->load->view('V_Master/Security');
	}
	public function shift($value)
	{
		$data['LocationID'] = $value;
		
		$this->load->view('V_Master/shift',$data);	
	}
	public function jadwal($value)
	{
		$data['NIK'] = $value;
		
		$this->load->view('V_Master/jadwal',$data);	
	}

	// Report
	public function readReview()
	{
		$this->load->view('V_Report/reviewpatroli');
	}
	public function loadmap($value)
	{
		$data['latlang'] = $value;
		$this->load->view('V_Report/map',$data);	
	}
	public function readReviewabsen()
	{
		$this->load->view('V_Report/reviewabsen');
	}

	public function readBukuTamu()
	{
		$this->load->view('V_Report/reviewbukutamu');
	}
	public function readDailyActivity()
	{
		$this->load->view('V_Report/reviewdailyactivity');
	}
}
