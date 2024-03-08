<?php 
	class JadwalIbadahController extends CI_Controller {
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
			$this->db->from('defaulthari');
			$this->db->order_by('Index', 'ASC');
			$getHari = $this->db->get();

			$rs = $this->ModelsExecuteMaster->GetCabang();
			$data['Cabang'] = $rs->result();
			$data['Hari'] = $getHari->result();
			$this->load->view('V_Master/JadwalIbadah',$data);
		}
		public function Read()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$id = $this->input->post('id');
			$CabangID = $this->input->post('CabangID');

			try {
				$this->db->select("jadwalibadah.*,defaulthari.NamaHari, DATE_FORMAT(jadwalibadah.SelesaiJam,'%T') SelesaiJamFormated, DATE_FORMAT(jadwalibadah.MulaiJam,'%T') MulaiJamFormated");
				$this->db->from('jadwalibadah');
				$this->db->join('defaulthari','defaulthari.KodeHari=jadwalibadah.Hari','left');
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
			$NamaIbadah = $this->input->post('NamaIbadah');
			$Hari = $this->input->post('Hari');
			$MulaiJam = $this->input->post('MulaiJam');
			$SelesaiJam = $this->input->post('SelesaiJam');
			$Keterangan = $this->input->post('Keterangan');
			$CabangID = $this->input->post('CabangID');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
				$oObject = array(
					'NamaIbadah' => $NamaIbadah,
					'Hari' => $Hari,
					'MulaiJam' => $MulaiJam,
					'SelesaiJam' => $SelesaiJam,
					'CabangID' => $CabangID,
					'Keterangan' => $Keterangan,
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('jadwalibadah',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('jadwalibadah', $oObject, array('id'=>$id));
				}
				elseif ($formtype == "delete") {
					$this->db->where('id',$id);
					$this->db->where('CabangID',$CabangID);
					$this->db->delete('jadwalibadah');
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