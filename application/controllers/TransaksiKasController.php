<?php 
	class TransaksiKasController extends CI_Controller {
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
			$this->load->view('Finance/transaksi/mutasikas',$data);
		}
		public function Read()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$TglAwal = $this->input->post('TglAwal');
			$TglAkhir = $this->input->post('TglAkhir');
			$Transaksi = $this->input->post('Transaksi'); // 1: IN, 2: OUT
			$CabangID = $this->input->post('CabangID');
			$BaseType = $this->input->post('BaseType');

			try {
				$this->db->select("transaksikas.*, 
					akunkas.NamaAkun, 
					cabang.CabangName, 
					kasbasetype.Nama DeskripsiTransaksi, 
					CASE WHEN transaksikas.TipeTransaksi = 1 THEN 'IN' ELSE 'OUT' END 'Direction', 
					DATE_FORMAT(DATE(transaksikas.TglTransaksi),'%d-%m-%Y') Tanggal, 
					CASE WHEN transaksikas.TipeTransaksi = 1 THEN transaksikas.Total ELSE 0 END AS 'Debit', 
					CASE WHEN transaksikas.TipeTransaksi = 2 THEN transaksikas.Total ELSE 0 END AS 'Credit',0 Saldo");
				$this->db->from('transaksikas');
				$this->db->join('akunkas','transaksikas.KodeAkunKas = akunkas.KodeAkun and transaksikas.CabangID = akunkas.CabangID','left');
				$this->db->join('cabang', 'transaksikas.CabangID = cabang.id', 'left');
				$this->db->join('kasbasetype', 'transaksikas.BaseType = kasbasetype.Kode', 'left');
				$this->db->where('date(transaksikas.TglTransaksi) >=', $TglAwal);
				$this->db->where('date(transaksikas.TglTransaksi) <=', $TglAkhir);
				$this->db->where('transaksikas.StatusTransaksi','OPEN');

				if ($CabangID != "0") {
					$this->db->where(array("transaksikas.CabangID"=>$CabangID));
				}
				if ($Transaksi != "") {
					$this->db->where(array("transaksikas.TipeTransaksi"=>$Transaksi));
				}
				if ($BaseType != "") {
					$this->db->where(array("transaksikas.BaseType"=>$BaseType));
				}
				$this->db->order_by('transaksikas.TglTransaksi');

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

			$NoTransaksi = $this->input->post('NoTransaksi');
			$TglTransaksi = $this->input->post('TglTransaksi');
			$TipeTransaksi = $this->input->post('TipeTransaksi');
			$KodeAkunKas = $this->input->post('KodeAkunKas');
			$Total = $this->input->post('Total');
			$Keterangan = $this->input->post('Keterangan');
			$BaseType = $this->input->post('BaseType');
			$CabangID = $this->input->post('CabangID');
			$NoReff = $this->input->post('NoReff');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');


			try {
				if ($formtype == 'add') {
					$prefix = 'KAS'.$CabangID.substr(date('Ymd'),2,8);
					$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$CabangID), 'transaksikas')->num_rows() +1;
					$NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);
				}
				$oObject = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $TglTransaksi.' '.date('H:i:s'),
					'TipeTransaksi' => $TipeTransaksi,
					'KodeAkunKas' => $KodeAkunKas,
					'Total' => $Total,
					'Keterangan' => $Keterangan,
					'CabangID'	=> $CabangID,
					'BaseType' => $BaseType,
					'StatusTransaksi' => 'OPEN',
					'NoReff' => $NoReff
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('transaksikas',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('transaksikas', $oObject, array('NoTransaksi'=>$NoTransaksi,'CabangID'=>$CabangID));
				}
				elseif ($formtype == "delete") {
					$this->db->update('transaksikas', array('StatusTransaksi'=>'BATAL'), array('NoTransaksi'=>$NoTransaksi,'CabangID'=> $CabangID));
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

		public function SetorTunai()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$NoTransaksi = $this->input->post('NoTransaksi');
			$TglTransaksi = $this->input->post('TglTransaksi');
			$TipeTransaksi = 1;
			$KodeAkunKas = $this->input->post('KodeAkunKas');
			$KodeBank = $this->input->post('KodeBank');
			$Total = $this->input->post('Total');
			$Keterangan = $this->input->post('Keterangan');
			$BaseType = $this->input->post('BaseType');
			$CabangID = $this->input->post('CabangID');
			$NoReff = $this->input->post('NoReff');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');

			$errorCount = 0;
			try {
				$this->db->trans_start();

				if ($formtype == 'add') {
					$prefix = 'ST'.$CabangID.substr(date('Ymd'),2,8);
					$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$CabangID), 'transaksibank')->num_rows() +1;
					$NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);
				}

				$oKas = $this->ModelsExecuteMaster->FindData(array('KodeAkun'=> $KodeAkunKas, 'CabangID'=> $CabangID), 'akunkas')->row();

				if ($oKas->Saldo < $Total) {
					$data['message'] = "Saldo Kas Tidak Cukup";
					$errorCount += 1;
					goto jump;
				}

				$oBank = $this->ModelsExecuteMaster->FindData(array('KodeBank'=> $KodeBank, 'CabangID'=> $CabangID), 'bank')->row();

				$oObject = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $TglTransaksi.' '.date('H:i:s'),
					'TipeTransaksi' => 2,
					'KodeAkunKas' => $KodeAkunKas,
					'Total' => $Total,
					'Keterangan' => 'Setor Tunai Ke ' . $oBank->NamaBank.' Dari '.$oKas->NamaAkun.' - '. $Keterangan,
					'CabangID'	=> $CabangID,
					'BaseType' => $BaseType,
					'StatusTransaksi' => 'OPEN',
					'NoReff' => $NoReff
				);

				$oObjectBank = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $TglTransaksi.' '.date('H:i:s'),
					'TipeTransaksi' => 1,
					'KodeBank' => $KodeBank,
					'Total' => $Total,
					'Keterangan' => 'Setor Tunai Ke ' . $oBank->NamaBank.' Dari '.$oKas->NamaAkun.' - '. $Keterangan,
					'CabangID'	=> $CabangID,
					'BaseType' => $BaseType,
					'StatusTransaksi' => 'OPEN',
					'NoReff' => $NoReff
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$oSave = $this->db->insert('transaksibank',$oObjectBank);

					if (!$oSave) {
						$data['message'] = 'Transaksi Bank Gagal disimpan';
						$errorCount += 1;
						goto jump;
					}

					$oSaveKas = $this->db->insert('transaksikas',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('transaksikas', $oObject, array('NoTransaksi'=>$NoTransaksi,'CabangID'=>$CabangID));
				}
				elseif ($formtype == "delete") {
					$this->db->update('transaksibank', array('StatusTransaksi'=>'BATAL'), array('NoTransaksi'=>$NoTransaksi,'CabangID'=> $CabangID));

					$this->db->update('transaksikas', array('StatusTransaksi'=>'BATAL'), array('NoTransaksi'=>$NoTransaksi,'CabangID'=> $CabangID));
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
			            // echo "Database error occurred: ".$error['message'];
			            $data['message'] = $error['message'];
			        }
				}
				else{
					$data['success'] =true;
					$data['message'] = "Data Bank Berhasil disimpan";
				}
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}

		public function TarikTunai()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$NoTransaksi = $this->input->post('NoTransaksi');
			$TglTransaksi = $this->input->post('TglTransaksi');
			$TipeTransaksi = 1;
			$KodeAkunKas = $this->input->post('KodeAkunKas');
			$KodeBank = $this->input->post('KodeBank');
			$Total = $this->input->post('Total');
			$Keterangan = $this->input->post('Keterangan');
			$BaseType = $this->input->post('BaseType');
			$CabangID = $this->input->post('CabangID');
			$NoReff = $this->input->post('NoReff');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');

			$errorCount = 0;
			try {
				$this->db->trans_start();

				if ($formtype == 'add') {
					$prefix = 'TT'.$CabangID.substr(date('Ymd'),2,8);
					$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$CabangID), 'transaksibank')->num_rows() +1;
					$NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);
				}

				$oKas = $this->ModelsExecuteMaster->FindData(array('KodeAkun'=> $KodeAkunKas, 'CabangID'=> $CabangID), 'akunkas')->row();

				$oBank = $this->ModelsExecuteMaster->FindData(array('KodeBank'=> $KodeBank, 'CabangID'=> $CabangID), 'bank')->row();
				if ($oBank->Saldo < $Total) {
					$data['message'] = "Saldo Rekening Tidak Cukup";
					$errorCount += 1;
					goto jump;
				}

				$oObject = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $TglTransaksi.' '.date('H:i:s'),
					'TipeTransaksi' => 1,
					'KodeAkunKas' => $KodeAkunKas,
					'Total' => $Total,
					'Keterangan' => 'Tarik Tunai Dari ' . $oBank->NamaBank.' Ke '.$oKas->NamaAkun.' - '. $Keterangan,
					'CabangID'	=> $CabangID,
					'BaseType' => $BaseType,
					'StatusTransaksi' => 'OPEN',
					'NoReff' => $NoReff
				);

				$oObjectBank = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $TglTransaksi.' '.date('H:i:s'),
					'TipeTransaksi' => 2,
					'KodeBank' => $KodeBank,
					'Total' => $Total,
					'Keterangan' => 'Tarik Tunai Dari ' . $oBank->NamaBank.' Ke '.$oKas->NamaAkun.' - '. $Keterangan,
					'CabangID'	=> $CabangID,
					'BaseType' => $BaseType,
					'StatusTransaksi' => 'OPEN',
					'NoReff' => $NoReff
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$oSave = $this->db->insert('transaksibank',$oObjectBank);

					if (!$oSave) {
						$data['message'] = 'Transaksi Bank Gagal disimpan';
						$errorCount += 1;
						goto jump;
					}

					$oSaveKas = $this->db->insert('transaksikas',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('transaksikas', $oObject, array('NoTransaksi'=>$NoTransaksi,'CabangID'=>$CabangID));
				}
				elseif ($formtype == "delete") {
					$this->db->update('transaksibank', array('StatusTransaksi'=>'BATAL'), array('NoTransaksi'=>$NoTransaksi,'CabangID'=> $CabangID));

					$this->db->update('transaksikas', array('StatusTransaksi'=>'BATAL'), array('NoTransaksi'=>$NoTransaksi,'CabangID'=> $CabangID));
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
			            // echo "Database error occurred: ".$error['message'];
			            $data['message'] = $error['message'];
			        }
				}
				else{
					$data['success'] =true;
					$data['message'] = "Data Tarik Tunai Berhasil disimpan";
				}
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>