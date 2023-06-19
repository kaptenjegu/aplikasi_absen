<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Absen extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		cek_login();
		detection();
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

	public function form_cuti()
	{
		$data['n_cuti'] = $this->cek_cuti();
		if ($data['n_cuti'] > 0) {
			$data['judul'] = 'Form Cuti';
			$data['page'] = 'Absen_tertunda2';
			$data['url'] = base_url('Absen/form_cuti');

			$this->db->select('*');
			$this->db->from('fai_akun');
			$this->db->join('fai_jabatan', 'fai_jabatan.id_jabatan = fai_akun.id_jabatan');
			$this->db->where('fai_akun.id_akun', $_SESSION['id_akun']);
			$data['user'] = $this->db->get()->first_row();

			$this->db->where('id_akun<>', $_SESSION['id_akun']);
			$this->db->where('tgl_delete', null);
			$data['user_tj'] = $this->db->get('fai_akun')->result();

			$this->db->where('id_akun<>', $_SESSION['id_akun']);
			$this->db->where('role_pegawai', 2);
			$this->db->where('tgl_delete', null);
			$data['user_atasan'] = $this->db->get('fai_akun')->result();

			$this->load->view('header', $data);
			$this->load->view('form_cuti', $data);
			$this->load->view('footer');
		} else {
			$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Data Tidak Cocok</b></center></div>');
			redirect('Absen/tertunda');
		}
	}

	public function cetak_form_cuti()
	{
		$id_user = $_GET['id_user'];
		$id_user_tj = $_GET['id_user_tj'];
		$id_user_atasan = $_GET['id_user_atasan'];
		$tgl_masuk = $this->konversi_tgl(date('d/m/Y', strtotime($_GET['tgl_masuk'])));
		$keterangan = $_GET['keterangan'];
		$nama_user = $_GET['nama_user'];

		if ($this->cek_cuti() > 0) {

			$this->db->where('id_akun', $this->db->escape_str($id_user));
			$user = $this->db->get('fai_akun')->first_row();

			$this->db->where('pending', 4);
			$this->db->where('id_user', $this->db->escape_str($id_user));
			$this->db->order_by('tgl_absen', 'desc');
			$cuti_akhir = $this->db->get('fai_absen');

			$this->db->where('pending', 7);
			$this->db->where('id_user', $this->db->escape_str($id_user));
			$this->db->order_by('tgl_absen', 'asc');
			$list_cuti = $this->db->get('fai_absen')->result();
			//echo json_encode($list_cuti);exit();

			if ($cuti_akhir->num_rows() > 0) {
				$tgl_cuti_a = $cuti_akhir->first_row();
				$tgl_cuti_akhir = date('d-m-Y', strtotime($tgl_cuti_a->tgl_absen));
			} else {
				$tgl_cuti_akhir = '-';
				//$list_cuti = [];
			}

			if ($id_user_tj == "0") {
				$user_tj = '-';
				$no_tj = '-';
			} else {
				$this->db->where('id_akun', $this->db->escape_str($id_user_tj));
				$tj = $this->db->get('fai_akun')->first_row();
				$user_tj = $tj->nama_user;
				$no_tj = $tj->no_telp;
			}

			$pdf = new PDF_MC_Table('P', 'mm', 'a4'); // h ,w
			$pdf->AliasNbPages();
			$brd = 0;
			$brd2 = 1;

			$pdf->SetFont('Times', 'B', 12);
			$pdf->AddPage();

			$pdf->Image(base_url() . 'assets/images/logo_falcon.png', 15, 15, -300);
			//$pdf->Cell(190,5,'',$brd,1,'R');//(w,h,txt,border,ln,align)
			$pdf->Cell(190, 5, 'PT Falcon Prima Tehnik', $brd, 1, 'R'); //(w,h,txt,border,ln,align)
			$pdf->SetFont('Times', 'B', 8);
			$pdf->Cell(190, 3, 'Telp. 031-59178698', $brd, 1, 'R');
			$pdf->Cell(190, 3, 'E-mail. falcon@falcontehnik.com', $brd, 1, 'R');
			$pdf->Cell(190, 3, 'falcon.tehnik@gmail.com', $brd, 1, 'R');
			$pdf->Cell(190, 3, 'Website. https://falcontehnik.com', $brd, 1, 'R');
			$pdf->Cell(190, 3, 'Jl Klampis Semolo Barat X.71 / L.38 Sukolilo, Surabaya, Jawa Timur 60116', $brd, 1, 'R');
			$pdf->Cell(190, 5, '', $brd, 1, 'R');
			$pdf->Cell(190, 5, '', $brd, 1, 'R');
			$pdf->Cell(190, 5, '', $brd, 1, 'R');
			$pdf->SetLineWidth(1);
			$pdf->SetDrawColor(255, 0, 0);
			$pdf->Line(10, 35, 200, 35);	//Line(float x1, float y1, float x2, float y2)

			$pdf->SetLineWidth(0);
			$pdf->SetDrawColor(0, 0, 0);
			$pdf->SetFillColor(210, 221, 242);
			$pdf->SetFont('Times', 'B', 12);
			$pdf->Cell(190, 10, 'FORM CUTI', $brd, 1, 'C');
			$pdf->Cell(190, 5, '', $brd, 1, 'C');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Nama', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $nama_user, $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Jabatan', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $_GET['jabatan'], $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Telp yang bisa dihubungi', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $_GET['no_telp'], $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Total Pengambilan Cuti', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $_GET['total_cuti'] . ' hari', $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Tanggal Masuk', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $tgl_masuk, $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Keperluan Cuti', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $keterangan, $brd, 1, 'L');

			$pdf->Cell(190, 5, '', $brd, 1, 'C');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(170, 5, 'Tugas dan Tanggung Jawab diserahkan kepada :', $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Nama', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $user_tj, $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Telp yang bisa dihubungi', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $no_tj, $brd, 1, 'L');

			$pdf->Cell(190, 5, '', $brd, 1, 'R');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Terakhir kali cuti', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $tgl_cuti_akhir, $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Pengambilan cuti tahun 2023', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, 12 - $user->sisa_cuti, $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(60, 5, 'Sisa cuti tahun 2023', $brd, 0, 'L');
			$pdf->Cell(5, 5, ':', $brd, 0, 'C');
			$pdf->Cell(105, 5, $user->sisa_cuti, $brd, 1, 'L');

			$pdf->Cell(190, 5, '', $brd, 1, 'R');

			//tabel list tgl cuti
			$no_c = 1;
			foreach ($list_cuti as $c) {
				if ($no_c == 1) {
					$pdf->Cell(20, 5, '', $brd, 0, 'R');
					$pdf->Cell(60, 5, 'Tanggal Cuti', $brd, 0, 'L');
					$pdf->Cell(5, 5, ':', $brd, 0, 'C');
					$pdf->Cell(105, 5, $this->konversi_tgl(date('d/m/Y', strtotime($c->tgl_absen))), $brd, 1, 'L');
				} else {
					$pdf->Cell(20, 5, '', $brd, 0, 'R');
					$pdf->Cell(60, 5, '', $brd, 0, 'L');
					$pdf->Cell(5, 5, '', $brd, 0, 'C');
					$pdf->Cell(105, 5, $this->konversi_tgl(date('d/m/Y', strtotime($c->tgl_absen))), $brd, 1, 'L');
				}
				$no_c += 1;
			}



			$pdf->Cell(190, 5, '', $brd, 1, 'R');
			$pdf->Cell(190, 5, '', $brd, 1, 'R');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(170, 5, 'Surabaya, ' . $this->konversi_tgl(date('d/m/Y')), $brd, 1, 'L');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(56.6, 5, 'Pemohon', $brd2, 0, 'C');
			$pdf->Cell(56.6, 5, 'Penerima Tanggung Jawab', $brd2, 0, 'C');
			$pdf->Cell(56.6, 5, '', $brd, 1, 'C');

			$pdf->Cell(20, 35, '', $brd, 0, 'R');
			$pdf->Cell(56.6, 35, '', $brd2, 0, 'R');
			$pdf->Cell(56.6, 35, '', $brd2, 0, 'R');
			$pdf->Cell(56.6, 35, '', $brd, 1, 'R');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(56.6, 5, $nama_user, $brd2, 0, 'C');
			$pdf->Cell(56.6, 5, $user_tj, $brd2, 0, 'C');
			$pdf->Cell(56.6, 5, '', $brd, 1, 'C');

			$pdf->Cell(190, 5, '', $brd, 1, 'R');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(56.6, 5, 'HRD & SDM', $brd2, 0, 'C');
			$pdf->Cell(56.6, 5, 'Atasan Langsung', $brd2, 0, 'C');
			$pdf->Cell(56.6, 5, 'Direktur Utama', $brd2, 1, 'C');

			$pdf->Cell(20, 35, '', $brd, 0, 'R');
			$pdf->Cell(56.6, 35, '', $brd2, 0, 'C');
			$pdf->Cell(56.6, 35, '', $brd2, 0, 'C');
			$pdf->Cell(56.6, 35, '', $brd2, 1, 'C');

			$pdf->Cell(20, 5, '', $brd, 0, 'R');
			$pdf->Cell(56.6, 5, 'Kurnia Dwi Aprilina', $brd2, 0, 'C');
			$pdf->Cell(56.6, 5, $id_user_atasan, $brd2, 0, 'C');
			$pdf->Cell(56.6, 5, 'M. Riz Attanto', $brd2, 1, 'C');

			$pdf->SetFont('Times', '', 14);


			$pdf->SetLineWidth(0);
			$pdf->SetWidths(array(10, 130, 50));
			//$pdf->Row(array('No','Status','Tanggal dibuat'));

			//---------------
			$pdf->Output('D', 'Form Cuti - ' . $nama_user . '.pdf');
		} else {
			echo '<b>Error!!!!</b>';
		}
	}

	private function konversi_tgl($tgl)
	{
		$tgl = explode('/', $tgl);
		switch (intval($tgl[1])) {
			case 1:
				$bln = 'Januari';
				break;
			case 2:
				$bln = 'Februari';
				break;
			case 3:
				$bln = 'Maret';
				break;
			case 4:
				$bln = 'April';
				break;
			case 5:
				$bln = 'Mei';
				break;
			case 6:
				$bln = 'Juni';
				break;
			case 7:
				$bln = 'Juli';
				break;
			case 8:
				$bln = 'Agustus';
				break;
			case 9:
				$bln = 'September';
				break;
			case 10:
				$bln = 'Oktober';
				break;
			case 11:
				$bln = 'November';
				break;
			case 12:
				$bln = 'Desember';
				break;
			default:
				$bln = 'Kosong';
				break;
		}
		return $tgl[0] . ' ' . $bln . ' ' . $tgl[2];
	}

	private function cek_cuti()
	{
		$this->db->where('id_user', $_SESSION['id_akun']);
		$this->db->where('pending', 7);
		$cuti = $this->db->get('fai_absen')->num_rows();
		return $cuti;
	}

	//Fitur absen cuti, sakit, ijin, dll
	public function tertunda()
	{
		$data['judul'] = 'Ajukan Absen';
		$data['page'] = 'Absen_tertunda';
		$data['url'] = base_url('Absen/tertunda');

		$data['cuti'] = $this->cek_cuti();

		$this->db->where('((pending >= 4 AND pending <= 9) OR pending = 1 OR pending = 2 OR pending = 10 OR pending = 11)');		
		$this->db->where('id_user', $_SESSION['id_akun']);
		$this->db->order_by('tgl_absen', 'desc');
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
			} else {
				$absen_masuk = '';
			}

			if ($n == 0) {
				$this->db->where('id_akun', $_SESSION['id_akun']);
				$user = $this->db->get('fai_akun')->first_row();
				$sisa_cuti = $user->sisa_cuti;

				if ($sisa_cuti > 0) {	//cek sisa cuti
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

					$this->db->set('sisa_cuti', $sisa_cuti - 1);
					$this->db->where('id_akun', $_SESSION['id_akun']);
					$this->db->update('fai_akun');

					$this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Sudah Disimpan</b></center></div>');
				} else {
					$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Jatah Cuti telah habis</b></center></div>');
				}				
			} else {
				$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Data Sudah Ada</b></center></div>');
			}
			logdb($_SESSION['id_akun'], 'Absen', 'simpan tertunda', 'fai_absen || fai_akun', 'simpan data pending - ' . json_encode($data));
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
		//if (($this->uri->segment(3) == $_SESSION['id_akun']) and (((date('H') >= 6 and date('H') <= 12)))) {
		if (($this->uri->segment(3) == $_SESSION['id_akun']) and (($_SESSION['role_shift'] == '1' AND (date('H') >= 6 and date('H') <= 12)) OR $_SESSION['role_shift'] == '2')) {
			try {
				$this->db->trans_start();
				$data = [];
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
				logdb($_SESSION['id_akun'], 'Absen', 'masuk', 'fai_absen', 'simpan data masuk - ' . json_encode($data));
				$this->db->trans_complete();
				$status = 200;
			} catch (\Throwable $e) {
				logdb($_SESSION['id_akun'], 'Absen', 'masuk', 'fai_absen', 'gagal simpan data masuk - ' . json_encode($e->getMessage()));
				$status = 400;
				$msg = 'Caught exception: ' .  $e->getMessage();
			}
		} else {
			logdb($_SESSION['id_akun'], 'Absen', 'masuk', '', 'diluar jam absen masuk');
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
		if (($this->uri->segment(3) == $_SESSION['id_akun']) and (($_SESSION['role_shift'] == '1' AND (((date('H') >= 12 and date('D') == 'Sat') or (date('H') >= 14 and date('D') != 'Sat')) and date('H') <= 20)) OR $_SESSION['role_shift'] == '2')	) {
			try {
				$data = [];
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
				logdb($_SESSION['id_akun'], 'Absen', 'pulang', 'fai_absen', 'simpan data pulang - ');
				$this->db->trans_complete();
				$jam = $absen_pulang;
			} catch (\Throwable $e) {
				logdb($_SESSION['id_akun'], 'Absen', 'pulang', 'fai_absen', 'gagal simpan data pulang - ' . json_encode($e->getMessage()));
				$status = 400;
				$msg = 'Caught exception: ' .  $e->getMessage();
			}
		} else {
			logdb($_SESSION['id_akun'], 'Absen', 'pulang', '', 'Diluar jam absen pulang');
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
