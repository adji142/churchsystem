<?php 
	class PersonelController extends CI_Controller {
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
			$this->db->from('dem_provinsi');
			$provinsi = $this->db->get();

			$PosisiPelayanan= $this->ModelsExecuteMaster->GetData('posisipelayanan');

			$data['prov'] = $provinsi->result();
			$data['PosisiPelayanan'] = $PosisiPelayanan->result();
			$this->load->view('V_Master/Personel',$data);
		}

		public function editprofile()
		{
			$this->db->select('*');
			$this->db->from('dem_provinsi');
			$provinsi = $this->db->get();

			$PosisiPelayanan= $this->ModelsExecuteMaster->GetData('posisipelayanan');

			$data['prov'] = $provinsi->result();
			$data['PosisiPelayanan'] = $PosisiPelayanan->result();
			$this->load->view('profile',$data);
		}
		public function Read()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$NIK = $this->input->post('NIK');
			$CabangID = $this->input->post('CabangID');
			$DivisiID = $this->input->post('DivisiID');
			$JabatanID = $this->input->post('JabatanID');
			$Wilayah = $this->input->post('Wilayah');
			$Provinsi = $this->input->post('Provinsi');
			$Kota = $this->input->post('Kota');
			$LevelAkses = ($this->session->userdata('UserName') == 'admin') ? "0" : $this->session->userdata('LevelAkses');
			$NIKIn = $this->input->post('NIKIn');

			$roleData = $this->ModelsExecuteMaster->GetRoleData();

			// var_dump($this->session->userdata('LevelAkses'));

			try {
				$this->db->select("personel.NIK,CONCAT(personel.GelarDepan,' ',personel.NamaLengkap,' ', personel.GelarBelakang) AS Nama, cabang.CabangName,divisi.NamaDivisi,jabatan.NamaJabatan, ratepk.NamaRate, ratepk.Rate, personel.TempatLahir, personel.TglLahir,CASE WHEN personel.JenisKelamin = 'L' THEN 'Laki-Laki' ELSE 'Permpuan' END JenisKelamin,personel.Alamat, personel.CabangID, personel.Email, personel.NoHP, personel.CabangID, personel.DivisiID, personel.JabatanID, CASE WHEN CONCAT(personel.DivisiID,personel.JabatanID) = '".$DivisiID.$JabatanID."' THEN 'A' ELSE 'B' END AS selectedPersonel, posisipelayanan.PosisiPelayanan " );
				$this->db->from('personel');
				$this->db->join('cabang','personel.CabangID=cabang.id','left');
				$this->db->join('divisi','personel.DivisiID=divisi.id','left');
				$this->db->join('jabatan','personel.JabatanID=jabatan.id','left');
				$this->db->join('ratepk','personel.RatePKCode=ratepk.id','left');
				$this->db->join('dem_provinsi','personel.ProvID = dem_provinsi.prov_id','left');
				$this->db->join('dem_kota','personel.KotaID = dem_kota.city_id','left');
				$this->db->join('dem_kelurahan','personel.KelID = dem_kelurahan.subdis_id','left');
				$this->db->join('dem_kecamatan','personel.KecID = dem_kecamatan.dis_id','left');
				$this->db->join('posisipelayanan', 'posisipelayanan.id = personel.PosisiPelayanan','left');
				$this->db->where("personel.StatusAnggota", 1);

				if ($NIK != "") {
					$this->db->where("NIK",$NIK);
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

			
				if ($CabangID != "0") {
					$this->db->where("personel.CabangID",$CabangID);
				}

				if ($Provinsi != '-1' ) {
					$this->db->where("personel.ProvID",$Provinsi);
				}

				if ($Wilayah != "0" ) {
					$this->db->where("cabang.Area",$Wilayah);
				}

				if ($Kota != "") {
					$this->db->where("personel.KotaID", $Kota);
				}

				if ($DivisiID != "" ) {
					// $oDivisi = explode(",", $DivisiID)
					$this->db->where("personel.DivisiID", $DivisiID);
				}

				if ($LevelAkses != "0") {
					$this->db->where("jabatan.Level >=", $LevelAkses);
				}

				switch ($roleData->LevelAkses) {
					case '5':
						$this->db->where("personel.CabangID",$CabangID);
						// var_dump("5");
						break;
					case '4':
						$this->db->where("personel.KotaID", $Kota);
						// var_dump("4");
						break;
					case '3':
						$this->db->where("personel.ProvID",$Provinsi);
						// var_dump("3");
						break;
					case '2':
						$this->db->where("cabang.Area",$Wilayah);
						// var_dump("2");
					case '0' :
						$this->db->where("jabatan.Level >=", $LevelAkses);
						// var_dump("0");
						break;
				}


				if ($NIKIn != "") {
					$oWhere = explode(",", $NIKIn);
					if (count($oWhere) > 0) {
						$this->db->where_not_in('personel.NIK', $oWhere);
					}
				}

				$this->db->order_by("CASE WHEN CONCAT(personel.DivisiID,personel.JabatanID) = '".$DivisiID.$JabatanID."' THEN 'A' ELSE 'B' END ");

				$rs = $this->db->get();

				$error = $this->db->error();
				// var_dump($error);
				if($error['code'] > 0) {
		            $data['message'] =$error['code'] .' - ' .$error['message'];
		        } else {
		            if ($rs->num_rows() > 0) {
						$data['success'] = true;
						$data['data'] = $rs->result();
					}
		        }

			} catch (\Exception $e) {
				$data['message'] = $e->getMessage();
			}
			echo json_encode($data);
		}

		public function ReadRaw()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$NIK = $this->input->post('NIK');
			$CabangID = $this->input->post('CabangID');
			$DivisiID = $this->input->post('DivisiID');
			$JabatanID = $this->input->post('JabatanID');
			$Wilayah = $this->input->post('Wilayah');
			$Provinsi = $this->input->post('Provinsi');
			$Kota = $this->input->post('Kota');

			try {
				$this->db->select("personel.NIK,CONCAT(personel.GelarDepan,' ',personel.NamaLengkap,' ', personel.GelarBelakang) AS Nama, cabang.CabangName,divisi.NamaDivisi,jabatan.NamaJabatan, ratepk.NamaRate, ratepk.Rate, personel.TempatLahir, personel.TglLahir,CASE WHEN personel.JenisKelamin = 'L' THEN 'Laki-Laki' ELSE 'Permpuan' END JenisKelamin,personel.Alamat, personel.CabangID, personel.Email, personel.NoHP, personel.CabangID, personel.DivisiID, personel.JabatanID, CASE WHEN CONCAT(personel.DivisiID,personel.JabatanID) = '".$DivisiID.$JabatanID."' THEN 'A' ELSE 'B' END AS selectedPersonel " );
				$this->db->from('personel');
				$this->db->join('cabang','personel.CabangID=cabang.id','left');
				$this->db->join('divisi','personel.DivisiID=divisi.id','left');
				$this->db->join('jabatan','personel.JabatanID=jabatan.id','left');
				$this->db->join('ratepk','personel.RatePKCode=ratepk.id','left');
				$this->db->join('dem_provinsi','personel.ProvID = dem_provinsi.prov_id','left');
				$this->db->join('dem_kota','personel.KotaID = dem_kota.city_id','left');
				$this->db->join('dem_kelurahan','personel.KelID = dem_kelurahan.subdis_id','left');
				$this->db->join('dem_kecamatan','personel.KecID = dem_kecamatan.dis_id','left');
				$this->db->where("personel.StatusAnggota", 1);

				if ($NIK != "") {
					$this->db->where("NIK",$NIK);
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				
				// var_dump($oRoles->row()->LevelAkses);
				if ($CabangID != "0") {
					$this->db->where("personel.CabangID",$CabangID);
				}

				if ($Provinsi != -1) {
					$this->db->where("personel.ProvID",$Provinsi);
				}

				if ($Wilayah != "0") {
					$this->db->where("cabang.Area",$Wilayah);
				}

				if ($Kota != "") {
					$this->db->where("personel.KotaID", $Kota);
				}

				if ($DivisiID != "") {
					$this->db->where("personel.DivisiID", $DivisiID);
				}

				$this->db->order_by("CASE WHEN CONCAT(personel.DivisiID,personel.JabatanID) = '".$DivisiID.$JabatanID."' THEN 'A' ELSE 'B' END ");

				$rs = $this->db->get();

				$error = $this->db->error();
				// var_dump($error);
				if($error['code'] > 0) {
		            $data['message'] =$error['code'] .' - ' .$error['message'];
		        } else {
		            if ($rs->num_rows() > 0) {
						$data['success'] = true;
						$data['data'] = $rs->result();
					}
		        }

			} catch (\Exception $e) {
				$data['message'] = $e->getMessage();
			}
			echo json_encode($data);
		}

		public function Find()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$NIK = $this->input->post('NIK');
			$CabangID = $this->input->post('CabangID');

			try {
				$this->db->select("*");
				$this->db->from('personel');
				$this->db->where(array("NIK"=>$NIK));
				// $this->db->where(array("CabangID"=>$CabangID));

				$rs = $this->db->get();

				$error = $this->db->error();
				// var_dump($error);
				if($error['code'] > 0) {
		            $data['message'] =$error['code'] .' - ' .$error['message'];
		        } else {
		            if ($rs->num_rows() > 0) {
						$data['success'] = true;
						$data['data'] = $rs->result();
					}
		        }

			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
			}
			echo json_encode($data);
		}

		public function CRUD()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$errorCount = 0;
			
			$NIK = $this->input->post('NIK');
			$NamaLengkap = $this->input->post('NamaLengkap');
			$GelarDepan = $this->input->post('GelarDepan');
			$GelarBelakang = $this->input->post('GelarBelakang');
			$CabangID = $this->input->post('CabangID');
			$DivisiID = $this->input->post('DivisiID');
			$JabatanID = $this->input->post('JabatanID');
			$TempatLahir = $this->input->post('TempatLahir');
			$TglLahir = $this->input->post('TglLahir');
			$Agama = $this->input->post('Agama');
			$JenisKelamin = $this->input->post('JenisKelamin');
			$RatePKCode = $this->input->post('RatePKCode');
			$NomorKependudukan = $this->input->post('NomorKependudukan');
			$ProvID = $this->input->post('ProvID');
			$KotaID = $this->input->post('KotaID');
			$KecID = $this->input->post('KecID');
			$KelID = $this->input->post('KelID');
			$Alamat = $this->input->post('Alamat');
			$StatusAnggota = $this->input->post('StatusAnggota');
			$Foto = $this->input->post('Foto');
			$image_base64 = $this->input->post('image_base64');
			$Email = $this->input->post('Email');
			$NoHP = $this->input->post('NoHP');
			$PosisiPelayanan = $this->input->post('PosisiPelayanan');

			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
				$this->db->trans_start();
				// 20240329
				if ($formtype == "add") {
					$prefix = substr(date('Ymd'),2,4).$CabangID;
					$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$CabangID), 'personel')->num_rows() +1;
					$NIK = $prefix.str_pad($lastNoTrx, 4, '0', STR_PAD_LEFT);
				}
				$oObject = array(
					'NIK' => $NIK,
					'NamaLengkap' => $NamaLengkap,
					'GelarDepan' => $GelarDepan,
					'GelarBelakang' => $GelarBelakang,
					'CabangID' => $CabangID,
					'DivisiID' => $DivisiID,
					'JabatanID' => $JabatanID,
					'TempatLahir' => $TempatLahir,
					'TglLahir' => $TglLahir,
					'Agama' => $Agama,
					'JenisKelamin' => $JenisKelamin,
					'RatePKCode' => $RatePKCode,
					'NomorKependudukan' => $NomorKependudukan,
					'ProvID' => $ProvID,
					'KotaID' => $KotaID,
					'KecID' => $KecID,
					'KelID' => $KelID,
					'Alamat' => $Alamat,
					'StatusAnggota' => 1,
					'Foto' => $image_base64,
					'NoHP' => $NoHP,
					'Email' => $Email,
					'PosisiPelayanan' => $PosisiPelayanan
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$save = $this->db->insert('personel',$oObject);

					if (!$save) {
						$data['message'] = "Gagal Create Personel";
						$errorCount += 0;
						goto jump;
					}

					$oUser = array(
						'username' 	=> $NoHP,
						'nama'		=> $NamaLengkap,
						'email'		=> $Email,
						'password'	=> $this->encryption->encrypt($NIK),
						'CabangID'	=> $CabangID,
						'canAdd'	=> 0,
						'canEdit'	=> 0,
						'canDelete'	=> 0,
						'NIKPersonel' => $NIK,
						'AllowFinanceDashboard' => 0,
						'ChangePassword' => 'Y'
					);

					$saveUser = $this->db->insert('users',$oUser);

					if (!$saveUser) {
						$data['message'] = "Gagal Create User";
						$errorCount += 0;
						goto jump;
					}
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$oWhere = array(
						'NIK'=>$NIK
					);
					$this->db->update('personel', $oObject, $oWhere);
				}
				elseif ($formtype == "delete") {
					$oObject = array(
						'UpdatedOn' => $UpdatedOn,
						'UpdatedBy' => $UpdatedBy,
						'StatusAnggota' => '0'
					);

					$oWhere = array(
						'NIK'=>$NIK,
						'CabangID'=>$CabangID
					);
					$this->db->update('personel', $oObject, $oWhere);
				}
				else{
					$data['message'] = "invalid Form Type";
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
					$data['success'] = true;
				}
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>