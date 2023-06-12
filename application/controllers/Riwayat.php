<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Riwayat extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		detection();
		cek_login();
	}

	public function index()
	{
		$data['judul'] = 'Riwayat Absen';
		$data['page'] = 'Riwayat';
		$data['url'] = base_url('Riwayat');
		$data['riwayat'] = [];

		$this->load->view('header', $data);
		$this->load->view('riwayat', $data);
		$this->load->view('footer');
	}

	public function data_rilis()
	{
		//$bulan = $this->uri->segment(3) ?? 5;
		$bulan = $_GET['bulan'] ?? 5;

		$this->db->where("tgl_absen >= '" . date('Y') . "-" . (int)$bulan . "-1'");
		$this->db->where("tgl_absen <='" . date('Y') . "-" . (int)$bulan . "-31'");
		$this->db->where("id_user", $_SESSION['id_akun']);

		$data['riwayat'] = $this->db->get('fai_absen')->result();
		$data['judul'] = 'Riwayat Absen';
		$data['page'] = 'Riwayat';
		$data['url'] = base_url('Riwayat/data_rilis/?bulan=' . $bulan);

		logdb($_SESSION['id_akun'], 'Riwayat', 'data_rilis', 'fai_absen', 'getdata riwayat dari range tanggal');

		$this->load->view('header', $data);
		$this->load->view('riwayat', $data);
		$this->load->view('footer');
	}
}
