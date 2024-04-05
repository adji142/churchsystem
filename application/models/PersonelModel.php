<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class PersonelModel extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
	}
	
    public function GetDetailPersonel($Nik)
    {

        $this->db->select('personel.*, divisi.NamaDivisi, jabatan.NamaJabatan, jabatan.Level');
        $this->db->from('personel');
        $this->db->join('divisi','personel.DivisiID = divisi.id', 'LEFT');
        $this->db->join('jabatan','personel.JabatanID = jabatan.id', 'LEFT');
        $this->db->where('personel.NIK', $Nik);

        $oPersonel = $this->db->get();

        return $oPersonel->row();
    }
}