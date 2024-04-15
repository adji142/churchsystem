<?php 
	class ReportController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function rptJadwalPelayan()
		{
			$rs = $this->ModelsExecuteMaster->GetCabang();
			$data['Cabang'] = $rs->result();
			$this->load->view('Report/rpt_JadwalPelayanan',$data);
		}

		public function rptArusKas()
		{
			$rs = $this->ModelsExecuteMaster->GetCabang();
			$data['Cabang'] = $rs->result();
			$this->load->view('Report/rpt_ArusKas',$data);
		}

		public function rptAbsensi()
		{
			$rs = $this->ModelsExecuteMaster->GetCabang();
			$data['Cabang'] = $rs->result();
			$this->load->view('Report/rpt_Absensi',$data);
		}

		public function rptPersembahan($NoTransaksi)
		{
			// $xRS =$this->ModelsExecuteMaster->getFromStoreProcedure('rsp_penerimaan_persembahan', $oParam)->result();
			// $xRS = $this->ModelsExecuteMaster->GetStoreProcedure('rsp_penerimaan_persembahan',"'".$NoTransaksi."'");
			// var_dump($xRS->result());
			$data['NoTransaksi'] = $NoTransaksi;
			$this->load->view('Finance/transaksi/reportpersembahan',$data);
		}

		public function loadrptPersembahan()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());
			$NoTransaksi = $this->input->post('NoTransaksi');

			$persembahan = $this->ModelsExecuteMaster->GetStoreProcedure('rsp_penerimaan_persembahan',"'".$NoTransaksi."'");

			$data['data'] = $persembahan->result();

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function loatrptPerhitunganPersembahan()
		{
			$data = array('success'=>true, 'message'=>'', 'data'=>array());
			$NoTransaksi = $this->input->post('NoTransaksi');

			$this->db->select("denominasi.KodeDenom,COALESCE(perhitungandetailpersembahan.Qty,0) Qty, COALESCE(perhitungandetailpersembahan.Jumlah,0) Jumlah ");
			$this->db->from('denominasi');
			$this->db->join('perhitungandetailpersembahan',"denominasi.KodeDenom = perhitungandetailpersembahan.Denominasi AND perhitungandetailpersembahan.NoTransaksi = '".$NoTransaksi."'", 'LEFT');
			$this->db->order_by('denominasi.Index');

			$xRS = $this->db->get();
			$data['data'] = $xRS->result();

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}

		public function GrafikKasTahunan()
		{
			$data = array('success' => false ,'message'=>'','data'=>array());

			$CabangID = $this->input->post('CabangID');

			$this->db->select('MONTH(TglTransaksi) Bulan, YEAR(TglTransaksi) Tahun, SUM(CASE WHEN TipeTransaksi = 1 THEN Total ELSE 0 END) AS Debit, SUM(CASE WHEN TipeTransaksi = 2 THEN Total ELSE 0 END) AS Kredit');
			$this->db->from('transaksikas');
			$this->db->where('YEAR(TglTransaksi)', date('Y'));
			$this->db->where('StatusTransaksi','OPEN');

			if ($CabangID != "0") {
				$this->db->where('CabangID', $CabangID);
			}
			$this->db->group_by('MONTH(TglTransaksi), YEAR(TglTransaksi)');

			$kas = $this->db->get();

			$Pemasukan =array();
			$Pengeluaran =array();

			for ($i=0; $i < 12 ; $i++) { 
				array_push($Pemasukan, 0);
				array_push($Pengeluaran, 0);
			}

			for ($i=0; $i < 12 ; $i++) { 
				foreach ($kas->result() as $key) {
					if ($i+1 == $key->Bulan) {
						$Pemasukan[$i] = floatval($key->Debit);
						$Pengeluaran[$i] = floatval($key->Kredit);
					}
				}
			}

			$data['data']['Pemasukan'] = $Pemasukan;
			$data['data']['Pengeluaran'] = $Pengeluaran;

			$this->output->set_content_type('application/json')->set_output(json_encode($data));
		}
	}
?>