<?php 
	class PosisiPelayananController extends CI_Controller {
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
			$this->load->view('Finance/Master/Bank',$data);
		}
		public function Read()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$id = $this->input->post('id');
			$CabangID = $this->input->post('CabangID');

			try {
				$this->db->select('*');
				$this->db->from('posisipelayanan');
				$this->db->where(array("1"=>"1"));

				if ($id != "") {
					$this->db->where(array("id"=>$id));
				}
				$this->db->order_by('Index');

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

			$id = $this->input->post('id');
			$PosisiPelayanan = $this->input->post('PosisiPelayanan');
			$CabangID = $this->input->post('CabangID');
			$formtype = $this->input->post('formtype');


			try {
				$oObject = array(
					'PosisiPelayanan' => $PosisiPelayanan,
					'CabangID'	=> $CabangID
				);

				if ($formtype == "add") {
					$this->db->insert('posisipelayanan',$oObject);
				}
				elseif ($formtype == "edit") {
					$this->db->update('posisipelayanan', $oObject, array('id'=>$id));
				}
				elseif ($formtype == "delete") {
					$this->db->where('id',$id);
					$this->db->where('CabangID',$CabangID);
					$this->db->delete('posisipelayanan');
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
						$data['message'] = "Data Posisi Pelayanan Berhasil disimpan";
					}
		        }
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>