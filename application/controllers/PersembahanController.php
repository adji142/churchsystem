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
		public function inputpersembahan($Tanggal, $Hari, $JadwalIbadahID, $CabangID)
		{
			// Hari
			$this->db->select('*');
			$this->db->from('defaulthari');
			$this->db->order_by('Index', 'ASC');
			$getHari = $this->db->get();

			// Cabang
			$cabang = $this->ModelsExecuteMaster->GetCabang();

			// Get Jadwal Ibadah
			$this->db->select("*");
			$this->db->from("jadwalibadah");
			$this->db->where('CabangID', $CabangID);
			$jadwalibadah = $this->db->get();

			$data['Cabang'] = $cabang->result();
			$data['Hari'] = $getHari->result();
			$data['jadwalibadah'] = $jadwalibadah->result();
			$data['TanggalIbadah'] = $Tanggal;
			$data['HariIbadah'] = $Hari;
			$data['JadwalIbadahID'] = $JadwalIbadahID;
			$data['ParseCabangID'] = $CabangID;
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
			$TglIbadah = $this->input->post('TglIbadah');
			$Hari = $this->input->post('Hari');
			$JadwalIbadahID = $this->input->post('JadwalIbadahID');
			$CabangID = $this->input->post('CabangID');

			$this->db->select('perhitunganheader.NoTransaksi AS TRX, perhitunganheader.TglTransaksi,perhitunganheader.PICPerhitungan PICHeader,perhitunganheader.KodeAkun,perhitungandetailpersembahan.*');
			$this->db->from('perhitunganheader');
			$this->db->join('perhitungandetailpersembahan', 'perhitunganheader.NoTransaksi = perhitungandetailpersembahan.NoTransaksi','LEFT');
			$this->db->where('perhitunganheader.TglIbadah', $TglIbadah);
			$this->db->where('perhitunganheader.CabangID', $CabangID);
			$this->db->where('perhitunganheader.JadwalIbadahID', $JadwalIbadahID);
			$this->db->where('perhitunganheader.HariIbadah', $Hari);

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

		// New Version

		public function ReadDataPersembahan()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$Tglawal = $this->input->post('Tglawal');
			$TglAkhir = $this->input->post('TglAkhir');
			$CabangID = $this->input->post('CabangID');

			$rs = $this->ModelsExecuteMaster->GetStoreProcedure('rsp_read_persembahan',"'".$Tglawal."','".$TglAkhir."',".$CabangID);

			$oReturn = $rs->result();

			if (count($oReturn) > 0) {
				$data['success'] = true;
				$data['data'] = $oReturn;
			}
			echo json_encode($data);
		}

		public function ReadDataPK()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$Tanggal = $this->input->post('Tanggal');
			$Hari = $this->input->post('Hari');
			$JadwalIbadahID = $this->input->post('JadwalIbadahID');
			$CabangID = $this->input->post('CabangID');

			$rs = $this->ModelsExecuteMaster->GetStoreProcedure('rsp_read_absensi_for_pk',"'".$Tanggal."','".$Hari."',".$JadwalIbadahID.",".$CabangID);

			$oReturn = $rs->result();

			if (count($oReturn) > 0) {
				$data['success'] = true;
				$data['data'] = $oReturn;
			}
			echo json_encode($data);
		}

		public function SavePersembahan()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$json_data = json_decode(file_get_contents('php://input'), true);

			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');

			$lastTRX = "";

			$errorCount = 0;

			$NoTransaksi = "";
			$NoKas = "";

			try {
				$this->db->trans_start();

				$formtype = $json_data['formtype'];

				$prefix = 'PRS'.substr(date('Ymd'),2,4);
				$this->db->select('NoTransaksi');
				$this->db->distinct();
				$this->db->from('perhitunganheader');
				$this->db->where('LEFT(NoTransaksi,7)',$prefix);
				$lastNoTrx = $this->db->count_all_results();
				$NoTransaksi = $prefix.str_pad($lastNoTrx + 1, 4, '0', STR_PAD_LEFT);

				$NoTransaksi = ($formtype == 'add') ? $NoTransaksi : $json_data['NoTransaksi'];

				if ($json_data['PICPerhitungan'] == "") {
					$data['message'] = "PIC Persembahan Harus diisi";
					$errorCount +=1;
					goto jump;
				}

				if ($json_data['KodeAkunKas'] == "") {
					$data['message'] = "Akun Kas Harus diisi";
					$errorCount +=1;
					goto jump;
				}

				$TglTransaksi = $json_data['TglTransaksi'];
				$PICPerhitungan = $json_data['PICPerhitungan'];
				$Keterangan = $json_data['Keterangan'];
				$JadwalIbadahID = $json_data['JadwalIbadahID'];
				$TglIbadah = $json_data['TglIbadah'];
				$CabangID = $json_data['CabangID'];
				$HariIbadah = $json_data['HariIbadah'];

				$oHeader = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $json_data['TglTransaksi'],
					'PICPerhitungan' => $json_data['PICPerhitungan'],
					'Keterangan' => $json_data['Keterangan'],
					'JadwalIbadahID' => $json_data['JadwalIbadahID'],
					'TglIbadah' => $json_data['TglIbadah'],
					'CabangID' => $json_data['CabangID'],
					'HariIbadah' => $json_data['HariIbadah'],
					'KodeAkun' => $json_data['KodeAkunKas'],
				);

				if ($formtype == "add") {
					$oHeader['CreatedOn'] = $CreatedOn;
					$oHeader['CreatedBy'] = $CreatedBy;	
					$oSaveHeader = $this->db->insert('perhitunganheader',$oHeader);
				}
				else{
					$oHeader['UpdatedOn'] = $UpdatedOn;
					$oHeader['UpdatedBy'] = $UpdatedBy;	
					// $oSaveHeader = $this->db->insert('perhitunganheader',$oHeader);
					$owhere = array(
						'NoTransaksi' => $NoTransaksi
					);
					$oSaveHeader = $this->ModelsExecuteMaster->ExecUpdate($oHeader, $owhere, 'perhitunganheader');
				}

				if (!$oSaveHeader) {
					$data['message'] = "Gagal Simpan Persembahan";
                    $errorCount +=1;
					goto jump;
				}
				// PK
				$LineNumber = 0;
				$TotalPK = 0;
				foreach ($json_data['PK'] as $key) {
					$oPK = array(
						'NoTransaksi' => $NoTransaksi,
						'LineNumber' => $LineNumber,
						'DivisiID' => $key['DivisiID'],
						'PIC' =>  $key['NIK'],
						'RatePKID' => $key['RatePKID'],
						'RatePK' => $key['Rate']
					);
					$TotalPK += $key['Rate'];

					$oWhere = array(
						'NoTransaksi' => $NoTransaksi,
						'PIC' => $key['NIK']
					);

					$oExist = $this->ModelsExecuteMaster->FindData($oWhere, 'perhitungandetailpk');

					if ($oExist->num_rows() == 0) {
						$oPK['CreatedOn'] = $CreatedOn;
						$oPK['CreatedBy'] = $CreatedBy;
						$oSave = $this->db->insert('perhitungandetailpk',$oPK);
					}
					else{
						$oPK['UpdatedOn'] = $UpdatedOn;
						$oPK['UpdatedBy'] = $UpdatedBy;

						$oWhere = array(
							'NoTransaksi' => $NoTransaksi,
							'PIC' => $key['NIK']
						);
						$oSave = $this->ModelsExecuteMaster->ExecUpdate($oPK, $oWhere, 'perhitungandetailpk');
					}

					if (!$oSave) {
						$data['message'] = "Gagal Simpan Realisasi PK";
	                    $errorCount +=1;
						goto jump;
					}

					$LineNumber +=1;
				}

				// Persembahan
				$LineNumber = 0;
				$TotalPersembahan = 0;
				foreach ($json_data['DenomPersembahan'] as $key) {
					$oPersembahan = array(
						'NoTransaksi' => $NoTransaksi,
						'LineNum' => $LineNumber,
						'Denominasi' => $key['Denominasi'],
						'Qty' => $key['Qty'],
						'Jumlah' => $key['Jumlah'],
						'PICPerhitungan' => $key['PICPerhitungan'],
					);

					$TotalPersembahan += $key['Jumlah'];

					$oWhere = array(
						'NoTransaksi' => $NoTransaksi,
						'Denominasi' => $key['Denominasi'],
					);
					$oExist = $this->ModelsExecuteMaster->FindData($oWhere, 'perhitungandetailpersembahan');

					if ($oExist->num_rows() == 0) {
						$oPersembahan['CreatedOn'] = $CreatedOn;
						$oPersembahan['CreatedBy'] = $CreatedBy;
						$oSave = $this->db->insert('perhitungandetailpersembahan',$oPersembahan);
					}
					else{
						$oPersembahan['UpdatedOn'] = $UpdatedOn;
						$oPersembahan['UpdatedBy'] = $UpdatedBy;

						$oWhere = array(
							'NoTransaksi' => $NoTransaksi,
							'Denominasi' => $key['Denominasi'],
						);

						$oSave = $this->ModelsExecuteMaster->ExecUpdate($oPersembahan, $oWhere, 'perhitungandetailpersembahan');
					}

					if (!$oSave) {
						$data['message'] = "Gagal Simpan Denominasi Persembahan";
	                    $errorCount +=1;
						goto jump;
					}

					$LineNumber +=1;
				}

				// Kas -> Penerimaan Persembahan

				if ($TotalPersembahan > 0) {
					$prefix = 'KOL'.substr(date('Ymd'),2,4);
					$this->db->select('NoTransaksi');
					$this->db->distinct();
					$this->db->from('transaksikas');
					$this->db->where('LEFT(NoTransaksi,7)',$prefix);
					$lastNoTrx = $this->db->count_all_results();
					$NoKas = $prefix.str_pad($lastNoTrx + 1, 4, '0', STR_PAD_LEFT);

					$oObjectKas = array(
						'NoTransaksi' => $NoKas,
						'TipeTransaksi' => 1,
						'KodeAkunKas' => $json_data['KodeAkunKas'],
						'Total' => $TotalPersembahan,
						'Keterangan' => 'Penerimaan Uang dari Ibadah : '.$json_data['NamaIbadah'] ,
						'CabangID'	=> $json_data['CabangID'],
						'BaseType' => 'KOL',
						'StatusTransaksi' => 'OPEN',
						'NoReff' => $NoTransaksi
					);
					$oObjectKas['TglTransaksi'] = $CreatedOn;

					$oWhere = array(
						'NoReff' => $NoTransaksi,
						'BaseType' => 'KOL',
					);

					$oExist = $this->ModelsExecuteMaster->FindData($oWhere, 'transaksikas');

					if ($oExist->num_rows() == 0) {
						$oObjectKas['CreatedOn'] = $CreatedOn;
						$oObjectKas['CreatedBy'] = $CreatedBy;
						$oSave = $this->db->insert('transaksikas',$oObjectKas);
					}
					else{
						$oObjectKas['UpdatedOn'] = $UpdatedOn;
						$oObjectKas['UpdatedBy'] = $UpdatedBy;

						$oWhere = array(
							'NoReff' => $NoTransaksi,
							'BaseType' => 'KOL',
						);

						$oSave = $this->ModelsExecuteMaster->ExecUpdate($oObjectKas, $oWhere, 'transaksikas');
					}

					if (!$oSave) {
						$errorCount +=1;
						$data['message'] = 'Error Simpan Penerimaan Kas';
						goto jump;
					}
				}

				// Kas -> Pengeluaran PK

				if ($TotalPK > 0) {
					$prefix = 'IPK'.substr(date('Ymd'),2,4);
					$this->db->select('NoTransaksi');
					$this->db->distinct();
					$this->db->from('transaksikas');
					$this->db->where('LEFT(NoTransaksi,7)',$prefix);
					$lastNoTrx = $this->db->count_all_results();
					$NoKas = $prefix.str_pad($lastNoTrx + 1, 4, '0', STR_PAD_LEFT);

					$oObjectKas = array(
						'NoTransaksi' => $NoKas,
						'TipeTransaksi' => 2,
						'KodeAkunKas' => $json_data['KodeAkunKas'],
						'Total' => $TotalPK,
						'Keterangan' => 'Pengeluaran PK Ibadah : '.$json_data['NamaIbadah'] ,
						'CabangID'	=> $json_data['CabangID'],
						'BaseType' => 'IPK',
						'StatusTransaksi' => 'OPEN',
						'NoReff' => $NoTransaksi
					);
					$oObjectKas['TglTransaksi'] = $CreatedOn;
					// $oSave = $this->db->insert('transaksikas',$oObjectKas);

					$oWhere = array(
						'NoReff' => $NoTransaksi,
						'BaseType' => 'IPK',
					);

					$oExist = $this->ModelsExecuteMaster->FindData($oWhere, 'transaksikas');

					if ($oExist->num_rows() == 0) {
						$oObjectKas['CreatedOn'] = $CreatedOn;
						$oObjectKas['CreatedBy'] = $CreatedBy;
						$oSave = $this->db->insert('transaksikas',$oObjectKas);
					}
					else{
						$oObjectKas['UpdatedOn'] = $UpdatedOn;
						$oObjectKas['UpdatedBy'] = $UpdatedBy;

						$oWhere = array(
							'NoReff' => $NoTransaksi,
							'BaseType' => 'IPK',
						);

						$oSave = $this->ModelsExecuteMaster->ExecUpdate($oObjectKas, $oWhere, 'transaksikas');
					}

					if (!$oSave) {
						$errorCount +=1;
						$data['message'] = 'Error Simpan Pengeluaran Kas';
						goto jump;
					}
				}


			} catch (Exception $e) {
				$errorCount += 1;
				$data['message'] = $e->getMessage();
				goto jump;
			}

			jump:

			$this->db->trans_complete();
			if ($errorCount > 0) {
				$data['success'] = false;
				$error = $this->db->error();
			    $this->db->trans_rollback();

			    if($error['code']) {
			    	$data['message'] = $error['message'];	
			    }
			}
			else{
				$this->db->trans_commit();
			    $data['success'] =true;
				$data['message'] = "Data Persembahan Berhasil disimpan";
			}

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
?>