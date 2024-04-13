<?php 
	class CabangController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function index()
		{
			$this->load->view('V_Master/Cabang');
		}
		public function Read()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$id = $this->input->post('id');
			$Area = $this->input->post('Area');
			$ProvID = $this->input->post('ProvID');
			$KotaID = $this->input->post('KotaID');
			$Wilayah = $this->input->post('Wilayah');

			$LevelAkses = ($this->session->userdata('UserName') == 'admin') ? "0" : $this->session->userdata('LevelAkses');
			$roleData = $this->ModelsExecuteMaster->GetRoleData();
			try {
				$this->db->select('cabang.*,dem_provinsi.prov_name,dem_kota.city_name, dem_kelurahan.subdis_name, dem_kecamatan.dis_name, areapelayanan.NamaArea');
				$this->db->from('cabang');
				$this->db->join('dem_provinsi','cabang.ProvID = dem_provinsi.prov_id','left');
				$this->db->join('dem_kota','cabang.KotaID = dem_kota.city_id','left');
				$this->db->join('dem_kelurahan','cabang.KelID = dem_kelurahan.subdis_id','left');
				$this->db->join('dem_kecamatan','cabang.KecID = dem_kecamatan.dis_id','left');
				$this->db->join('areapelayanan','cabang.Area = areapelayanan.id','left');
				$this->db->where(array("1"=>"1"));

				if ($id != "") {
					$this->db->where(array("cabang.id"=>$id));
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				// if ($this->session->userdata('CabangID') != "0") {
				// 	$this->db->where(array("cabang.id"=>$this->session->userdata('CabangID')));
				// }

				if ($ProvID != "") {
					// $this->db->where('ProvID',$ProvID);
					// $this->db->or_where('ProvID', '-1');
					$this->db->where("(ProvID = '".$ProvID."' or 'ProvID' = '-1' )",NULL, FALSE);
				}

				if ($Area != "") {
					$this->db->where('cabang.Area',$Area);
				}

				if ($KotaID != "") {
					// $this->db->where('cabang.KotaID',$KotaID);
				}

				// var_dump($roleData->LevelAkses);
				switch ($roleData->LevelAkses) {
					case '5':
						// $this->db->where("cabang.id",$id);
						$this->db->where(array("cabang.id"=>$this->session->userdata('CabangID')));
						break;
					case '4':
						$this->db->where("cabang.KotaID", $KotaID);
						break;
					case '3':
						$this->db->where("cabang.ProvID",$ProvID);
						break;
					case '2':
						$this->db->where("cabang.Area",$Area);
					case '0' :
						$this->db->where("jabatan.Level >=", $LevelAkses);
						break;
					default:

						break;
				}

				$rs = $this->db->get();
				if ($rs->num_rows() > 0) {
					$data['success'] = true;
					$data['data'] = $rs->result();
				}
			} catch (\Exception $e) {
				$data['message'] = $e->getMessage();
			}
			// echo json_encode($data);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
		public function CRUD()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$id = $this->input->post('id');
			$CabangName = $this->input->post('CabangName');
			$Alamat = $this->input->post('Alamat');
			$ProvID = $this->input->post('ProvID');
			$KotaID = $this->input->post('KotaID');
			$KelID = $this->input->post('KelID');
			$KecID = $this->input->post('KecID');
			$Area = $this->input->post('Area');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
				$oObject = array(
					'CabangName' => $CabangName,
					'Alamat' => $Alamat,
					'ProvID' => $ProvID,
					'KotaID' => $KotaID,
					'KelID' => $KelID,
					'KecID' => $KecID,
					'Area' => $Area
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('cabang',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('cabang', $oObject, array('id'=>$id));
				}
				elseif ($formtype == "delete") {
					$this->db->where('id',$id);
					$this->db->delete('cabang');
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
						$data['message'] = "Data Cabang Berhasil disimpan";
					}
		        }
			} catch (Exception $e) {
				$data['message'] = $e->message;
			}

			// echo json_encode($data);
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
?>