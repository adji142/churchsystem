<?php 
	class JabatanController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function index($value)
		{
			$data['DivisiID'] = $value;
			$this->load->view('V_Master/Jabatan', $data);
		}
		public function Read()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$id = $this->input->post('id');
			$DivisiID = $this->input->post('DivisiID');
			try {
				$this->db->select('*');
				$this->db->from('jabatan');
				$this->db->where(array("1"=>"1"));

				if ($id != "") {
					$this->db->where(array("id"=>$id));
				}
				if ($DivisiID != "") {
					$this->db->where(array("DivisiID"=>$DivisiID));
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

			$id = $this->input->post('id');
			$NamaJabatan = $this->input->post('NamaJabatan');
			$DivisiID  =$this->input->post('DivisiID');
			$Level = $this->input->post('Level');
			$CabangID = $this->input->post('CabangID');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
				$oObject = array(
					'NamaJabatan' => $NamaJabatan,
					'Level' => $Level,
					'CabangID' => $CabangID,
					'DivisiID' => $DivisiID
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('jabatan',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('jabatan', $oObject, array('id'=>$id));
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
						$data['message'] = "Data Jabatan Berhasil disimpan";
					}
		        }
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>