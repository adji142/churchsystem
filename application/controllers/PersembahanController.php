<?php 
	class PersembahanController extends CI_Controller {
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
			$this->load->view('Finance/transaksi/persembahan',$data);
		}
		public function ReadDenom()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());
			$this->db->select('*');
			$this->db->from('denominasi');
			$this->db->order_by('Index');
			$denom = $this->db->get();
			$data['data'] = $denom->result();

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
		public function inputpersembahan($NoTransaksi, $CabangID)
		{
			$data['NoTransaksi'] = $NoTransaksi;
			$data['parseCabangID'] = $CabangID;
			$this->load->view('Finance/transaksi/persembahan-input',$data);
		}

		public function LoadDataPersembahan()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());
			$NoJadwal = $this->input->post('NoJadwal');

			$persembahan = $this->ModelsExecuteMaster->GetStoreProcedure('fsp_getPersonelRate',"'".$NoJadwal."'");

			$data['data'] = $persembahan->result();

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function penerimaan($NoTransaksi, $CabangID)
		{
			$data['NoTransaksi'] = $NoTransaksi;
			$data['parseCabangID'] = $CabangID;
			$this->load->view('Finance/transaksi/persembahan-masuk-input',$data);
		}
		public function ReadPenerimaanUang()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());
			$BaseReff = $this->input->post('BaseReff');
			$BaseType = $this->input->post('BaseType');
			$CabangID = $this->input->post('CabangID');
			$isDenom = $this->input->post('isDenom');

			$this->db->select('penerimaanuang.*, akunkas.NamaAkun');
			$this->db->from('penerimaanuang');
			$this->db->join('akunkas', 'penerimaanuang.KodeAkunKas = akunkas.KodeAkun and penerimaanuang.CabangID = akunkas.CabangID', 'left');
			$this->db->where('penerimaanuang.BaseReff',$BaseReff);
			$this->db->where('penerimaanuang.BaseType',$BaseType);
			$this->db->where('penerimaanuang.CabangID',$CabangID);

			if ($isDenom == 'Y') {
				$this->db->where('penerimaanuang.KodeDenom !=','');
			}
			else{
				$this->db->where('penerimaanuang.KodeDenom','');
			}

			$datapenerimaan = $this->db->get();

			$data['data'] = $datapenerimaan->result();
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
		public function CRUDPenerimaan()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());
			$json_data = json_decode(file_get_contents('php://input'), true);

			// $distinctObject = array_unique($json_data['KodeAkunKas']);
			$akunkas = array();
			foreach ($json_data['detail'] as $key) {
				array_push($akunkas,$key['KodeAkunKas']);
			}

			$distinctArray = array_unique($akunkas);

			try {
				$this->db->trans_start();
				$errorCount = 0;

				$CreatedOn = date('Y-m-d h:i:s');
				$UpdatedOn = date('Y-m-d h:i:s');
				$CreatedBy = $this->session->userdata('NamaUser');
				$UpdatedBy = $this->session->userdata('NamaUser');


				$prefix = 'KOL'.$json_data['CabangID'].substr(date('Ymd'),2,8);
				$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$json_data['CabangID']), 'penerimaanuang')->num_rows() +1;
				$NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);

				$total = 0;
				$BaseReff = '';
				$KodeAkunKas = '';
				// Save Penerimaan Uang
				foreach ($json_data['detail'] as $key) {
					$NoTransaksi = ($json_data['formtype'] == "add") ? $NoTransaksi : $key['NoTransaksi'];
					$oSaveObject = array(
						'NoTransaksi' => $NoTransaksi,
						'TglTransaksi' => $CreatedOn,
						'BaseType' => $key['Basetype'],
						'BaseReff' => $key['BaseReff'],
						'KodeDenom' => $key['KodeDenom'],
						'KodeAkunKas' => $key['KodeAkunKas'],
						'Keterangan' => $key['Keterangan'],
						'Qty' => $key['Qty'],
						'Jumlah' => $key['Jumlah'],
						'CabangID' => $json_data['CabangID'],
					);

					$BaseReff = $key['BaseReff'];
					$KodeAkunKas = $key['KodeAkunKas'];

					if ($json_data['formtype'] == 'add') {
						$oSaveObject['CreatedOn'] = $CreatedOn;
						$oSaveObject['CreatedBy'] = $CreatedBy;

						$oSave = $this->db->insert('penerimaanuang',$oSaveObject);
					}
					elseif ($json_data['formtype'] == 'edit') {
						$oSaveObject['UpdatedBy'] = $UpdatedBy;

						$oSave = $this->db->update('penerimaanuang', $oSaveObject, array('NoTransaksi'=>$NoTransaksi,'KodeDenom' => $key['KodeDenom'],'BaseReff'=>$key['BaseReff']));
						// $oSave = $this->db->insert('penerimaanuang',$oSaveObject);
					}
					else{
						$data['message'] = 'Invalid form Type';
						goto jump;
					}
					$total += $key['Jumlah'];
					if (!$oSave) {
						$data['message'] = 'Gagal Input Data Penerimaan Uang';
						goto jump;
					}
				}

				// Save Arus Kas
				$oObjectKas = array(
					'NoTransaksi' => $NoTransaksi,
					'TipeTransaksi' => 1,
					'KodeAkunKas' => $KodeAkunKas,
					'Total' => $total,
					'Keterangan' => 'Penerimaan Uang dari Ibadah Nomor : '.$BaseReff ,
					'CabangID'	=> $json_data['CabangID'],
					'BaseType' => 'KOL',
					'StatusTransaksi' => 'OPEN',
					'NoReff' => $BaseReff
				);
				if ($json_data['formtype'] == 'add') {
					$oObjectKas['TglTransaksi'] = $CreatedOn;
					$oSave = $this->db->insert('transaksikas',$oObjectKas);
				}
				elseif ($json_data['formtype'] == 'edit') {
					$oObjectKas['UpdatedBy'] = $UpdatedBy;
					$oWhere = array(
						'NoTransaksi'=>$NoTransaksi,
						'NoReff'=>$BaseReff,
						'KodeAkunKas' => $KodeAkunKas
					);

					$oTransaksiKas = $this->ModelsExecuteMaster->FindData($oWhere, 'transaksikas');
					if ($oTransaksiKas->num_rows() > 0) {
						$oSave = $this->db->update('transaksikas', $oObjectKas, $oWhere);
					}
					else{
						$oObjectKas['TglTransaksi'] = $CreatedOn;
						$oSave = $this->db->insert('transaksikas',$oObjectKas);
					}
				}
				else{
					$data['message'] = 'Invalid Form Type';
					goto jump;
				}
				if (!$oSave) {
					$data['message'] = 'Gagal Input Data KAS';
					goto jump;
				}

				// Penerimaan Uang Lain Lain

				$total = 0;
				$BaseReff = '';
				// Save Penerimaan Uang
				$row = 0;
				foreach ($json_data['penerimaanlain'] as $key) {
					$prefix = 'PUO'.$json_data['CabangID'].$row.substr(date('Ymd'),2,8);
					$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$json_data['CabangID']), 'penerimaanuang')->num_rows() +1;
					$NoTransaksi = $prefix.str_pad($lastNoTrx, 5, '0', STR_PAD_LEFT);


					$NoTransaksi = ($json_data['formtype'] == "add") ? $NoTransaksi : $key['NoTransaksi'];

					$oSaveObject = array(
						'NoTransaksi' => $NoTransaksi,
						'BaseType' => $key['Basetype'],
						'BaseReff' => $key['BaseReff'],
						'KodeDenom' => $key['KodeDenom'],
						'KodeAkunKas' => $key['KodeAkunKas'],
						'Keterangan' => $key['Keterangan'],
						'Qty' => $key['Qty'],
						'Jumlah' => $key['Jumlah'],
						'CabangID' => $json_data['CabangID'],
					);
					$BaseReff = $key['BaseReff'];

					if ($json_data['formtype'] == 'add') {
						$oSaveObject['TglTransaksi'] = $CreatedOn;
						$oSaveObject['CreatedOn'] = $CreatedOn;
						$oSaveObject['CreatedBy'] = $CreatedBy;
						$oSave = $this->db->insert('penerimaanuang',$oSaveObject);
					}
					elseif ($json_data['formtype'] == 'edit') {
						$oSaveObject['UpdatedBy'] = $UpdatedBy;
						$oWhere = array(
							'NoTransaksi'=>$NoTransaksi,
							'KodeDenom' => $key['KodeDenom'],
							'BaseReff'=>$key['BaseReff'],
							'KodeAkunKas' => $key['KodeAkunKas']
						);

						$oTransaksipenerimaan = $this->ModelsExecuteMaster->FindData($oWhere, 'penerimaanuang');
						// var_dump($oTransaksipenerimaan->num_rows());
						if ($oTransaksipenerimaan->num_rows() > 0) {
							$oSave = $this->db->update('penerimaanuang', $oSaveObject, $oWhere);
						}
						else{
							$prefix = 'PUO'.$json_data['CabangID'].$row.substr(date('Ymd'),2,8);
							$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$json_data['CabangID']), 'penerimaanuang')->num_rows() +1;
							$NoTransaksi = $prefix.str_pad($lastNoTrx, 5, '0', STR_PAD_LEFT);

							$oSaveObject['NoTransaksi'] = $NoTransaksi;
							$oSaveObject['TglTransaksi'] = $CreatedOn;
							$oSave = $this->db->insert('penerimaanuang',$oSaveObject);
						}
					}
					else{
						$data['message'] = 'Invalid Form Type';
						goto jump;
					}
					$total += $key['Jumlah'];
					if (!$oSave) {
						$data['message'] = 'Gagal Input Data Penerimaan Uang Other';
						goto jump;
					}
					else{
						// Save Arus Kas
						$oObjectKas = array(
							'NoTransaksi' => $NoTransaksi,
							'TglTransaksi' => $CreatedOn,
							'TipeTransaksi' => 1,
							'KodeAkunKas' => $key['KodeAkunKas'],
							'Total' =>  $key['Jumlah'],
							'Keterangan' => 'Penerimaan Uang dari Ibadah Nomor : '.$BaseReff.'- '.$key['Keterangan'] ,
							'CabangID'	=> $json_data['CabangID'],
							'BaseType' => 'KOL',
							'StatusTransaksi' => 'OPEN',
							'NoReff' => $BaseReff
						);

						if ($json_data['formtype'] == 'add') {
							$oObjectKas['TglTransaksi'] = $CreatedOn;
							$oObjectKas['CreatedOn'] = $CreatedOn;
							$oObjectKas['CreatedBy'] = $CreatedBy;
							$oSave = $this->db->insert('transaksikas',$oObjectKas);
						}
						elseif ($json_data['formtype'] == 'edit') {
							$oObjectKas['UpdatedBy'] = $UpdatedBy;
							$oWhere = array(
								'NoTransaksi'=>$NoTransaksi,
								'KodeAkunKas' => $key['KodeAkunKas']
							);

							$oTransaksiKas = $this->ModelsExecuteMaster->FindData($oWhere, 'transaksikas');
							// var_dump($oWhere);
							if ($oTransaksiKas->num_rows() > 0) {
								$oSave = $this->db->update('transaksikas', $oObjectKas, $oWhere);
							}
							else{
								$oObjectKas['TglTransaksi'] = $CreatedOn;
								$oSave = $this->db->insert('transaksikas',$oObjectKas);
							}
						}
						if (!$oSave) {
							$data['message'] = 'Gagal Input Data KAS';
							goto jump;
						}
					}
					$row += 1;
				}

				jump:
				$this->db->trans_complete();
				if ($errorCount > 0) {
					$error = $this->db->error();
				    $this->db->trans_rollback();

				    if($error['code']) {
				    	$data['message'] = $error['message'];	
				    }
				}else{
					$data['success'] = true;
				}
			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function CRUDPengeluaran()
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
				if ($formtype == "add") {
					$prefix = 'CO'.$json_data['CabangID'].substr(date('Ymd'),2,8);
					$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$json_data['CabangID']), 'pengeluaranuang')->num_rows() +1;
					$NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);
				}

				$TotalTransaksi = 0;
				foreach ($json_data['detail'] as $key) {
					$oObject = array(
						'NoTransaksi' => $json_data['NoTransaksi'], 
						'BaseReff' => $json_data['BaseReff'], 
						'BaseType' => 'JDW', 
						'NIK' => $key['NIK'], 
						'Jumlah' => $key['Jumlah'],
						'CabangID' => $json_data['CabangID'], 
						'KodeAkunKas' => $json_data['KodeAkunKas']
					);

					$TotalTransaksi += $key['Jumlah'];

					if ($json_data['formtype'] == 'add') {
						$oObject['TglTransaksi'] = $json_data['TglTransaksi'];
						$oObject['CreatedOn'] = $CreatedOn;
						$oObject['CreatedBy'] = $CreatedBy;
						$oSave = $this->db->insert('pengeluaranuang',$oObject);
					}
					elseif ($json_data['formtype'] == 'edit') {
						$oObject['UpdatedBy'] = $UpdatedBy;
						$oWhere = array(
							'NoTransaksi'=>$NoTransaksi,
							'KodeAkunKas' => $json_data['KodeAkunKas'],
							'BaseReff' => $json_data['BaseReff']
						);

						$oTransaksi = $this->ModelsExecuteMaster->FindData($oWhere, 'pengeluaranuang');
						// var_dump($oWhere);
						if ($oTransaksi->num_rows() > 0) {
							$oSave = $this->db->update('pengeluaranuang', $oObject, $oWhere);
						}
						else{
							$oObject['TglTransaksi'] = $CreatedOn;
							$oSave = $this->db->insert('pengeluaranuang',$oObject);
						}
					}
					else{
						$data['message'] = "invalid Form Type";
						goto jump;
					}

					if (!$oSave) {
						$data['message'] = 'Gagal Input Data KAS';
						goto jump;
					}
				}

				// KAS
				$oObjectKas = array(
					'NoTransaksi' => $NoTransaksi,
					'TipeTransaksi' => 2,
					'KodeAkunKas' => $json_data['KodeAkunKas'],
					'Total' =>  $TotalTransaksi,
					'Keterangan' => 'Pengeluaran Uang dari Ibadah Nomor : '.$json_data['BaseReff'] ,
					'CabangID'	=> $json_data['CabangID'],
					'BaseType' => 'KOL',
					'StatusTransaksi' => 'OPEN',
					'NoReff' => $json_data['BaseReff']
				);

				if ($json_data['formtype'] == 'add') {
					$oObjectKas['TglTransaksi'] = $json_data['TglTransaksi'];
					$oObjectKas['CreatedOn'] = $CreatedOn;
					$oObjectKas['CreatedBy'] = $CreatedBy;
					$oSave = $this->db->insert('transaksikas',$oObjectKas);
				}
				elseif ($json_data['formtype'] == 'edit') {
					$oObjectKas['UpdatedBy'] = $UpdatedBy;
					$oWhere = array(
						'NoTransaksi'=>$NoTransaksi,
						'KodeAkunKas' => $key['KodeAkunKas']
					);

					$oTransaksiKas = $this->ModelsExecuteMaster->FindData($oWhere, 'transaksikas');
					// var_dump($oWhere);
					if ($oTransaksiKas->num_rows() > 0) {
						$oSave = $this->db->update('transaksikas', $oObjectKas, $oWhere);
					}
					else{
						$oObjectKas['TglTransaksi'] = $CreatedOn;
						$oSave = $this->db->insert('transaksikas',$oObjectKas);
					}
				}
				if (!$oSave) {
					$data['message'] = 'Gagal Input Data KAS';
					goto jump;
				}

				jump:
				$this->db->trans_complete();
				if ($errorCount > 0) {
					$error = $this->db->error();
				    $this->db->trans_rollback();

				    if($error['code']) {
				    	$data['message'] = $error['message'];	
				    }
				}else{
					$data['success'] = true;
				}
			} catch (Exception $e) {
				$data['message'] = $e->getMessage();
			}
			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function pengeluaran($NoTransaksi, $CabangID)
		{
			$data['NoTransaksi'] = $NoTransaksi;
			$data['parseCabangID'] = $CabangID;
			$this->load->view('Finance/transaksi/persembahan-keluar-input',$data);
		}
		public function ReadDataRate()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());
			$NoJadwal = $this->input->post('NoJadwal');
			$CabangID = $this->input->post('CabangID');

			$this->db->select("personel.NIK, concat(personel.GelarDepan,' ', personel.NamaLengkap,' ',personel.GelarBelakang) AS NamaLengkap, divisi.NamaDivisi,posisipelayanan.PosisiPelayanan as NamaJabatan,COALESCE(ratepk.Rate,0) Rate,absensi.CabangID ");
			$this->db->from('absensi');
			$this->db->join('penugasanjadwalpelayanan','absensi.ReffJadwal = penugasanjadwalpelayanan.NoTransaksi');
			$this->db->join('jadwalpelayanan','penugasanjadwalpelayanan.NoTransaksi = jadwalpelayanan.NoTransaksi');
			$this->db->join('personel', 'penugasanjadwalpelayanan.PIC = personel.NIK');
			$this->db->join('ratepk', 'jadwalpelayanan.JadwalIbadahID = ratepk.IbadahID AND DAYNAME(jadwalpelayanan.TglTransaksi) = ratepk.Hari AND penugasanjadwalpelayanan.PosisiPelayananID = ratepk.BidangPelayananID','LEFT');
			$this->db->join('divisi','personel.DivisiID = divisi.id');
			$this->db->join('posisipelayanan','penugasanjadwalpelayanan.PosisiPelayananID = posisipelayanan.id');
			$this->db->where('absensi.ReffJadwal',$NoJadwal);
			$this->db->where('absensi.CabangID', $CabangID);
			$this->db->order_by('personel.DivisiID');
			$this->db->order_by('personel.JabatanID');


			// $this->db->select("personel.NIK, concat(personel.GelarDepan,' ', personel.NamaLengkap,' ',personel.GelarBelakang) AS NamaLengkap, divisi.NamaDivisi,jabatan.NamaJabatan,COALESCE(ratepk.Rate,0) Rate,absensi.CabangID ");
			// $this->db->from('absensi');
			// $this->db->join('jadwalpelayanan', 'absensi.ReffJadwal = jadwalpelayanan.NoTransaksi AND absensi.CabangID = jadwalpelayanan.CabangID','left');
			// $this->db->join('personel', 'absensi.NIK = personel.NIK and absensi.CabangID = personel.CabangID','left');
			// $this->db->join('penugasanjadwalpelayanan','jadwalpelayanan.NoTransaksi = penugasanjadwalpelayanan.NoTransaksi');
			// $this->db->join('ratepk','ratepk.IbadahID = jadwalpelayanan.JadwalIbadahID AND DAYNAME(jadwalpelayanan.TglTransaksi) = ratepk.Hari AND penugasanjadwalpelayanan.PosisiPelayananID = ratepk.BidangPelayananID','left');
			// $this->db->join('divisi', 'personel.DivisiID = divisi.id', 'left');
			// $this->db->join('jabatan', 'personel.JabatanID = jabatan.id', 'left');
			// $this->db->where('absensi.ReffJadwal',$NoJadwal);
			// $this->db->where('absensi.CabangID', $CabangID);
			// $this->db->order_by('personel.DivisiID');
			// $this->db->order_by('personel.JabatanID');

			$RateData = $this->db->get();

			$data['data'] = $RateData->result();

			$this->output->set_content_type('application/json')->set_output(json_encode($data));

		}
		public function ReadIbadah()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());

			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$CabangID = $this->input->post('CabangID');

			$subquery = $this->db->select("penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID, Count(*) JumlahPelayan, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 1 THEN 1 ELSE NULL END) JumlahKonfirmasiHadir,COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 2 THEN 1 ELSE NULL END) JumlahKonfirmasiTidakHadir, COUNT(CASE WHEN penugasanjadwalpelayanan.Konfirmasi = 0 THEN 1 ELSE NULL END) BelumKonfirmasi")
						->from('penugasanjadwalpelayanan')
						->join('cabang','penugasanjadwalpelayanan.CabangID = cabang.id','left')
						->group_by('penugasanjadwalpelayanan.NoTransaksi,penugasanjadwalpelayanan.CabangID')->get_compiled_select();

			$subqueryKas = $this->db->select("transaksikas.NoReff, transaksikas.CabangID , SUM(CASE WHEN transaksikas.TipeTransaksi = 1 THEN transaksikas.Total ELSE 0 END)  Debit, SUM(CASE WHEN transaksikas.TipeTransaksi = 2 THEN transaksikas.Total ELSE 0 END)  Kredit")
							->from('transaksikas')
							->where('StatusTransaksi','OPEN')
							->where('BaseType','KOL')
							->group_by('transaksikas.NoReff, transaksikas.CabangID')->get_compiled_select();

			$subqueryabsen = $this->db->select('absensi.ReffJadwal,absensi.CabangID, COUNT(*) Absen')
							->from('absensi')
							->group_by('absensi.ReffJadwal,absensi.CabangID')->get_compiled_select();

			try {
				$this->db->select("jadwalpelayanan.NoTransaksi, jadwalpelayanan.TglTransaksi,CASE WHEN jadwalpelayanan.JenisTransaksi = 1 THEN 'IBADAH' ELSE 'EVENT' END JenisJadwal, jadwalpelayanan.CabangID, cabang.CabangName,COALESCE(jadwalibadah.NamaIbadah,dataevent.NamaEvent) AS NamaJadwal,COALESCE(DATE_FORMAT(jadwalibadah.MulaiJam,'%T'),DATE_FORMAT(dataevent.JamMulai,'%T')) AS JamMulai, COALESCE(DATE_FORMAT(jadwalibadah.SelesaiJam,'%T'),DATE_FORMAT(dataevent.JamSelesai,'%T')) AS JamSelesai, sub.JumlahPelayan, sub.JumlahKonfirmasiHadir,sub.JumlahKonfirmasiTidakHadir, sub.BelumKonfirmasi, COALESCE(kas.Debit,0) Debit, COALESCE(kas.Kredit,0) AS Kredit,COALESCE(abs.Absen,0) JumlahAbsen");
				$this->db->from('jadwalpelayanan');
				$this->db->join('jadwalibadah','jadwalpelayanan.JadwalIbadahID=jadwalibadah.id AND jadwalpelayanan.CabangID = jadwalibadah.CabangID','left');
				$this->db->join('dataevent','jadwalpelayanan.EventID=dataevent.NoTransaksi AND jadwalpelayanan.CabangID = dataevent.CabangID','left');
				$this->db->join('cabang','jadwalpelayanan.CabangID = cabang.id','left');
				$this->db->join("($subquery) as sub","jadwalpelayanan.NoTransaksi = sub.NoTransaksi and jadwalpelayanan.CabangID = sub.CabangID",'left');
				$this->db->join('defaulthari','defaulthari.KodeHari = COALESCE(jadwalibadah.Hari,dayname(dataevent.TglEvent))','left');
				$this->db->join("($subqueryKas) as kas", 'jadwalpelayanan.NoTransaksi = kas.NoReff AND jadwalpelayanan.CabangID = kas.CabangID','left');
				$this->db->join("($subqueryabsen) as abs", 'jadwalpelayanan.NoTransaksi = abs.ReffJadwal AND jadwalpelayanan.CabangID = abs.CabangID','left');
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