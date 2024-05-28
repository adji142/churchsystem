<?php 
	class BiayaController extends CI_Controller {
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
			$this->load->view('Finance/Master/Biaya',$data);
		}
		public function Read()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$KodeBiaya = $this->input->post('KodeBiaya');
			$CabangID = $this->input->post('CabangID');

			try {
				$this->db->select('*');
				$this->db->from('biaya');
				$this->db->where(array("1"=>"1"));

				if ($KodeBiaya != "") {
					$this->db->where(array("KodeBiaya"=>$KodeBiaya));
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
			} catch (\Exception $e) {
				$data['message'] = $e->getMessage();
			}
			echo json_encode($data);
		}
		public function CRUD()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$KodeBiaya = $this->input->post('KodeBiaya');
			$NamaBiaya = $this->input->post('NamaBiaya');
			$Limit = $this->input->post('Limit');
			$CabangID = $this->input->post('CabangID');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
				$oObject = array(
					'KodeBiaya' => $KodeBiaya,
					'NamaBiaya' => $NamaBiaya,
					'Limit' => $Limit,
					'CabangID'	=> $CabangID
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('biaya',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('biaya', $oObject, array('KodeBiaya'=>$KodeBiaya));
				}
				elseif ($formtype == "delete") {
					$this->db->where('KodeBiaya',$KodeBiaya);
					$this->db->where('CabangID',$CabangID);
					$this->db->delete('biaya');
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
						$data['message'] = "Data Bank Berhasil disimpan";
					}
		        }
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>