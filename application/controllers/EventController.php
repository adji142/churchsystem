<?php 
	class EventController extends CI_Controller {
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
			// $data['Hari'] = $getHari->result();
			$this->load->view('V_Event/Event',$data);
		}
		public function Read()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$CabangID = $this->input->post('CabangIDFilter');
			$JenisEventID = $this->input->post('JenisEventIDFilter');

			try {
				$this->db->select("dataevent.*, jenisevent.NamaJenisEvent,DATE_FORMAT(DATE(dataevent.TglEvent),'%d-%m-%Y') TglEventFormated, DATE_FORMAT(dataevent.TglEvent,'%T') JamEventFormted, date(dataevent.TglEvent) TglEventFIx ");
				$this->db->from('dataevent');
				$this->db->join('jenisevent','dataevent.JenisEventID=jenisevent.id','left');
				$this->db->where('dataevent.TglEvent >=', $TglAwal);
				$this->db->where('dataevent.TglEvent <=', $TglAkhir);
				$this->db->order_by('dataevent.TglEvent', 'DESC');

				if ($CabangID != "0") {
					$this->db->where(array("dataevent.CabangID"=>$CabangID));
				}

				if ($JenisEventID != "") {
					$this->db->where(array("dataevent.JenisEventID"=>$JenisEventID));
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

		public function Find()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$NoTransaksi = $this->input->post('NoTransaksi');
			$CabangID = $this->input->post('CabangID');

			try {
				$this->db->select("dataevent.*, jenisevent.NamaJenisEvent,DATE_FORMAT(DATE(dataevent.TglEvent),'%d-%m-%Y') TglEventFormated, DATE_FORMAT(dataevent.TglEvent,'%T') JamEventFormted, date(dataevent.TglEvent) TglEventFIx ");
				$this->db->from('dataevent');
				$this->db->join('jenisevent','dataevent.JenisEventID=jenisevent.id','left');
				$this->db->order_by('dataevent.TglEvent', 'DESC');

				if ($NoTransaksi != "") {
					$this->db->where(array("NoTransaksi"=>$NoTransaksi));
				}

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				if ($CabangID != "0") {
					$this->db->where(array("dataevent.CabangID"=>$CabangID));
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

			// GetNoTransaksi

			$NoTransaksi = $this->input->post('NoTransaksi');
			$TglEvent = $this->input->post('TglEvent');
			$JamEvent = $this->input->post('JamEvent');
			$NamaEvent = $this->input->post('NamaEvent');
			$JenisEventID = $this->input->post('JenisEventID');
			$LokasiEvent = $this->input->post('LokasiEvent');
			$AlamatEvent = $this->input->post('AlamatEvent');
			$ContactPerson = $this->input->post('ContactPerson');
			$NoHPContactPerson = $this->input->post('NoHPContactPerson');
			$Berulang = $this->input->post('Berulang');
			$IntervalBerulang = $this->input->post('IntervalBerulang');
			$IntervalType = $this->input->post('IntervalType');
			$CabangID = $this->input->post('CabangID');
			$Keterangan = $this->input->post('Keterangan');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');

			if ($NoTransaksi == "") {
				 $NoTransaksi = "";
				 $prefix = 'EVT'.$CabangID.substr(date('Ymd'),2,8);
				 $lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$CabangID), 'dataevent')->num_rows() +1;
				 $NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);
			}

			try {
				$oObject = array(
					'NoTransaksi' => $NoTransaksi,
					'TglEvent' => $TglEvent." ".$JamEvent,
					'NamaEvent' => $NamaEvent,
					'JenisEventID' => $JenisEventID,
					'LokasiEvent' => $LokasiEvent,
					'AlamatEvent' => $AlamatEvent,
					'ContactPerson' => $ContactPerson,
					'NoHPContactPerson' => $NoHPContactPerson,
					'Berulang' => $Berulang,
					'IntervalBerulang' => $IntervalBerulang,
					'IntervalType' => $IntervalType,
					'CabangID' => $CabangID,
					'Keterangan' => $Keterangan
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('dataevent',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('dataevent', $oObject, array('NoTransaksi'=>$NoTransaksi));
				}
				elseif ($formtype == "delete") {
					$this->db->where('NoTransaksi',$NoTransaksi);
					$this->db->where('CabangID',$CabangID);
					$this->db->delete('dataevent');
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