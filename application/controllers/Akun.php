<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Akun extends CI_Controller
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
		$data['judul'] = 'Akun';
		$data['page'] = 'Akun';
		$data['url'] = base_url('Akun');

		$this->db->select('*');
		$this->db->from('fai_akun');
		$this->db->join('fai_jabatan', 'fai_jabatan.id_jabatan = fai_akun.id_jabatan');
		$this->db->where('fai_akun.id_akun', $_SESSION['id_akun']);
		$data['user'] = $this->db->get()->first_row();

		$this->load->view('header', $data);
		$this->load->view('akun', $data);
		$this->load->view('footer');
	}

	public function simpan()
	{
		try {
			$this->db->trans_start();
			$this->db->set('nama_user', $this->input->post('nama_user'));
			$this->db->set('no_telp', $this->input->post('no_telp'));
			$this->db->set('password', md5($this->input->post('password')));
			$this->db->where('id_akun', $this->input->post('id_user'));
			$this->db->update('fai_akun');

			logdb($_SESSION['id_akun'], 'Akun', 'simpan', 'fai_akun', 'update data user');

			$this->db->trans_complete();
			$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data User telah diupdate</b></center></div>');
		} catch (\Throwable $e) {
			//throw $th;
			logdb($_SESSION['id_akun'], 'Akun', 'simpan', 'fai_akun', 'gagal update data user - ' .  $e->getMessage() );
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() .'</b></center></div>');
		}
		redirect('Akun');
	}
}
