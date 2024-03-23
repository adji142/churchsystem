<?php 
	class AbsensiController extends CI_Controller {
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
			$this->load->view('Pelayanan/Absensi',$data);
		}
		public function Read()
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

				$this->db->select("jadwalpelayanan.NoTransaksi, jadwalpelayanan.TglTransaksi,CASE WHEN jadwalpelayanan.JenisTransaksi = 1 THEN 'IBADAH' ELSE 'EVENT' END JenisJadwal, jadwalpelayanan.CabangID, cabang.CabangName,COALESCE(jadwalibadah.NamaIbadah,dataevent.NamaEvent) AS NamaJadwal,COALESCE(DATE_FORMAT(jadwalibadah.MulaiJam,'%T'),DATE_FORMAT(dataevent.TglEvent,'%T')) AS JamMulai, COALESCE(DATE_FORMAT(jadwalibadah.SelesaiJam,'%T'),'SELESAI') AS JamSelesai, sub.JumlahPelayan, sub.JumlahKonfirmasi, sub.BelumKonfirmasi,personel.NoHP, personel.Email, defaulthari.NamaHari,personel.NamaLengkap,penugasanjadwalpelayanan.KonfirmasiID, penugasanjadwalpelayanan.PIC, personel.NamaLengkap, personel.DivisiID, personel.JabatanID, COALESCE(absensi.NoTransaksi,'') NoAbsen, DATE_FORMAT(absensi.TglAbsen,'%d-%m-%Y %T') TglAbsen");
				$this->db->from('jadwalpelayanan');
				$this->db->join('jadwalibadah','jadwalpelayanan.JadwalIbadahID=jadwalibadah.id AND jadwalpelayanan.CabangID = jadwalibadah.CabangID','left');
				$this->db->join('dataevent','jadwalpelayanan.JadwalIbadahID=dataevent.NoTransaksi AND jadwalpelayanan.CabangID = dataevent.CabangID','left');
				$this->db->join('cabang','jadwalpelayanan.CabangID = cabang.id','left');
				$this->db->join("($subquery) as sub","jadwalpelayanan.NoTransaksi = sub.NoTransaksi and jadwalpelayanan.CabangID = sub.CabangID",'left');
				$this->db->join('defaulthari','defaulthari.KodeHari = COALESCE(jadwalibadah.Hari,dayname(dataevent.TglEvent))');
				$this->db->join('penugasanjadwalpelayanan', 'jadwalpelayanan.NoTransaksi = penugasanjadwalpelayanan.NoTransaksi AND jadwalpelayanan.CabangID = penugasanjadwalpelayanan.CabangID');
				$this->db->join('personel','personel.NIK = penugasanjadwalpelayanan.PIC and personel.CabangID = penugasanjadwalpelayanan.CabangID');
				$this->db->join('absensi','jadwalpelayanan.NoTransaksi = absensi.ReffJadwal AND penugasanjadwalpelayanan.PIC = absensi.NIK','left');
				$this->db->where('penugasanjadwalpelayanan.Konfirmasi', "1");
				$this->db->where('jadwalpelayanan.TglTransaksi >=', $TglAwal);
				$this->db->where('jadwalpelayanan.TglTransaksi <=', $TglAkhir);

				if ($NoTransaksi != "") {
					$this->db->where(array("absensi.NoTransaksi"=>$NoTransaksi));
				}

				if ($CabangID != "0") {
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
		public function CRUD()
		{
			$data = array('success'=>false, 'message'=>'', 'data'=>array());

			$NoTransaksi = $this->input->post('NoTransaksi');
			$TglTransaksi = date('Y-m-d h:i:s');
			$ReffJadwal = $this->input->post('ReffJadwal');
			$NIK = $this->input->post('NIK');
			$TglAbsen = date('Y-m-d h:i:s');
			$Foto = $this->input->post('image_base64');
			$Keterangan = $this->input->post('Keterangan');
			$CabangID = $this->input->post('CabangID');
			$CreatedOn = date('Y-m-d h:i:s');
			$UpdatedOn = date('Y-m-d h:i:s');
			$CreatedBy = $this->session->userdata('NamaUser');
			$UpdatedBy = $this->session->userdata('NamaUser');
			$formtype = $this->input->post('formtype');

			try {
				if ($formtype == "add") {
					$prefix = 'ABS'.$CabangID.substr(date('Ymd'),2,8);
					$lastNoTrx = $this->ModelsExecuteMaster->FindData(array('CabangID'=>$CabangID), 'absensi')->num_rows() +1;
					$NoTransaksi = $prefix.str_pad($lastNoTrx, 6, '0', STR_PAD_LEFT);
				}

				$oObject = array(
					'NoTransaksi' => $NoTransaksi,
					'TglTransaksi' => $TglTransaksi,
					'ReffJadwal' => $ReffJadwal,
					'NIK' => $NIK,
					'TglAbsen' => $TglAbsen,
					'Foto' => $Foto,
					'Keterangan' => $Keterangan,
					'CabangID' => $CabangID
				);

				if ($formtype == "add") {
					$oObject['CreatedOn'] = $CreatedOn;
					$oObject['CreatedBy'] = $CreatedBy;
					$this->db->insert('absensi',$oObject);
				}
				elseif ($formtype == "edit") {
					$oObject['UpdatedOn'] = $UpdatedOn;
					$oObject['UpdatedBy'] = $UpdatedBy;
					$this->db->update('absensi', $oObject, array('NoTransaksi'=>$NoTransaksi));
				}
				elseif ($formtype == "delete") {
					$this->db->where('NoTransaksi',$NoTransaksi);
					$this->db->delete('absensi');
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
						$data['message'] = "Data Divisi Berhasil disimpan";
					}
		        }
			} catch (\Exception $e) {
				$data['message'] = $e->message;
			}

			echo json_encode($data);
		}
	}
?>