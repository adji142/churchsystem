<?php 
	class DemografiController extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		public function ReadDemografi()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$demografilevel = $this->input->post('demografilevel');
			$wherefield = $this->input->post('wherefield');
			$wherevalue = $this->input->post('wherevalue');

			$rs = $this->ModelsExecuteMaster->FindData(array($wherefield=> $wherevalue), $demografilevel);

			if ($rs->num_rows() > 0) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			jump:
			echo json_encode($data);
		}
	}
?>