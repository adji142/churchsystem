<?php 
	class JenisIbadahController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function index()
		{
			$rs = $this->ModelsExecuteMaster->GetCabang();
			$data['Cabang'] = $rs->result();
			$this->load->view('V_Master/JenisIbadah',$data);
		}
		public function Read()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$id = $this->input->post('id');
			$CabangID = $this->input->post('CabangID');

			try {
				$this->db->select('*');
				$this->db->from('jenisibadah');
				$this->db->where(array("1"=>"1"));

				if ($id != "") {
					$this->db->where(array("id"=>$id));
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				if ($CabangID != "0") {
					$this->db->where(array("CabangID"=>$CabangID));
				}

				$rs = $this->db->get();
				if ($rs->num_rows() > 0) {
					$data['success'] = true;
					$data['data'] = $rs->result();
				}
			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
		public function CRUD()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$id = $this->input->post('id');
			$NamaJenisIbadah = $this->input->post('NamaJenisIbadah');
			$CabangID = $this->input->post('CabangID');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
				$oObject = array(
					'NamaJenisIbadah' 	=> $NamaJenisIbadah,
					'CabangID' 	=> $CabangID
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('jenisibadah',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('jenisibadah', $oObject, array('id'=>$id));
				}
				elseif ($formtype == "delete") {
					$this->db->where('id',$id);
					$this->db->where('CabangID',$CabangID);
					$this->db->delete('jenisibadah');
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
						$data['message'] = "Data Jenis Ibadah Berhasil disimpan";
					}
		        }
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
?>