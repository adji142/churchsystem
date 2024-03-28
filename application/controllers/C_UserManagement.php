<?php 
	class C_UserManagement extends CI_Controller {
		function __construct()
		{
			parent::__construct();
			$this->load->model('ModelsExecuteMaster');
			$this->load->model('GlobalVar');
			$this->load->model('LoginMod');
		}

		// ============================= Roles =============================
		public function ReadRole()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$id = $this->input->post('id');
			$this->db->select('roles.id, roles.rolename, roles.CabangID, cabang.CabangName, roles.LevelAkses');
			$this->db->from('roles');
			$this->db->join('cabang','cabang.id = roles.CabangID','left');
			if ($id != "") {
				// $rs = $this->ModelsExecuteMaster->FindData(array('id'=>$id),'roles');
				$this->db->where('roles.id', $id);
			}

			if ($this->session->userdata('CabangID') != 0) {
				$this->db->where('CabangID', $this->session->userdata('CabangID'));
			}

			$rs = $this->db->get();

			$error = $this->db->error();

			if($error['code']) {
	            // echo "Database error occurred: ".$error['message'];
	            $data['message'] = $error['message'];
	        } else {
	            if ($rs) {
					$data['success'] = true;
					$data['data'] = $rs->result();
				}
	        }
			echo json_encode($data);
		}
		public function CRUDRole()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$id = $this->input->post('id');
			$rolename = $this->input->post('rolename');
			$formtype = $this->input->post('formtype');
			$CabangID = $this->input->post('CabangID');
			$LevelAkses = $this->input->post('LevelAkses');
			$param = array(
				'id'		=> $id,
				'rolename'	=> $rolename,
				'CabangID'	=> $CabangID,
				'LevelAkses' => $LevelAkses
			);

			$rs;
			$errormessage = '';
			if ($formtype == 'add') {
				$rs = $this->ModelsExecuteMaster->ExecInsert($param,'roles');
				if ($rs) {
					$data['success'] = true;
					$data['message'] = "Data Berhasil Disimpan";
				}
				else{
					$data['message'] = "Gagal Tambah data roles";
				}
			}
			elseif ($formtype == 'edit') {
				$rs = $this->ModelsExecuteMaster->ExecUpdate($param,array('id'=>$id),'roles');
				if ($rs) {
					$data['success'] = true;
					$data['message'] = "Data Berhasil Disimpan";
				}
				else{
					$data['message'] = "Gagal Edit data roles";
				}
			}
			elseif ($formtype == 'delete') {
				$rs = $this->ModelsExecuteMaster->DeleteData(array('id'=>$id),'roles');
				if ($rs) {
					$data['success'] = true;
					$data['message'] = "Data Berhasil Disimpan";
				}
				else{
					$data['message'] = "Gagal Delete data roles";
				}
			}
			else{
				$data['message'] = "Invalid Form Type";
			}
			echo json_encode($data);
		}
		// ================================= End Roles ===============================
		// ============================= Permission Roles ============================
		public function ReadPermission()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$id = $this->input->post('id');
			$rs;
			if ($id != "") {
				$rs = $this->ModelsExecuteMaster->FindData(array('id'=>$id),'permission');
			}
			else{
				$rs = $this->ModelsExecuteMaster->GetData('permission');
			}

			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			echo json_encode($data);
		}

		public function ReadPermissionRole()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());

			$roleid = $this->input->post('roleid');
			$rs;
			if ($roleid != "") {
				$rs = $this->ModelsExecuteMaster->FindData(array('roleid'=>$roleid),'permissionrole');
			}
			else{
				$rs = $this->ModelsExecuteMaster->GetData('permissionrole');
			}

			if ($rs) {
				$data['success'] = true;
				$data['data'] = $rs->result();
			}
			echo json_encode($data);
		}
		public function RemovePermissionRole()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());
			$roleid = $this->input->post('roleid');

			$rs = $this->ModelsExecuteMaster->DeleteData(array('roleid'=>$roleid),'permissionrole');
			if ($rs) {
				$data['success'] = true;
				$data['message'] = "Data Berhasil Disimpan";
			}
			else{
				$data['message'] = "Gagal Delete data roles";
			}
			echo json_encode($data);
		}
		public function AddPermissionRole()
		{
			$data = array('success' => false ,'message'=>array(),'data'=>array());
			$roleid = $this->input->post('roleid');
			$permissionid = $this->input->post('permissionid');

			$param = array(
				'roleid'		=> $roleid,
				'permissionid'	=> $permissionid
			);

			$rs = $this->ModelsExecuteMaster->ExecInsert($param, 'permissionrole');
			if ($rs) {
				$data['success'] = true;
			}
			echo json_encode($data);
		}

		// ========================== End Permission Roles ===========================
	}
?>