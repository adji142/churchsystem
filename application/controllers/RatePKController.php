<?php 
	class RatePKController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function index()
		{
			// Hari
			$this->db->select('*');
			$this->db->from('defaulthari');
			$this->db->order_by('Index', 'ASC');
			$getHari = $this->db->get();

			// Bidang Pelayanan
			$this->db->select('*');
			$this->db->from('posisipelayanan');
			$bidangpelayanan = $this->db->get();

			// var_dump($bidangpelayanan->result());

			// Cabang
			$rs = $this->ModelsExecuteMaster->GetCabang();
			$data['Cabang'] = $rs->result();

			$data['Hari'] = $getHari->result();
			$data['BidangPelayanan'] = $bidangpelayanan->result();
			$this->load->view('V_Master/RatePK', $data);
		}
		public function Read()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$id = $this->input->post('id');
			$CabangID = $this->input->post('CabangID');

			try {
				$this->db->select('ratepk.*, cabang.CabangName, jadwalibadah.NamaIbadah, posisipelayanan.PosisiPelayanan, defaulthari.NamaHari');
				$this->db->from('ratepk');
				$this->db->join('cabang', 'ratepk.CabangID = cabang.id','left');
				$this->db->join('jadwalibadah', 'ratepk.IbadahID = jadwalibadah.id','left');
				$this->db->join('posisipelayanan', 'ratepk.BidangPelayananID = posisipelayanan.id','left');
				$this->db->join('defaulthari', 'ratepk.Hari = defaulthari.KodeHari','left');
				$this->db->where(array("1"=>"1"));

				if ($id != "") {
					$this->db->where(array("ratepk.id"=>$id));
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				if ($CabangID != "0") {
					$this->db->where(array("ratepk.CabangID"=>$CabangID));
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
			$NamaRate = $this->input->post('NamaRate');
			$TglBerlaku = $this->input->post('TglBerlaku');
			$IbadahID = $this->input->post('IbadahID');
			$Hari = $this->input->post('Hari');
			$Sesi = $this->input->post('Sesi');
			$BidangPelayananID = $this->input->post('BidangPelayananID');
			$Rate = $this->input->post('Rate');
			$CabangID = $this->input->post('CabangID');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
				$oObject = array(
					'NamaRate' 	=> $NamaRate,
					'CabangID' 	=> $CabangID,
					'Rate'		=> $Rate,
					'TglBerlaku' => $TglBerlaku,
					'IbadahID' => $IbadahID,
					'Hari' => $Hari,
					'Sesi' => $Sesi,
					'BidangPelayananID' => $BidangPelayananID,
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('ratepk',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('ratepk', $oObject, array('id'=>$id));
				}
				elseif ($formtype == "delete") {
					$this->db->where('id',$id);
					$this->db->where('CabangID', $CabangID);
					$this->db->delete('ratepk');
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
						$data['message'] = "Data Rate PK Berhasil disimpan";
					}
		        }
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>