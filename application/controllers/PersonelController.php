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
			$this->load->view('V_Master/Personel');
		}
		public function Read()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$NIK = $this->input->post('NIK');

			try {
				$this->db->select("personel.NIK,CONCAT(personel.GelarDepan,' ',personel.NamaLengkap,' ', personel.GelarBelakang) AS Nama, cabang.CabangNama,divisi.NamaDivisi,jabatan.NamaJabatan, ratepk.NamaRate, ratepk.Rate, personel.TempatLahir, personel.TglLahir,CASE WHEN personel.JenisKelamin = 'L' THEN 'Laki-Laki' ELSE 'Permpuan' END JenisKelamin,personel.Alamat");
				$this->db->from('personel');
				$this->db->join('cabang','personel.CabangID=cabang.id','left');
				$this->db->join('divisi','personel.DivisiID=divisi.id','left');
				$this->db->join('jabatan','personel.JabatanID=jabatan.id','left');
				$this->db->join('ratepk','personel.RatePKCode=ratepk.id','left');
				$this->db->join('dem_provinsi','personel.ProvID = dem_provinsi.prov_id','left');
				$this->db->join('dem_kota','personel.KotaID = dem_kota.city_id','left');
				$this->db->join('dem_kelurahan','personel.KelID = dem_kelurahan.subdis_id','left');
				$this->db->join('dem_kecamatan','personel.KecID = dem_kecamatan.dis_id','left');
				$this->db->where(array("1"=>"1"));

				if ($NIK != "") {
					$this->db->where(array("NIK"=>$NIK));
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				if ($this->session->userdata('CabangID') != "") {
					$this->db->where(array("CabangID"=>$this->session->userdata('CabangID')));
				}

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
			
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
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
					'StatusAnggota' => $StatusAnggota,
					'Foto' => $Foto
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('personel',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('personel', $oObject, array('id'=>$id));
				}
				elseif ($formtype == "delete") {
					# code...
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
						$data['message'] = "Data Divisi Berhasil disimpan";
					}
		        }
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>