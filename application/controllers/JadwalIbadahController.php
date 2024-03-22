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
		public function form($id, $CabangID)
		{
			$this->db->select("jadwalibadah.*,defaulthari.NamaHari, DATE_FORMAT(jadwalibadah.SelesaiJam,'%T') SelesaiJamFormated, DATE_FORMAT(jadwalibadah.MulaiJam,'%T') MulaiJamFormated");
			$this->db->from('jadwalibadah');
			$this->db->join('defaulthari','defaulthari.KodeHari=jadwalibadah.Hari','left');
			$this->db->where(array("1"=>"1"));
			$this->db->where(array("CabangID"=>$CabangID));

			if ($id != "0") {
				$this->db->where(array("id"=>$id));
			}

			$jadwalibadah = $this->db->get();

			$this->db->select("divisi.id AS DivisiID,jabatan.id AS JabatanID, divisi.NamaDivisi, jabatan.NamaJabatan, CASE WHEN templatepelayan.id IS NULL THEN 'N' ELSE 'Y' END checked, COALESCE(templatepelayan.JumlahPelayan,0) JumlahPelayan");
			$this->db->from('divisi');
			$this->db->join('jabatan', 'divisi.id = jabatan.DivisiID AND divisi.CabangID = jabatan.CabangID','left');
			$this->db->join('templatepelayan', 'divisi.id = templatepelayan.DivisiID AND jabatan.id = templatepelayan.JabatanID AND divisi.CabangID = templatepelayan.CabangID','left');
			$this->db->where(array("templatepelayan.BaseReff"=>$id));
			$this->db->where(array("templatepelayan.BaseType"=>'JADWALIBADAH'));
			$this->db->where(array("templatepelayan.CabangID"=>$CabangID));
			$this->db->order_by('divisi.id', 'ASC');
			$this->db->order_by('jabatan.id', 'ASC');

			$template = $this->db->get();

			$rs = $this->ModelsExecuteMaster->GetCabang();

			$this->db->select('*');
			$this->db->from('defaulthari');
			$this->db->order_by('Index', 'ASC');
			$getHari = $this->db->get();

			$data['jadwalibadah'] = $jadwalibadah->result();
			$data['template'] = $template->result();
			$data['Cabang'] = $rs->result();
			$data['Hari'] = $getHari->result();
			$this->load->view('V_Master/jadwalibadah-input',$data);
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

				$oObject = array(
					'NamaIbadah' => $json_data['NamaIbadah'],
					'Hari' => $json_data['Hari'],
					'MulaiJam' => $json_data['MulaiJam'],
					'SelesaiJam' => $json_data['SelesaiJam'],
					'CabangID' => $json_data['CabangID'],
					'Keterangan' => $json_data['Keterangan'],
				);
				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$oSave = $this->db->insert('jadwalibadah',$oObject);

					$lastID = $this->db->insert_id();
					if (!$oSave) {
						$data['message'] = "Gagal Simpan Jadwal Ibadah";
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
								'BaseType' => 'JADWALIBADAH',
								'BaseReff' => $lastID,
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
					$oSave = $this->db->update('jadwalibadah', $oObject, array('id'=>$json_data['id']));

					if (!$oSave) {
						$data['message'] = "Gagal Update Jadwal Ibadah";
	                    $errorCount +=1;
						goto jump;
					}

	                $this->db->where(array('BaseReff'=> $json_data['id'], 'CabangID'=>$json_data['CabangID'],'BaseType' => 'JADWALIBADAH'));
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
								'BaseType' => 'JADWALIBADAH',
								'BaseReff' => $json_data['id'],
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
					$this->db->where('BaseReff',$json_data['id']);
					$this->db->where('BaseType','JADWALIBADAH');
					$this->db->where('CabangID',$json_data['CabangID']);
					$this->db->delete('templatepelayan');

					$this->db->where('id',$json_data['id']);
					$this->db->where('CabangID',$json_data['CabangID']);
					$this->db->delete('jadwalibadah');
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

		public function ReadTemplate()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$CabangID = $this->input->post('CabangID');
			$BaseType = $this->input->post('BaseType');

			try {
				$this->db->select("divisi.id AS DivisiID,jabatan.id AS JabatanID, divisi.NamaDivisi, jabatan.NamaJabatan, CASE WHEN templatepelayan.id IS NULL THEN 'N' ELSE 'Y' END checked, COALESCE(templatepelayan.JumlahPelayan, 1) JumlahPelayan ");
				$this->db->from('divisi');
				$this->db->join('jabatan', 'divisi.id = jabatan.DivisiID AND divisi.CabangID = jabatan.CabangID','left');
				$this->db->join('templatepelayan', "divisi.id = templatepelayan.DivisiID AND jabatan.id = templatepelayan.JabatanID AND divisi.CabangID = templatepelayan.CabangID AND templatepelayan.BaseReff= '".$BaseType."' ",'left');
				// $this->db->where('templatepelayan.BaseType', $BaseType);

				// var_dump("cabangdong". $this->session->userdata('CabangID'));

				if ($CabangID != "0") {
					$this->db->where(array("divisi.CabangID"=>$CabangID));
				}
				$this->db->order_by('divisi.id', 'ASC');
				$this->db->order_by('jabatan.id', 'ASC');

				$rs = $this->db->get();
				if ($rs->num_rows() > 0) {
					$data['success'] = true;
					$data['data'] = $rs->result();
				}
			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
			}
			echo json_encode($data);
		}
	}
?>