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

			try {
				$this->db->select('cabang.*,dem_provinsi.prov_name,dem_kota.city_name, dem_kelurahan.subdis_name, dem_kecamatan.dis_name');
				$this->db->from('cabang');
				$this->db->join('dem_provinsi','cabang.ProvID = dem_provinsi.prov_id','left');
				$this->db->join('dem_kota','cabang.KotaID = dem_kota.city_id','left');
				$this->db->join('dem_kelurahan','cabang.KelID = dem_kelurahan.subdis_id','left');
				$this->db->join('dem_kecamatan','cabang.KecID = dem_kecamatan.dis_id','left');
				$this->db->where(array("1"=>"1"));

				if ($id != "") {
					$this->db->where(array("id"=>$id));
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				if ($this->session->userdata('CabangID') != "") {
					$this->db->where(array("id"=>$this->session->userdata('CabangID')));
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
					'KecID' => $KecID
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