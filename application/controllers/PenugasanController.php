<?php 
	class PenugasanController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function ReadHeader()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$DivisiID = $this->input->post('DivisiID');

			$this->db->select('penugasanpelayan.Tanggal AS TglTransaksi, penugasanpelayan.NoTransaksi,divisi.NamaDivisi, COUNT(*) JumlahPelayan, SUM(CASE WHEN COALESCE(penugasanpelayan.Konfirmasi,0) = 0 THEN 1 ELSE 0 END ) AS BelumKonfirmasi, SUM(CASE WHEN COALESCE(penugasanpelayan.Konfirmasi,0) = 1 THEN 1 ELSE 0 END ) AS JumlahKonfirmasiHadir, SUM(CASE WHEN COALESCE(penugasanpelayan.Konfirmasi,0) = 2 THEN 1 ELSE 0 END ) AS JumlahKonfirmasiTidakHadir');
			$this->db->from('penugasanpelayan');
			$this->db->join('divisi', 'penugasanpelayan.DivisiID = divisi.id','left');
			$this->db->join('defaulthari', 'penugasanpelayan.Hari = defaulthari.KodeHari','left');
			$this->db->where('penugasanpelayan.Tanggal >=', $TglAwal);
			$this->db->where('penugasanpelayan.Tanggal <=', $TglAkhir);

			if ($DivisiID != "") {
				$this->db->where('penugasanpelayan.DivisiID', $DivisiID);
			}
			$this->db->group_by("penugasanpelayan.Tanggal, penugasanpelayan.NoTransaksi,divisi.NamaDivisi");
			$oData = $this->db->get();

			$data['success'] = true;
			$data['data'] = $oData->result();


			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function ReadDetail()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$NoTransaksi = $this->input->post('NoTransaksi');

			$this->db->select("penugasanpelayan.*, 
				divisi.NamaDivisi,CONCAT(personel.GelarDepan,' ',personel.NamaLengkap, ' ', personel.GelarBelakang) As NamaLengkap, 
				CASE WHEN penugasanpelayan.Konfirmasi = 1 THEN 'Y' ELSE CASE WHEN penugasanpelayan.Konfirmasi = 2 THEN 'N' ELSE '' END END AS diKonfirmasi, 
				penugasanpelayan.KonfirmasiKeterangan, cabang.CabangName, jadwalibadah.NamaIbadah, 
				DATE_FORMAT(jadwalibadah.MulaiJam,'%T') AS JamMulai, 
				DATE_FORMAT(jadwalibadah.SelesaiJam,'%T') AS JamSelesai");
			$this->db->from('penugasanpelayan');
			$this->db->join('divisi', 'penugasanpelayan.DivisiID = divisi.id','left');
			$this->db->join('defaulthari', 'penugasanpelayan.Hari = defaulthari.KodeHari','left');
			$this->db->join('personel', 'penugasanpelayan.PIC = personel.NIK', 'LEFT');
			$this->db->join('cabang', 'penugasanpelayan.CabangID = cabang.id', 'LEFT');
			$this->db->join('jadwalibadah', 'penugasanpelayan.JadwalIbadahID = jadwalibadah.id', 'LEFT');
			$this->db->where('penugasanpelayan.NoTransaksi', $NoTransaksi);

			$oData = $this->db->get();
			$data['data'] = $oData->result();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));

		}

		public function ReadKonfirmasiList()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$NoTransaksi = $this->input->post('NoTransaksi');
			$CabangID = $this->input->post('CabangID');
			$NikPersonel = $this->input->post('NikPersonel');
			$NoReff = $this->input->post('NoReff');

			$this->db->select("penugasanpelayan.*, 
				divisi.NamaDivisi,CONCAT(personel.GelarDepan,' ',personel.NamaLengkap, ' ', personel.GelarBelakang) As NamaLengkap, 
				CASE WHEN COALESCE(penugasanpelayan.Konfirmasi,0) = 0 THEN 'N' ELSE 'Y' END AS diKonfirmasi, 
				penugasanpelayan.KonfirmasiKeterangan, cabang.CabangName, jadwalibadah.NamaIbadah, 
				DATE_FORMAT(jadwalibadah.MulaiJam,'%T') AS JamMulai, 
				DATE_FORMAT(jadwalibadah.SelesaiJam,'%T') AS JamSelesai");
			$this->db->from('penugasanpelayan');
			$this->db->join('divisi', 'penugasanpelayan.DivisiID = divisi.id','left');
			$this->db->join('defaulthari', 'penugasanpelayan.Hari = defaulthari.KodeHari','left');
			$this->db->join('personel', 'penugasanpelayan.PIC = personel.NIK', 'LEFT');
			$this->db->join('cabang', 'penugasanpelayan.CabangID = cabang.id', 'LEFT');
			$this->db->join('jadwalibadah', 'penugasanpelayan.JadwalIbadahID = jadwalibadah.id', 'LEFT');
			$this->db->where('penugasanpelayan.Tanggal >= ',$TglAwal);
			$this->db->where('penugasanpelayan.Tanggal <= ',$TglAkhir);
			$this->db->where('COALESCE(penugasanpelayan.Konfirmasi,0)', "0");

			if ($NoTransaksi != "") {
				$this->db->where(array("penugasanpelayan.NoTransaksi"=>$NoTransaksi));
			}

			if ($CabangID != "0") {
				$this->db->where(array("penugasanpelayan.CabangID"=>$CabangID));
			}

			if ($NoReff != "") {
				$this->db->where(array("penugasanpelayan.NoTransaksi"=>$NoReff));
			}

			if ($NikPersonel != "") {
				$this->db->where(array("penugasanpelayan.PIC"=>$NikPersonel));
			}

			$oData = $this->db->get();
			$data['data'] = $oData->result();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function ReadIfExist()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$TglTransaksi = $this->input->post('Tanggal');
			$Hari = $this->input->post('Hari');
			$DivisiID = $this->input->post('DivisiID');

			$oWhere = array(
				'Tanggal' => $TglTransaksi,
				'Hari' => $Hari,
				'DivisiID' => $DivisiID
			);
			$penugasan = $this->ModelsExecuteMaster->FindData($oWhere,'penugasanpelayan');

			$data['success'] = true;
			$data['data'] = $penugasan->result();

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function CRUD()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$json_data = json_decode(file_get_contents('php://input'), true);

			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');

			$lastTRX = "";

			$errorCount = 0;
			try {
				$this->db->trans_start();

				// Begin Transaction

				$formtype = $json_data['formtype'];

				if ($formtype == "add") {
					$NoTransaksi = "";
					if ($formtype == "add") {
						$prefix = 'JDW'.substr(date('Ymd'),2,4);

						// Get Distinct Data
						$this->db->select('NoTransaksi');
						$this->db->distinct();
						$this->db->from('penugasanpelayan');
						$this->db->where('LEFT(NoTransaksi,7)',$prefix);
						$lastNoTrx = $this->db->count_all_results();

						$NoTransaksi = $prefix.str_pad($lastNoTrx + 1, 4, '0', STR_PAD_LEFT);
					}

					for ($i=0; $i < count($json_data['detail']) ; $i++) {
						$lastTRX = ($formtype == "add") ? $NoTransaksi : $json_data['detail'][$i]['NoTransaksi'];
						$oRowID = $this->uuid->v4();;
						$oObject = array(
							'RowID' => $oRowID,
							'NoTransaksi' => ($formtype == "add") ? $NoTransaksi : $json_data['detail'][$i]['NoTransaksi'],
							'DivisiID' => $json_data['detail'][$i]['DivisiID'],
							'Tanggal' => $json_data['detail'][$i]['Tanggal'],
							'Hari' => $json_data['detail'][$i]['Hari'],
							'JenisIbadah' => -1,
							'CabangID' => $json_data['detail'][$i]['CabangID'],
							'JadwalIbadahID' => $json_data['detail'][$i]['JadwalIbadahID'],
							'PIC' => $json_data['detail'][$i]['PIC'],
							'RatePK' => 0,
							'Keterangan' => $json_data['detail'][$i]['Keterangan'],
							'KonfirmasiID' => $oRowID,
							'Konfirmasi' => 0
						);


						if ($formtype == 'add') {
							$oObject['CreatedOn'] = $CreatedOn;
							$oObject['CreatedBy'] = $CreatedBy;
							$oSave = $this->db->insert('penugasanpelayan',$oObject);

							if (!$oSave) {
								$data['message'] = "Gagal Simpan Penugasan Pelayanan";
			                    $errorCount +=1;
								goto jump;
							}
						}

					}
				}
				elseif ($formtype == "edit") {

					for ($i=0; $i < count($json_data['detail']) ; $i++) {
						$oRowID = $this->uuid->v4();
						// Delete Object
						if ($i == 0) {
							$this->db->where('NoTransaksi',$json_data['detail'][$i]['NoTransaksi']);
							$this->db->delete('penugasanpelayan');
						}
						// Add Object
						$oObject = array(
							'RowID' => $oRowID,
							'NoTransaksi' => $json_data['detail'][$i]['NoTransaksi'],
							'DivisiID' => $json_data['detail'][$i]['DivisiID'],
							'Tanggal' => $json_data['detail'][$i]['Tanggal'],
							'Hari' => $json_data['detail'][$i]['Hari'],
							'JenisIbadah' => -1,
							'CabangID' => $json_data['detail'][$i]['CabangID'],
							'JadwalIbadahID' => $json_data['detail'][$i]['JadwalIbadahID'],
							'PIC' => $json_data['detail'][$i]['PIC'],
							'RatePK' => 0,
							'Keterangan' => $json_data['detail'][$i]['Keterangan'],
							'KonfirmasiID' => $oRowID,
						);


						if ($formtype == 'edit') {
							$oObject['UpdatedOn'] = $UpdatedOn;
							$oObject['UpdatedBy'] = $UpdatedBy;
							$oSave = $this->db->insert('penugasanpelayan',$oObject);

							if (!$oSave) {
								$data['message'] = "Gagal Simpan Penugasan Pelayanan";
			                    $errorCount +=1;
								goto jump;
							}
						}

					}

				}
			} catch (Exception $e) {
				$data['message'] = $e->message;
				$errorCount += 1;
				goto jump;
			}

			jump:
			$this->db->trans_complete();
			if ($errorCount > 0) {
				$error = $this->db->error();
			    $this->db->trans_rollback();

			    if($error['code']) {
			    	$data['message'] = $error['message'];	
			    }
			}
			else{
				$this->db->trans_commit();
			    $data['success'] =true;
				$data['message'] = "Data Jenis Event Berhasil disimpan";

				// Save Notification

				$this->db->select("penugasanpelayan.*, 
					divisi.NamaDivisi,CONCAT(personel.GelarDepan,' ',personel.NamaLengkap, ' ', personel.GelarBelakang) As NamaLengkap, 
					CASE WHEN penugasanpelayan.Konfirmasi = 1 THEN 'Y' ELSE CASE WHEN penugasanpelayan.Konfirmasi = 2 THEN 'N' ELSE '' END END AS diKonfirmasi, 
					penugasanpelayan.KonfirmasiKeterangan, cabang.CabangName, jadwalibadah.NamaIbadah, 
					DATE_FORMAT(jadwalibadah.MulaiJam,'%T') AS JamMulai, 
					DATE_FORMAT(jadwalibadah.SelesaiJam,'%T') AS JamSelesai,
					defaulthari.NamaHari, personel.Email, personel.NoHP");
				$this->db->from('penugasanpelayan');
				$this->db->join('divisi', 'penugasanpelayan.DivisiID = divisi.id','left');
				$this->db->join('defaulthari', 'penugasanpelayan.Hari = defaulthari.KodeHari','left');
				$this->db->join('personel', 'penugasanpelayan.PIC = personel.NIK', 'LEFT');
				$this->db->join('cabang', 'penugasanpelayan.CabangID = cabang.id', 'LEFT');
				$this->db->join('jadwalibadah', 'penugasanpelayan.JadwalIbadahID = jadwalibadah.id', 'LEFT');
				$this->db->where('penugasanpelayan.NoTransaksi', $lastTRX);

				$saved = $this->db->get();
				$oParam = array(
					'BaseEntry' => $lastTRX
				);
				$this->ModelsExecuteMaster->DeleteData($oParam,'blastmessage');

				foreach ($saved->result() as $key) {
					if ($key->Email != "") {
						$message = '
				        	<h3><center><b>Tiberias System</b></center></h3><br>
				            <p>
				            	<b>Shalom '.$key->NamaLengkap.'</b><br>
				            	Anda Mendapat Jadwal Pelayanan Pada :
				            </p>
				            <pre>
				            	Hari 			: '.$key->NamaHari.' <br>
				            	Tanggal 		: '.$key->Tanggal.'<br>
				            	Jam 			: '.$key->JamMulai.' s/d '.$key->JamSelesai.'<br>
				            	Posisi Pelayanan: '.$key->NamaDivisi.'<br>
				            	Lokasi		: '.$key->CabangName.'<br>

				            </pre>
				            <p>
				            Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.
				            <a href="'.base_url().'pelayanan/konfirmasi/'.$key->KonfirmasiID.'">Klik disini</a>
				            Tuhan Yesus memberkati<br><br>
				            '.$key->CreatedBy.'
				            </p>
				        ';

						$oParamEmail = array(
							'BaseEntry' => $lastTRX,
	                		'Chanel' => 'email',
							'Penerima' => $key->Email,
							'Message' => $message,
							'Sended' => 0,
							'CreatedOn' => date('Y-m-d h:i:s')
	                	);

	                	$this->ModelsExecuteMaster->ExecInsert($oParamEmail,'blastmessage');
					}

					if ($key->NoHP != "") {
$message = "
Shalom *".ltrim(rtrim($key->NamaLengkap))."* 
Anda Mendapat Jadwal Pelayanan Pada :

*Hari : ".$key->NamaHari."*
*Tanggal : ".$key->Tanggal."*
*Jam : ".$key->JamMulai.' s/d '.$key->JamSelesai."*
*Posisi Pelayanan : ".$key->NamaDivisi."*
*Lokasi : ".$key->CabangName."*

Silahkan Kunjungi link berikut untuk Konfirmasi Kehadiran.
".base_url()."pelayanan/konfirmasi/".$key->KonfirmasiID."

Tuhan Yesus memberkati

".$key->CreatedBy."
";

						$oParamEmail = array(
							'BaseEntry' => $lastTRX,
	                		'Chanel' => 'whats',
							'Penerima' => $key->NoHP,
							'Message' => $message,
							'Sended' => 0,
							'CreatedOn' => date('Y-m-d h:i:s')
	                	);

	                	$oWhereBlast = array(
	                		'BaseEntry' => $lastTRX,
	                		'Chanel' => 'whats'
	                	);

	                	$find = $this->ModelsExecuteMaster->FindData($oWhereBlast, 'blastmessage');

	                	if ($find->num_rows() == 0) {
	                		$this->ModelsExecuteMaster->ExecInsert($oParamEmail,'blastmessage');
	                	}
					}

                	// $data = $this->ModelsExecuteMaster->SendEmail($oParamEmail);
                	

				}


			}

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
?>