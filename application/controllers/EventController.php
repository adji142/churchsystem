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
		public function form($NoTransaksi, $CabangID)
		{
			$this->db->select("dataevent.*, jenisevent.NamaJenisEvent,DATE_FORMAT(DATE(dataevent.TglEvent),'%d-%m-%Y') TglEventFormated, DATE_FORMAT(dataevent.TglEvent,'%T') JamEventFormted, date(dataevent.TglEvent) TglEventFIx,DATE_FORMAT(dataevent.JamMulai,'%T') AS JamMulaiFormated,DATE_FORMAT(dataevent.JamSelesai,'%T') AS JamSelesaiFormated ");
			$this->db->from('dataevent');
			$this->db->join('jenisevent','dataevent.JenisEventID=jenisevent.id','left');
			$this->db->where('dataevent.NoTransaksi', $NoTransaksi);
			$this->db->where('dataevent.CabangID', $CabangID);
			$event = $this->db->get();

			$this->db->select("divisi.id AS DivisiID,jabatan.id AS JabatanID, divisi.NamaDivisi, jabatan.NamaJabatan, CASE WHEN templatepelayan.id IS NULL THEN 'N' ELSE 'Y' END checked, COALESCE(templatepelayan.JumlahPelayan,0) JumlahPelayan");
			$this->db->from('divisi');
			$this->db->join('jabatan', 'divisi.id = jabatan.DivisiID AND divisi.CabangID = jabatan.CabangID','left');
			$this->db->join('templatepelayan', 'divisi.id = templatepelayan.DivisiID AND jabatan.id = templatepelayan.JabatanID AND divisi.CabangID = templatepelayan.CabangID','left');
			$this->db->where(array("templatepelayan.BaseReff"=>$NoTransaksi));
			$this->db->where(array("templatepelayan.BaseType"=>'EVENT'));
			$this->db->where(array("templatepelayan.CabangID"=>$CabangID));
			$this->db->order_by('divisi.id', 'ASC');
			$this->db->order_by('jabatan.id', 'ASC');

			$template = $this->db->get();

			$cabang = $this->ModelsExecuteMaster->GetCabang();
			$data['event'] = $event->result();
			$data['template'] = $template->result();
			$data['Cabang'] = $cabang->result();

			$this->load->view('V_Event/Event-input',$data);
		}
		public function Read()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$CabangID = $this->input->post('CabangIDFilter');
			$JenisEventID = $this->input->post('JenisEventIDFilter');

			try {
				$this->db->select("dataevent.*, jenisevent.NamaJenisEvent,DATE_FORMAT(DATE(dataevent.TglEvent),'%d-%m-%Y') TglEventFormated, DATE_FORMAT(dataevent.TglEvent,'%T') JamEventFormted, date(dataevent.TglEvent) TglEventFIx, DATE_FORMAT(dataevent.JamMulai,'%T') AS JamMulaiFormated,DATE_FORMAT(dataevent.JamSelesai,'%T') AS JamSelesaiFormated ");
				$this->db->from('dataevent');
				$this->db->join('jenisevent','dataevent.JenisEventID=jenisevent.id','left');
				$this->db->where('date(dataevent.TglEvent) >=', $TglAwal);
				$this->db->where('date(dataevent.TglEvent) <=', $TglAkhir);

				if ($CabangID != "0") {
					$this->db->where("dataevent.CabangID",$CabangID);
				}

				if ($JenisEventID != "0") {
					$this->db->where(array("dataevent.JenisEventID"=>$JenisEventID));
				}
				$this->db->order_by('dataevent.TglEvent', 'DESC');

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

		public function CRUDJson()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$json_data = json_decode(file_get_contents('php://input'), true);

			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');

			try {
				$this->db->trans_start();
				$errorCount = 0;
				$formtype = $json_data['formtype'];

				$NoTransaksi = "";
				if ($json_data['NoTransaksi'] == "") {
					 $NoTransaksi = "";
					 $prefix = 'EVT'.$json_data['CabangID'].substr(date('Ymd'),2,8);
					 $lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$json_data['CabangID']), 'dataevent')->num_rows() +1;
					 $NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);
				}
				else{
					$NoTransaksi = $json_data['NoTransaksi'];
				}

				$oObject = array(
					'NoTransaksi' => $NoTransaksi,
					'TglEvent' => $json_data['TglEvent'],
					'NamaEvent' => $json_data['NamaEvent'],
					'JenisEventID' => $json_data['JenisEventID'],
					'LokasiEvent' => $json_data['LokasiEvent'],
					'AlamatEvent' => $json_data['AlamatEvent'],
					'ContactPerson' => $json_data['ContactPerson'],
					'NoHPContactPerson' => $json_data['NoHPContactPerson'],
					'Berulang' => $json_data['Berulang'],
					'IntervalBerulang' => $json_data['IntervalBerulang'],
					'IntervalType' => $json_data['IntervalType'],
					'CabangID' => $json_data['CabangID'],
					'Keterangan' => $json_data['Keterangan'],
					'JamMulai' => $json_data['JamMulai'],
					'JamSelesai' => $json_data['JamSelesai'],
					'Keterangan' => $json_data['Keterangan'],
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$oSave = $this->db->insert('dataevent',$oObject);

					if (!$oSave) {
						$data['message'] = "Gagal Simpan Event";
	                    $errorCount +=1;
						goto jump;
					}
					for ($i=0; $i < count($json_data['detail']) ; $i++) {
	                	if($json_data['detail'][$i]['DivisiID'] != 0){
	                		$oObjectDetail = array(
		                		'DivisiID' => $json_data['detail'][$i]['DivisiID'],
								'JabatanID' => $json_data['detail'][$i]['JabatanID'],
								'CabangID' => $json_data['CabangID'],
								'Keterangan' => '',
								'BaseType' => 'EVENT',
								'BaseReff' => $NoTransaksi,
								'JumlahPelayan' => $json_data['detail'][$i]['JumlahPelayan']
		                	);

		                	$oObjectDetail['CreatedOn'] = $CreatedOn;
							$oObjectDetail['CreatedBy'] = $CreatedBy;
							$oSaveDetail = $this->db->insert('templatepelayan',$oObjectDetail);

							if (!$oSaveDetail) {
								$data['message'] = "Gagal Simpan Template";
			                    $errorCount +=1;
								goto jump;
							}
	                	}
	                }
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$oSave = $this->db->update('dataevent', $oObject, array('NoTransaksi'=>$NoTransaksi,'CabangID'=> $json_data['CabangID']));

					if (!$oSave) {
						$data['message'] = "Gagal Update Jadwal Ibadah";
	                    $errorCount +=1;
						goto jump;
					}

	                $this->db->where(array('BaseReff'=> $json_data['NoTransaksi'], 'CabangID'=>$json_data['CabangID'],'BaseType' => 'EVENT'));
	                $oDelete = $this->db->delete('templatepelayan');

	                if (!$oDelete) {
	                	$data['message'] = "gagal Delete Template";
	                    $errorCount +=1;
	                    goto jump;
	                }

	                for ($i=0; $i < count($json_data['detail']) ; $i++) {
	                	if($json_data['detail'][$i]['DivisiID'] != 0){
	                		$oObjectDetail = array(
		                		'DivisiID' => $json_data['detail'][$i]['DivisiID'],
								'JabatanID' => $json_data['detail'][$i]['JabatanID'],
								'CabangID' => $json_data['CabangID'],
								'Keterangan' => '',
								'BaseType' => 'EVENT',
								'BaseReff' => $json_data['NoTransaksi'],
								'JumlahPelayan' => $json_data['detail'][$i]['JumlahPelayan']
		                	);

		                	$oObjectDetail['CreatedOn'] = $CreatedOn;
							$oObjectDetail['CreatedBy'] = $CreatedBy;
							$oSaveDetail = $this->db->insert('templatepelayan',$oObjectDetail);

							if (!$oSaveDetail) {
								$data['message'] = "Gagal Simpan Template";
			                    $errorCount +=1;
								goto jump;
							}
	                	}
	                }
				}
				elseif ($formtype == "delete") {
					$this->db->where('BaseReff',$json_data['NoTransaksi']);
					$this->db->where('BaseType','EVENT');
					$this->db->where('CabangID',$json_data['CabangID']);
					$this->db->delete('templatepelayan');

					$this->db->where('NoTransaksi',$NoTransaksi);
					$this->db->where('CabangID',$json_data['$CabangID']);
					$this->db->delete('dataevent');
				}
				else{
					$data['message'] = "invalid Form Type";
				}

				jump:
				$this->db->trans_complete();
				if ($errorCount > 0) {
					$error = $this->db->error();
				    $this->db->trans_rollback();

				    if($error['code']) {
				    	$data['message'] = $error['message'];	
				    }
				}
				else{
					$data['success'] =true;
				}
			} catch (Exception $e) {
				$data['message'] = $e->message;
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
?>