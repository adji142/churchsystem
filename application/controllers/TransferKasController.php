<?php
	class TransferKasController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function index()
		{
			$cabang = $this->ModelsExecuteMaster->GetCabang();

			$data['Cabang'] = $cabang->result();
			$this->load->view('Finance/transaksi/transferkas',$data);
		}
		public function approval()
		{
			$cabang = $this->ModelsExecuteMaster->GetCabang();

			$data['Cabang'] = $cabang->result();
			$this->load->view('Finance/transaksi/ApprovalTransferKas',$data);
		}

		public function ReadApprovalList()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());
			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$CabangID = $this->input->post('CabangID');
			$Approved = $this->input->post('Approved');

			// Get Kas Tujuan
			$oWhere = array(
				'PIC' => $this->session->userdata('NIKPersonel')
			);
			$oKasObject = $this->ModelsExecuteMaster->FindData($oWhere, 'akunkas');

			$oWhereIN = array();
			// var_dump($oKasObject->num_rows());

			if ($oKasObject->num_rows()) {
				foreach ($oKasObject as $key) {
					array_push($oWhereIN, $key->KodeAkun);
				}
			}

			$rs = $this->db->select("transferkas.*, CASE WHEN transferkas.Approved = 0 THEN 'Pending' ELSE 'Approved' END StatusTransaksi, akunkas.NamaAkun ")
			->from('transferkas')
			->join('akunkas', 'akunkas.KodeAkun = transferkas.KodeAkunAsal', 'left')
			->where('date(transferkas.TglTransaksi) >=', $TglAwal)
			->where('date(transferkas.TglTransaksi) <=', $TglAkhir);

			if ($CabangID != "0") {
				$rs = $this->db->where(array("transferkas.CabangID"=>$CabangID));
			}

			if ($Approved != "") {
				$rs = $this->db->where('transferkas.Approved', $Approved);
			}

			if (count($oWhereIN) > 0) {
				$rs = $this->db->where_in('transferkas.KodeAkunTujuan', $oWhereIN);
			}
			// var_dump($oWhereIN);

			$rs = $this->db->get();
			$data['success'] = true;
			$data['data'] = $rs->result();

			echo json_encode($data);
		}

		public function ReadHeader()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());
			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$CabangID = $this->input->post('CabangID');
			$Approved = $this->input->post('Approved');

			$this->db->select("transferkas.*, CASE WHEN transferkas.Approved = 0 THEN 'Pending' ELSE 'Approved' END StatusTransaksi ");
			$this->db->from('transferkas');
			$this->db->where('date(transferkas.TglTransaksi) >=', $TglAwal);
			$this->db->where('date(transferkas.TglTransaksi) <=', $TglAkhir);

			if ($CabangID != "0") {
				$this->db->where(array("transferkas.CabangID"=>$CabangID));
			}

			$rs = $this->db->get();
			$data['success'] = true;
			$data['data'] = $rs->result();

			echo json_encode($data);
		}
		public function ReadDetail()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$NoTransaksi = $this->input->post('NoTransaksi');
			$CabangID = $this->input->post('CabangID');

			$this->db->select("transferkas.KodeAkunAsal, akunkas.NamaAkun, 0 Debit, Jumlah Kredit");
			$this->db->from('transferkas');
			$this->db->join('akunkas','transferkas.KodeAkunAsal = akunkas.KodeAkun and transferkas.CabangID = akunkas.CabangID ');
			$this->db->where('transferkas.NoTransaksi',$NoTransaksi);
			$this->db->where('transferkas.CabangID', $CabangID);
			$query1 = $this->db->get_compiled_select();

			$this->db->select("transferkas.KodeAkunAsal, akunkas.NamaAkun, Jumlah Debit, 0 Kredit");
			$this->db->from('transferkas');
			$this->db->join('akunkas','transferkas.KodeAkunTujuan = akunkas.KodeAkun and transferkas.CabangID = akunkas.CabangID ');
			$this->db->where('transferkas.NoTransaksi',$NoTransaksi);
			$this->db->where('transferkas.CabangID', $CabangID);
			$query2 = $this->db->get_compiled_select();

			$union_query = $query1 . " UNION " . $query2;
			$query = $this->db->query($union_query);

			$data['success'] = true;
			$data['data'] = $query->result();

			echo json_encode($data);
		}

		public function Find()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());
			$NoTransaksi = $this->input->post('NoTransaksi');
			$CabangID = $this->input->post('CabangID');

			$this->db->select("transferkas.*");
			$this->db->from('transferkas');
			$this->db->where('NoTransaksi', $NoTransaksi);
			$this->db->where(array("transferkas.CabangID"=>$CabangID));

			$rs = $this->db->get();
			$data['success'] = true;
			$data['data'] = $rs->result();

			echo json_encode($data);
		}

		public function CRUD()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$NoTransaksi = $this->input->post('NoTransaksi');
			$TglTransaksi = $this->input->post('TglTransaksi');
			$KodeAkunAsal = $this->input->post('KodeAkunAsal');
			$KodeAkunTujuan = $this->input->post('KodeAkunTujuan');
			$Jumlah = $this->input->post('Jumlah');
			$Keterangan = $this->input->post('Keterangan');
			$CabangID = $this->input->post('CabangID');
			$Approved = $this->input->post('Approved');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');

			$this->db->trans_start();
			$errorCount = 0;

			try{
				// Validasi : 
				$this->db->select('*');
				$this->db->from('akunkas');
				$this->db->where('KodeAkun', $KodeAkunAsal);
				$this->db->where('CabangID', $CabangID);

				$rs = $this->db->get();
				$oValidation = $rs->row();
				if ($rs->num_rows() == 0) {
					$data["message"] = "Akun Kas Tidak Dikenali";
					$errorCount +=1;
					goto jump;
				}

				if (doubleval($oValidation->Saldo) < doubleval($Jumlah)) {
					$data['message'] = "Transaksi ini berpotensi menyebabkan saldo kas Akun ". $oValidation->NamaAkun." Menjadi Minus, Transaksi Tidak Dapat Dilanjutkan";
					$errorCount+=1;
					goto jump;
				}

				if ($formtype == 'add') {
					$prefix = 'TKAS'.substr(date('Ymd'),2,4);
					$query = "SELECT * FROM transferkas where LEFT(NoTransaksi,8) = '".$prefix."' ";

					$lastNoTrx = $this->db->query($query)->num_rows() +1;
					$NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);
				}

				$oObject = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $TglTransaksi,
					'KodeAkunAsal' => $KodeAkunAsal,
					'KodeAkunTujuan' => $KodeAkunTujuan,
					'Jumlah' => $Jumlah,
					'Keterangan' => $Keterangan,
					'CabangID'	=> $CabangID,
					'StatusTransaksi' => 'OPEN',
					'Approved' => $Approved
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('transferkas',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('transferkas', $oObject, array('NoTransaksi'=>$NoTransaksi,'CabangID'=>$CabangID));
				}
				elseif ($formtype == "delete") {
					$oObject['UpdatedBy'] = $UpdatedBy;
					$oObject['UpdatedOn'] = $UpdatedOn;
					$this->db->update('transferkas', array('StatusTransaksi'=>'BATAL'), array('NoTransaksi'=>$NoTransaksi,'CabangID'=> $CabangID));
				}
				else{
					$data['message'] = "invalid Form Type";
					$errorCount +=1;
					goto jump;
				}

				// Add Kas

				if ($Approved == 1) {
					$prefix = 'TKAS'.substr(date('Ymd'),2,4);
					$this->db->select('NoTransaksi');
					$this->db->distinct();
					$this->db->from('transaksikas');
					$this->db->where('LEFT(NoTransaksi,8)',$prefix);
					$rs = $this->db->get();
					// var_dump($rs->num_rows());
					$lastNoTrx = $rs->num_rows();
					$NoKas = $prefix.str_pad($lastNoTrx + 1, 4, '0', STR_PAD_LEFT);

					$oObjectKas = array(
						'NoTransaksi' => $NoKas,
						'TipeTransaksi' => 2,
						'KodeAkunKas' => $KodeAkunAsal,
						'Total' => $Jumlah,
						'Keterangan' => 'Transfer Kas ke : '.$KodeAkunTujuan ,
						'CabangID'	=> $CabangID,
						'BaseType' => 'TKAS',
						'StatusTransaksi' => 'OPEN',
						'NoReff' => $NoTransaksi
					);
					$oObjectKas['TglTransaksi'] = $CreatedOn;

					$oWhere = array(
						'NoReff' => $NoTransaksi,
						'BaseType' => 'TKAS',
						'KodeAkunKas' => $KodeAkunAsal
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
							'BaseType' => 'TKAS',
							'KodeAkunKas' => $KodeAkunAsal
						);

						$oSave = $this->ModelsExecuteMaster->ExecUpdate($oObjectKas, $oWhere, 'transaksikas');
					}

					if (!$oSave) {
						$errorCount +=1;
						$data['message'] = 'Error Simpan Pengeluaran Kas';
						goto jump;
					}

					// Terima Kas
					$NoKas = $prefix.str_pad($lastNoTrx + 2, 4, '0', STR_PAD_LEFT);

					$oObjectKas = array(
						'NoTransaksi' => $NoKas,
						'TipeTransaksi' => 1,
						'KodeAkunKas' => $KodeAkunTujuan,
						'Total' => $Jumlah,
						'Keterangan' => 'Transfer Kas ke : '.$KodeAkunAsal ,
						'CabangID'	=> $CabangID,
						'BaseType' => 'TKAS',
						'StatusTransaksi' => 'OPEN',
						'NoReff' => $NoTransaksi
					);
					$oObjectKas['TglTransaksi'] = $CreatedOn;

					$oWhere = array(
						'NoReff' => $NoTransaksi,
						'BaseType' => 'TKAS',
						'KodeAkunKas' => $KodeAkunTujuan
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
							'BaseType' => 'TKAS',
							'KodeAkunKas' => $KodeAkunAsal
						);

						$oSave = $this->ModelsExecuteMaster->ExecUpdate($oObjectKas, $oWhere, 'transaksikas');
					}

					if (!$oSave) {
						$errorCount +=1;
						$data['message'] = 'Error Simpan Pengeluaran Kas';
						goto jump;
					}
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

			}catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>