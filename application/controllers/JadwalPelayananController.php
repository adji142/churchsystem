<?php 
	class JadwalPelayananController extends CI_Controller {
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
			$this->load->view('Pelayanan/JadwalPelayanan',$data);
		}
		public function ReadHeader()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$CabangID = $this->input->post('CabangID');

			$subquery = $this->db->select("penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID, Count(*) JumlahPelayan, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 1 THEN 1 ELSE NULL END) JumlahKonfirmasiHadir,COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 2 THEN 1 ELSE NULL END) JumlahKonfirmasiTidakHadir, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 0 THEN 1 ELSE NULL END) BelumKonfirmasi")
						->from('penugasanjadwalpelayanan')
						->join('cabang','penugasanjadwalpelayanan.CabangID = cabang.id','left')
						->group_by('penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID')->get_compiled_select();

			try {
				$this->db->select("jadwalpelayanan.NoTransaksi, jadwalpelayanan.TglTransaksi,CASE WHEN jadwalpelayanan.JenisTransaksi = 1 THEN 'IBADAH' ELSE 'EVENT' END JenisJadwal, jadwalpelayanan.CabangID, cabang.CabangName,COALESCE(jadwalibadah.NamaIbadah,dataevent.NamaEvent) AS NamaJadwal,COALESCE(DATE_FORMAT(jadwalibadah.MulaiJam,'%T'),DATE_FORMAT(dataevent.JamMulai,'%T')) AS JamMulai, COALESCE(DATE_FORMAT(jadwalibadah.SelesaiJam,'%T'),DATE_FORMAT(dataevent.JamSelesai,'%T')) AS JamSelesai, sub.JumlahPelayan, sub.JumlahKonfirmasiHadir,sub.JumlahKonfirmasiTidakHadir, sub.BelumKonfirmasi");
				$this->db->from('jadwalpelayanan');
				$this->db->join('jadwalibadah','jadwalpelayanan.JadwalIbadahID=jadwalibadah.id AND jadwalpelayanan.CabangID = jadwalibadah.CabangID','left');
				$this->db->join('dataevent','jadwalpelayanan.EventID=dataevent.NoTransaksi AND jadwalpelayanan.CabangID = dataevent.CabangID','left');
				$this->db->join('cabang','jadwalpelayanan.CabangID = cabang.id','left');
				$this->db->join("($subquery) as sub","jadwalpelayanan.NoTransaksi = sub.NoTransaksi and jadwalpelayanan.CabangID = sub.CabangID",'left');
				$this->db->join('defaulthari','defaulthari.KodeHari = COALESCE(jadwalibadah.Hari,dayname(dataevent.TglEvent))','left');
				// $this->db->where_between('jadwalpelayanan.TglTransaksi', $TglAwal, $TglAkhir);
				$this->db->where('jadwalpelayanan.TglTransaksi >=', $TglAwal);
				$this->db->where('jadwalpelayanan.TglTransaksi <=', $TglAkhir);

				if ($CabangID != "0") {
					$this->db->where(array("jadwalpelayanan.CabangID"=>$CabangID));
				}

				$rs = $this->db->get();

				$error = $this->db->error();
				// var_dump($error);
				if($error['code'] > 0) {
		            $data['message'] =$error['code'] .' - ' .$error['message'];
		        } else {
		            if ($rs->num_rows() > 0) {
						$data['success'] = true;
						$data['data'] = $rs->result();
					}
		        }
			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function form($NoTransaksi,$CabangID)
		{
			$this->db->select('*');
			$this->db->from('jadwalpelayanan');
			$this->db->where(array('NoTransaksi'=>$NoTransaksi));

			if ($CabangID != "0") {
				$this->db->where(array("CabangID"=>$CabangID));
			}

			$Header = $this->db->get();
			$Detail = $this->ModelsExecuteMaster->FindData(array('NoTransaksi'=> $NoTransaksi,'CabangID'=> $CabangID),'penugasanjadwalpelayanan')->result();
			$cabang = $this->ModelsExecuteMaster->GetCabang();

			$data['Cabang'] = $cabang->result();
			$data['header'] = $Header->result();
			$data['detail'] = json_encode($Detail);
			$this->load->view('Pelayanan/JadwalPelayanan-input',$data);
		}

		public function formKonfirmasi()
		{
			$cabang = $this->ModelsExecuteMaster->GetCabang();

			$data['Cabang'] = $cabang->result();
			$this->load->view('Pelayanan/KonfirmasiList',$data);
		}

		public function ReadDetail()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$NoTransaksi = $this->input->post('NoTransaksi');
			$CabangID = $this->input->post('CabangID');

			try {
				$this->db->select("penugasanjadwalpelayanan.*, cabang.CabangName, divisi.NamaDivisi, jabatan.NamaJabatan, CONCAT(personel.GelarDepan,' ',personel.NamaLengkap, ' ', personel.GelarBelakang) As NamaLengkap, CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 1 THEN 'Y' ELSE CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 2 THEN 'N' ELSE '' END END AS diKonfirmasi, (penugasanjadwalpelayanan.LineNumber) + 1 as LineNum, personel.NoHP, personel.Email, penugasanjadwalpelayanan.KonfirmasiKeterangan");
				$this->db->from('penugasanjadwalpelayanan');
				$this->db->join('cabang', 'penugasanjadwalpelayanan.CabangID = cabang.id','left');
				$this->db->join('divisi', 'penugasanjadwalpelayanan.DivisiID = divisi.id and penugasanjadwalpelayanan.CabangID = divisi.CabangID','left');
				$this->db->join('jabatan', 'penugasanjadwalpelayanan.JabatanID = jabatan.id and penugasanjadwalpelayanan.CabangID = jabatan.CabangID','left');
				$this->db->join('personel','penugasanjadwalpelayanan.PIC =personel.NIK and penugasanjadwalpelayanan.CabangID = personel.CabangID','left');
				$this->db->where("penugasanjadwalpelayanan.NoTransaksi", $NoTransaksi);
				$this->db->where("penugasanjadwalpelayanan.CabangID", $CabangID);

				$rs = $this->db->get();

				$error = $this->db->error();
				// var_dump($error);
				if($error['code'] > 0) {
		            $data['message'] =$error['code'] .' - ' .$error['message'];
		        } else {
		            if ($rs->num_rows() > 0) {
						$data['success'] = true;
						$data['data'] = $rs->result();
					}
		        }
			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function ReadKonfirmasiList()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$NoTransaksi = $this->input->post('NoTransaksi');
			$CabangID = $this->input->post('CabangID');
			$NikPersonel = $this->input->post('NikPersonel');
			$NoReff = $this->input->post('NoReff');

			try {
				$subquery = $this->db->select("penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID, Count(*) JumlahPelayan, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 1 THEN 1 ELSE NULL END) JumlahKonfirmasi, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 0 THEN 1 ELSE NULL END) BelumKonfirmasi")
						->from('penugasanjadwalpelayanan')
						->join('cabang','penugasanjadwalpelayanan.CabangID = cabang.id','left')
						->group_by('penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID')->get_compiled_select();

				$this->db->select("jadwalpelayanan.NoTransaksi, jadwalpelayanan.TglTransaksi,CASE WHEN jadwalpelayanan.JenisTransaksi = 1 THEN 'IBADAH' ELSE 'EVENT' END JenisJadwal, jadwalpelayanan.CabangID, cabang.CabangName,COALESCE(jadwalibadah.NamaIbadah,dataevent.NamaEvent) AS NamaJadwal,COALESCE(DATE_FORMAT(jadwalibadah.MulaiJam,'%T'),DATE_FORMAT(dataevent.JamMulai,'%T')) AS JamMulai, COALESCE(DATE_FORMAT(jadwalibadah.SelesaiJam,'%T'),DATE_FORMAT(dataevent.JamSelesai,'%T')) AS JamSelesai, sub.JumlahPelayan, sub.JumlahKonfirmasi, sub.BelumKonfirmasi,personel.NoHP, personel.Email, defaulthari.NamaHari,personel.NamaLengkap,penugasanjadwalpelayanan.KonfirmasiID, penugasanjadwalpelayanan.PIC, personel.NamaLengkap, personel.DivisiID, personel.JabatanID, COALESCE(absensi.NoTransaksi,'') NoAbsen, DATE_FORMAT(absensi.TglAbsen,'%d-%m-%Y %T') TglAbsen,CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 1 THEN 'Y' ELSE 'N' END Konfirmasi, penugasanjadwalpelayanan.KonfirmasiKeterangan");
				$this->db->from('jadwalpelayanan');
				$this->db->join('jadwalibadah','jadwalpelayanan.JadwalIbadahID=jadwalibadah.id AND jadwalpelayanan.CabangID = jadwalibadah.CabangID','left');
				$this->db->join('dataevent','jadwalpelayanan.EventID=dataevent.NoTransaksi AND jadwalpelayanan.CabangID = dataevent.CabangID','left');
				$this->db->join('cabang','jadwalpelayanan.CabangID = cabang.id','left');
				$this->db->join("($subquery) as sub","jadwalpelayanan.NoTransaksi = sub.NoTransaksi and jadwalpelayanan.CabangID = sub.CabangID",'left');
				$this->db->join('defaulthari','defaulthari.KodeHari = COALESCE(jadwalibadah.Hari,dayname(dataevent.TglEvent))');
				$this->db->join('penugasanjadwalpelayanan', 'jadwalpelayanan.NoTransaksi = penugasanjadwalpelayanan.NoTransaksi AND jadwalpelayanan.CabangID = penugasanjadwalpelayanan.CabangID');
				$this->db->join('personel','personel.NIK = penugasanjadwalpelayanan.PIC and personel.CabangID = penugasanjadwalpelayanan.CabangID');
				$this->db->join('absensi','jadwalpelayanan.NoTransaksi = absensi.ReffJadwal AND penugasanjadwalpelayanan.PIC = absensi.NIK','left');
				$this->db->where('penugasanjadwalpelayanan.Konfirmasi', "0");
				$this->db->where('jadwalpelayanan.TglTransaksi >=', $TglAwal);
				$this->db->where('jadwalpelayanan.TglTransaksi <=', $TglAkhir);

				if ($NoTransaksi != "") {
					$this->db->where(array("absensi.NoTransaksi"=>$NoTransaksi));
				}

				if ($CabangID != "") {
					$this->db->where(array("jadwalpelayanan.CabangID"=>$CabangID));
				}

				if ($NoReff != "") {
					$this->db->where(array("jadwalpelayanan.NoTransaksi"=>$NoReff));
				}

				if ($NikPersonel != "") {
					$this->db->where(array("penugasanjadwalpelayanan.PIC"=>$NikPersonel));
				}

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

		public function Konfirmasi($VerificationID)
		{
			// $data = array('success'=>false, 'message'=> "", 'data'=>array());

			$this->db->select('*');
			$this->db->from('penugasanjadwalpelayanan');
			$this->db->where('KonfirmasiID',$VerificationID);
			// $this->db->where('Konfirmasi !=', '0');
			$oData = $this->db->get();

			// var_dump($VerificationID);
			$data['message'] = "";
			$data['KonfirmasiID'] = "";
			if ($oData->num_rows() > 0) {
				$data["KonfirmasiID"] = $VerificationID;
			}
			else{
				$data['message'] = "Data Tidak Valid";
			}

			$this->load->view('Pelayanan/Konfirmasi',$data);

		}

		public function KonfirmasiAction()
		{
			$data = array('success'=>true,'message'=> '', 'data'=>array());

			$KonfirmasiID = $this->input->post('KonfirmasiID');
			$Konfirmasi = $this->input->post('Konfirmasi');
			$KonfirmasiKeterangan = $this->input->post('KonfirmasiKeterangan');

			try {
				$oObject = array(
					'UpdatedOn' => date('Y-m-d h:i:s'),
					'Konfirmasi' => $Konfirmasi,
					'KonfirmasiTime' => date('Y-m-d h:i:s'),
					'KonfirmasiKeterangan' => $KonfirmasiKeterangan
				);
				$this->db->update('penugasanjadwalpelayanan', $oObject, array('KonfirmasiID'=>$KonfirmasiID));

				$error = $this->db->error();

				if($error['code']) {
		            // echo "Database error occurred: ".$error['message'];
		            $data['message'] = $error['message'];
		        } else {
		            if ($this->db->affected_rows() > 0) {
						$data['success'] =true;
						$data['message'] = "Data Divisi Berhasil disimpan";
					}
		        }

			} catch (Exception $e) {
				$data['message'] = $e->message;
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
		public function CRUD()
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

				// var_dump($json_data);

				$NoTransaksi = "";
				if ($formtype == "add") {
					$prefix = 'JDW'.$json_data['CabangID'].substr(date('Ymd'),2,8);
					$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$json_data['CabangID']), 'jadwalpelayanan')->num_rows() +1;
					$NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);
				}

				$oObject = array(
					'NoTransaksi' => ($formtype == "add") ? $NoTransaksi : $json_data['NoTransaksi'],
					'TglTransaksi' => $json_data['TglTransaksi'],
					'CabangID' => $json_data['CabangID'],
					'JenisTransaksi' => $json_data['JenisTransaksi'],
					'JadwalIbadahID' => $json_data['JadwalIbadahID'],
					'EventID' => $json_data['EventID'],
					'NamaJadwal' => $json_data['NamaJadwal'],
					'DeskripsiJadwal' => $json_data['DeskripsiJadwal'],
					'PICKegiatan' => $json_data['PICKegiatan']
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$oSave = $this->db->insert('jadwalpelayanan',$oObject);

					if (!$oSave) {
						$data['message'] = "Gagal Simpan Jadwal Pelayanan";
	                    $errorCount +=1;
						goto jump;
					}

					if (count($json_data['detail']) == 0) {
	                    $data['message'] = "Data Pelayan";
	                    $errorCount +=1;
	                    goto jump;
	                }

	                for ($i=0; $i < count($json_data['detail']) ; $i++) {
	                	$oObjectDetail = array(
	                		'NoTransaksi' => ($formtype == "add") ? $NoTransaksi : $json_data['NoTransaksi'],
							'LineNumber' => $i,
							'CabangID' => $json_data['CabangID'],
							'DivisiID' => $json_data['detail'][$i]['DivisiID'],
							'JabatanID' => $json_data['detail'][$i]['JabatanID'],
							'PIC' => $json_data['detail'][$i]['NIK'],
							'Keterangan' => "",
							'KonfirmasiID' => random_string('alpha', 18),
							'Konfirmasi' => 0,
							'KonfirmasiKeterangan' => '',
	                	);

	                	$oObjectDetail['CreatedOn'] = $CreatedOn;
						$oObjectDetail['CreatedBy'] = $CreatedBy;
						$oSaveDetail = $this->db->insert('penugasanjadwalpelayanan',$oObjectDetail);

						if (!$oSaveDetail) {
							$data['message'] = "Gagal Simpan Penugasan Pelayanan";
		                    $errorCount +=1;
							goto jump;
						}
	                }
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$oSave = $this->db->update('jadwalpelayanan', $oObject, array('NoTransaksi'=>($formtype == "add") ? $NoTransaksi : $json_data['NoTransaksi'],'CabangID'=> $json_data['CabangID']));

					if (!$oSave) {
						$data['message'] = "Gagal Update Jadwal Pelayanan";
	                    $errorCount +=1;
						goto jump;
					}

					if (count($json_data['detail']) == 0) {
	                    $data['message'] = "Data Pelayan";
	                    $errorCount +=1;
	                    goto jump;
	                }

	                $this->db->where(array('NoTransaksi'=> ($formtype == "add") ? $NoTransaksi : $json_data['NoTransaksi'], 'CabangID'=>$json_data['CabangID']));
	                $oDelete = $this->db->delete('penugasanjadwalpelayanan');

	                if (!$oDelete) {
	                	$data['message'] = "gagal Delete Detail";
	                    $errorCount +=1;
	                    goto jump;
	                }

	                for ($i=0; $i < count($json_data['detail']) ; $i++) {
	                	$oObjectDetail = array(
	                		'NoTransaksi' => ($formtype == "add") ? $NoTransaksi : $json_data['NoTransaksi'],
							'LineNumber' => $i,
							'CabangID' => $json_data['CabangID'],
							'DivisiID' => $json_data['detail'][$i]['DivisiID'],
							'JabatanID' => $json_data['detail'][$i]['JabatanID'],
							'PIC' => $json_data['detail'][$i]['NIK'],
							'Keterangan' => "",
							'KonfirmasiID' => random_string('alpha', 18),
							'Konfirmasi' => 0,
							'KonfirmasiKeterangan' => '',
	                	);

	                	$oObjectDetail['UpdatedOn'] = $CreatedOn;
						$oObjectDetail['UpdatedBy'] = $CreatedBy;
						$oSaveDetail = $this->db->insert('penugasanjadwalpelayanan',$oObjectDetail);

						if (!$oSaveDetail) {
							$data['message'] = "Gagal Simpan Penugasan Pelayanan";
		                    $errorCount +=1;
							goto jump;
						}
	                }
				}
				elseif ($formtype == "delete") {
					$this->db->where('NoTransaksi',$NoTransaksi);
					$this->db->where('CabangID',$CabangID);
					$this->db->delete('penugasanjadwalpelayanan');
					$this->db->delete('jadwalpelayanan');
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
				} else {
				    $this->db->trans_commit();
				    $data['success'] =true;
					$data['message'] = "Data Jenis Event Berhasil disimpan";

					// Send Email
					// $insert_id = $this->db->insert_id();
					$lastTRX = ($formtype == "add") ? $NoTransaksi : $json_data['NoTransaksi'];
					$CabangID = $json_data['CabangID'];

					$subquery = $this->db->select("penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID, Count(*) JumlahPelayan, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 1 THEN 1 ELSE NULL END) JumlahKonfirmasi, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 0 THEN 1 ELSE NULL END) BelumKonfirmasi")
						->from('penugasanjadwalpelayanan')
						->join('cabang','penugasanjadwalpelayanan.CabangID = cabang.id','left')
						->group_by('penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID')->get_compiled_select();

					$this->db->select("jadwalpelayanan.NoTransaksi, jadwalpelayanan.TglTransaksi,CASE WHEN jadwalpelayanan.JenisTransaksi = 1 THEN 'IBADAH' ELSE 'EVENT' END JenisJadwal, jadwalpelayanan.CabangID, cabang.CabangName,COALESCE(jadwalibadah.NamaIbadah,dataevent.NamaEvent) AS NamaJadwal,COALESCE(DATE_FORMAT(jadwalibadah.MulaiJam,'%T'),DATE_FORMAT(dataevent.JamMulai,'%T')) AS JamMulai, COALESCE(DATE_FORMAT(jadwalibadah.SelesaiJam,'%T'),DATE_FORMAT(dataevent.JamSelesai,'%T')) AS JamSelesai, sub.JumlahPelayan, sub.JumlahKonfirmasi, sub.BelumKonfirmasi,personel.NoHP, personel.Email, defaulthari.NamaHari,personel.NamaLengkap,penugasanjadwalpelayanan.KonfirmasiID,jadwalpelayanan.CreatedBy");
					$this->db->from('jadwalpelayanan');
					$this->db->join('jadwalibadah','jadwalpelayanan.JadwalIbadahID=jadwalibadah.id AND jadwalpelayanan.CabangID = jadwalibadah.CabangID','left');
					$this->db->join('dataevent','jadwalpelayanan.EventID=dataevent.NoTransaksi AND jadwalpelayanan.CabangID = dataevent.CabangID','left');
					$this->db->join('cabang','jadwalpelayanan.CabangID = cabang.id','left');
					$this->db->join("($subquery) as sub","jadwalpelayanan.NoTransaksi = sub.NoTransaksi and jadwalpelayanan.CabangID = sub.CabangID",'left');
					$this->db->join('defaulthari','defaulthari.KodeHari = COALESCE(jadwalibadah.Hari,dayname(dataevent.TglEvent))');
					$this->db->join('penugasanjadwalpelayanan', 'jadwalpelayanan.NoTransaksi = penugasanjadwalpelayanan.NoTransaksi AND jadwalpelayanan.CabangID = penugasanjadwalpelayanan.CabangID');
					$this->db->join('personel','personel.NIK = penugasanjadwalpelayanan.PIC and personel.CabangID = penugasanjadwalpelayanan.CabangID');

					$this->db->where('jadwalpelayanan.NoTransaksi', $lastTRX);
					$this->db->where('jadwalpelayanan.CabangID', $CabangID);

					$saved = $this->db->get();

					$data = $this->ModelsExecuteMaster->SendEmail($saved->result());
					// foreach ($saved->result() as $key) {
					// 	$oParamEmail = array(
	    //             		"NamaLengkap" => $key->NamaLengkap,
	    //             		"Hari" => $key->NamaHari,
	    //             		"Tanggal" => $key->TglTransaksi,
	    //             		"Jam" => $key->JamMulai. ' Sampai '.$key->JamSelesai,
	    //             		"CreatedBy" => $CreatedBy,
	    //             		"KonfirmasiID" => $key->KonfirmasiID,
	    //             		"reciept" => $key->Email,
	    //             		"subject" => "Email Konfirmasi Kehadiran"
	    //             	);

	    //             	// var_dump($oParamEmail["NamaLengkap"]);

	    //             	$data = $this->ModelsExecuteMaster->SendEmail($oParamEmail);
	    //             	// var_dump($x);
	                	

					// }
				}


			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
?>