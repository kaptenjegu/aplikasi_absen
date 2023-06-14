<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Lembur extends CI_Controller
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
        $data['judul'] = 'Ajukan Lembur';
        $data['page'] = 'Lembur';
        $data['url'] = base_url('Lembur');

        $this->db->where('id_akun', $_SESSION['id_akun']);
        $data['lembur'] = $this->db->get('fai_lembur')->result();

        $this->load->view('header', $data);
        $this->load->view('lembur', $data);
        $this->load->view('footer');
    }

    public function simpan_lembur()
    {
        try {
            $this->db->trans_start();

            $mulai_lembur = $this->input->post('mulai_lembur');
            $selesai_lembur = $this->input->post('selesai_lembur');

            $data = array(
                'id_lembur' => randid(),
                'id_akun' => $_SESSION['id_akun'],
                'tgl_lembur' => $this->input->post('tgl_lembur'),
                'mulai_lembur'     => $mulai_lembur,
                'selesai_lembur'     => $selesai_lembur,
                'point_lembur'     => 0,
                'status_lembur'     => 0,   //pending
                'keterangan'     => $this->input->post('keterangan')
            );
            $this->db->insert('fai_lembur', $data);

            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Data Sudah Disimpan</b></center></div>');

            logdb($_SESSION['id_akun'], 'Lembur', 'simpan_lembur', 'fai_lembur', 'simpan data lembur - ' . json_encode($data));
            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Lembur');
    }
}
