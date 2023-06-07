<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Absen extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		cek_login();
	}

	public function index()
	{
		$data['judul'] = 'Absen';
		$data['page'] = 'Absen';
		$data['url'] = base_url('Absen');

		$this->db->where('id_user', $_SESSION['id_akun']);
		$this->db->where('tgl_absen', date('Y-m-d'));
		$data['absen'] = $this->db->get('fai_absen')->first_row();

		$this->load->view('header', $data);
		$this->load->view('absen', $data);
		$this->load->view('footer');
	}

	public function time_server()
	{
		echo date('H') . '<span class="blink_me">:</span>' . date('i');
	}

	//Fitur absen cuti, sakit, ijin, dll
	public function tertunda()
	{
		$data['judul'] = 'Ajukan Absen';
		$data['page'] = 'Absen_tertunda';
		$data['url'] = base_url('Absen/tertunda');

		//$this->db->where('pending' , '1');
		$this->db->where('(pending >= 4 AND pending <= 9) OR pending = 1 OR pending = 2');
		//$this->db->where('pending <= 9');
		$this->db->where('id_user', $_SESSION['id_akun']);
		$data['pending'] = $this->db->get('fai_absen')->result();

		$this->load->view('header', $data);
		$this->load->view('absen_tertunda', $data);
		$this->load->view('footer');
	}

	public function simpan_tertunda()
	{
		try {
			$this->db->trans_start();
			$tgl_absen = $this->input->post('tgl_absen');
			$pending = $this->input->post('pending');
			$keterangan = $this->input->post('keterangan');
			$id_user = $_SESSION['id_akun'];
			$n = $this->cek_dobel_data($id_user, $tgl_absen, 'masuk');

			if ($pending == 1) {
				$absen_masuk = '07:59';
			}else{
				$absen_masuk = '';
			}

			if ($n == 0) {
				$data = array(
					'id_absen' => randid(),
					'id_user' => $id_user,
					'tgl_absen' => $tgl_absen,
					'absen_masuk' 	=> $absen_masuk,
					'absen_pulang' 	=> '',
					'pending' 	=> $pending,
					'catatan_pending' 	=> $keterangan
				);
				$this->db->insert('fai_absen', $data);
				$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Sudah Disimpan</b></center></div>');
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Data Sudah Ada</b></center></div>');
			}
			$this->db->trans_complete();
		} catch (\Throwable $e) {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
		}
		redirect('Absen/tertunda');
	}

	public function masuk()
	{
		//if (($this->uri->segment(3) == $_SESSION['id_akun'])) {
		if (($this->uri->segment(3) == $_SESSION['id_akun']) and (date('H') >= 6 and date('H') <= 12)) {
			try {
				$this->db->trans_start();
				$absen_masuk = date('H:i');
				$tgl_absen = date('Y-m-d');
				$id_user = $_SESSION['id_akun'];
				$n = $this->cek_dobel_data($id_user, $tgl_absen, 'masuk');
				if ($n == 0) {
					$data = array(
						'id_absen' => randid(),
						'id_user' => $id_user,
						'tgl_absen' => $tgl_absen,
						'absen_masuk' 	=> $absen_masuk,
						'absen_pulang' 	=> '',
						'pending' 	=> 0,
						'catatan_pending' 	=> ''
					);
					$this->db->insert('fai_absen', $data);
					$msg = 'Absen Masuk berhasil';
					$jam = $absen_masuk;
				} else {
					$msg = 'Sudah absen masuk';
				}
				$this->db->trans_complete();
				$status = 200;
			} catch (\Throwable $e) {
				$status = 400;
				$msg = 'Caught exception: ' .  $e->getMessage();
			}
		} else {
			$status = 500;
			$msg = 'Diluar jam absen masuk';
		}

		$result = array(
			'status' => $status,
			'msg' => $msg,
			'jam' => $jam ?? 0
		);
		echo json_encode($result);
	}

	public function pulang()
	{
		//if (($this->uri->segment(3) == $_SESSION['id_akun'])) {
		if (($this->uri->segment(3) == $_SESSION['id_akun']) and (date('H') >= 14 and date('H') <= 21)) {
			try {
				$this->db->trans_start();
				$absen_pulang = date('H:i');
				$tgl_absen = date('Y-m-d');
				$id_user = $_SESSION['id_akun'];
				$n = $this->cek_dobel_data($id_user, $tgl_absen, 'pulang');

				if ($n == 1) {
					$this->db->set('absen_pulang', $absen_pulang);
					$this->db->where('id_user', $id_user);
					$this->db->where('tgl_absen', $tgl_absen);
					$this->db->update('fai_absen');
					$status = 200;
					$msg = 'Absen Pulang berhasil';
				} else {
					if ($this->cek_data_pulang($id_user, $tgl_absen) == 1) {
						$status = 200;
						$msg = 'Sudah absen pulang';
					} else {
						$status = 400;
						$msg = 'Belum absen masuk';
					}
				}
				$this->db->trans_complete();
				$jam = $absen_pulang;
			} catch (\Throwable $e) {
				$status = 400;
				$msg = 'Caught exception: ' .  $e->getMessage();
			}
		} else {
			$status = 500;
			$msg = 'Diluar jam absen pulang';
		}

		$result = array(
			'status' => $status,
			'msg' => $msg,
			'jam' => $jam ?? 0
		);
		echo json_encode($result);
	}

	private function cek_dobel_data($id_user, $tgl_absen,  $mode)
	{
		$this->db->where('id_user', $id_user);
		$this->db->where('tgl_absen', $tgl_absen);

		if ($mode == 'pulang') {
			$this->db->where('absen_pulang', '');
		}

		$n = $this->db->get('fai_absen')->num_rows();
		return $n;
	}

	private function cek_data_pulang($id_user, $tgl_absen)
	{
		$this->db->where('id_user', $id_user);
		$this->db->where('tgl_absen', $tgl_absen);
		$this->db->where('absen_pulang <> ""');
		$n = $this->db->get('fai_absen')->num_rows();
		return $n;
	}
}
