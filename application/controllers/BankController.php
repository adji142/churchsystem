<?php 
	class BankController extends CI_Controller {
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

			$KodeBank = $this->input->post('KodeBank');
			$CabangID = $this->input->post('CabangID');

			try {
				$this->db->select('*');
				$this->db->from('bank');
				$this->db->where(array("1"=>"1"));

				if ($KodeBank != "") {
					$this->db->where(array("KodeBank"=>$KodeBank));
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

			$KodeBank = $this->input->post('KodeBank');
			$NamaBank = $this->input->post('NamaBank');
			$NoRekening = $this->input->post('NoRekening');
			$NamaPemilikRekening = $this->input->post('NamaPemilikRekening');
			$AlamatCabangBank = $this->input->post('AlamatCabangBank');
			$CabangID = $this->input->post('CabangID');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
				$oObject = array(
					'KodeBank' => $KodeBank,
					'NamaBank' => $NamaBank,
					'NoRekening' => $NoRekening,
					'NamaPemilikRekening' => $NamaPemilikRekening,
					'AlamatCabangBank' => $AlamatCabangBank,
					'CabangID'	=> $CabangID
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('bank',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('bank', $oObject, array('KodeBank'=>$KodeBank));
				}
				elseif ($formtype == "delete") {
					$this->db->where('KodeBank',$KodeBank);
					$this->db->where('CabangID',$CabangID);
					$this->db->delete('bank');
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