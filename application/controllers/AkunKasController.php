<?php 
	class AkunKasController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function index()
		{
			$this->db->select('*');
			$this->db->from('areapelayanan');
			$area = $this->db->get();

			$this->db->select('*');
			$this->db->from('dem_provinsi');
			$prov = $this->db->get();

			$data['prov'] = $prov;

			$rs = $this->ModelsExecuteMaster->GetCabang();
			$data['Cabang'] = $rs->result();
			$data['area'] = $area->result();
			$data['prov'] = $prov->result();
			$this->load->view('Finance/Master/AkunKas',$data);
		}
		public function Read()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$KodeAkun = $this->input->post('KodeAkun');
			$CabangID = $this->input->post('CabangID');
			$JadwalIbadahID = $this->input->post('JadwalIbadahID');
			$Level = $this->input->post('Level');

			$LevelAkses = ($this->session->userdata('UserName') == 'admin') ? "0" : $this->session->userdata('LevelAkses');
			$roleData = $this->ModelsExecuteMaster->GetRoleData();


			$Area = $this->session->userdata('Wilayah');
			$ProvID = $this->session->userdata('Provinsi');
			$KotaID = $this->session->userdata('Kota');

			try {
				$this->db->select('KodeAkun, CONCAT(SPACE(case when `Level` = 1 then 1 else 5 end * `Level`),NamaAkun) AS NamaAkun, CabangID, Saldo');
				$this->db->from('akunkas');
				$this->db->where(array("1"=>"1"));

				if ($KodeAkun != "") {
					$this->db->where(array("KodeAkun"=>$KodeAkun));
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				if ($CabangID != "0") {
					$this->db->where(array("CabangID"=>$CabangID));
				}

				if ($JadwalIbadahID != "") {
					$this->db->where(array("JadwalIbadahID"=>$JadwalIbadahID));
				}

				if ($Level != "") {
					$this->db->where(array("Level"=>$Level));
				}

				// var_dump($roleData->LevelAkses);

				switch ($roleData->LevelAkses) {
					case '5':
						// $this->db->where("cabang.id",$id);
						$this->db->where(array("akunkas.CabangID"=>$this->session->userdata('CabangID')));
						break;
					case '4':
						$this->db->where("akunkas.KotaID", $KotaID);
						break;
					case '3':
						$this->db->where("akunkas.ProvID",$ProvID);
						break;
					case '2':
						$this->db->where("akunkas.Area",$Area);
					case '0' :
						$this->db->where("akunkas.Level >=", $LevelAkses);
						break;
					default:

						break;
				}

				$this->db->order_by('KodeAkun, `Level`, KodeAkunInduk');

				$rs = $this->db->get();
				if ($rs->num_rows() > 0) {
					$data['success'] = true;
					$data['data'] = $rs->result();
				}
			} catch (\Exception $e) {
				$data['message'] = $e->getMessage();
			}
			echo json_encode($data);
		}

		public function ReadRaw()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$KodeAkun = $this->input->post('KodeAkun');
			$CabangID = $this->input->post('CabangID');
			$JadwalIbadahID = $this->input->post('JadwalIbadahID');
			$Area = $this->input->post('Area');
			$ProvID = $this->input->post('ProvID');
			$KotaID = $this->input->post('KotaID');
			$Level = $this->input->post('Level');
			$LevelKurang = $this->input->post('LevelKurang');

			try {
				$this->db->select('akunkas.*');
				$this->db->from('akunkas');
				$this->db->where(array("1"=>"1"));

				if ($KodeAkun != "") {
					$this->db->where(array("KodeAkun"=>$KodeAkun));
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				if ($CabangID != "0" ) {
					$this->db->where(array("CabangID"=>$CabangID));
				}

				if ($JadwalIbadahID != "") {
					$this->db->where(array("JadwalIbadahID"=>$JadwalIbadahID));
				}

				if ($Level != "") {
					$this->db->where(array("Level"=>$Level));
				}

				if ($Area != "") {
					$this->db->where(array("Area"=>$Area));
				}

				if ($ProvID != "") {
					$this->db->where(array("ProvID"=>$ProvID));
				}

				if ($KotaID != "") {
					$this->db->where(array("KotaID"=>$KotaID));
				}

				if ($LevelKurang != "") {
					$this->db->where('Level < ',$LevelKurang);
				}

				$this->db->order_by('KodeAkun, `Level`, KodeAkunInduk');

				$rs = $this->db->get();
				if ($rs->num_rows() > 0) {
					$data['success'] = true;
					$data['data'] = $rs->result();
				}
			} catch (\Exception $e) {
				$data['message'] = $e->getMessage();
			}
			echo json_encode($data);
		}

		public function CRUD()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$KodeAkun = $this->input->post('KodeAkun');
			$NamaAkun = $this->input->post('NamaAkun');
			$Keterangan = $this->input->post('Keterangan');
			$CabangID = $this->input->post('CabangID');
			$PICKas = $this->input->post('PICKas');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');
			


			try {
				$oObject = array(
					'KodeAkun' 	=> $KodeAkun,
					'NamaAkun' 	=> $NamaAkun,
					'Keterangan'=> $Keterangan,
					'CabangID'	=> $CabangID,
					'PIC' 		=> $PICKas
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('akunkas',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('akunkas', $oObject, array('KodeAkun'=>$KodeAkun));
				}
				elseif ($formtype == "delete") {
					$this->db->where('KodeAkun',$KodeAkun);
					$this->db->where('CabangID',$CabangID);
					$this->db->delete('akunkas');
				}
				else{
					$data['message'] = "invalid Form Type";
				}

				$error = $this->db->error();

				if($error['code']) {
		            // echo "Database error occurred: ".$error['message'];
		            $data['message'] = $error['message'];
		        } else {
		            if ($this->db->affected_rows() > 0) {
						$data['success'] =true;
						$data['message'] = "Data Akun Kas Berhasil disimpan";
					}
		        }
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>