<?php 
	class TemplatePetugasController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function index()
		{
			$this->load->view('V_Master/RatePK');
		}
		public function find()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$CabangID = $this->input->post('CabangID');
			$BaseReff = $this->input->post('BaseReff');
			$BaseType = $this->input->post('BaseType');

			try {
				$this->db->select('templatepelayan.*,divisi.NamaDivisi, jabatan.NamaJabatan');
				$this->db->from('templatepelayan');
				$this->db->join('divisi', 'templatepelayan.DivisiID = divisi.id and templatepelayan.CabangID = divisi.CabangID','left');
				$this->db->join('jabatan', 'templatepelayan.JabatanID = jabatan.id and templatepelayan.CabangID = jabatan.CabangID','left');
				$this->db->where('templatepelayan.BaseReff', $BaseReff);
				$this->db->where('templatepelayan.BaseType', $BaseType);
				$this->db->where('templatepelayan.CabangID', $CabangID);

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