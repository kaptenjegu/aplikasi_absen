<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pengembalian_barang extends CI_Controller
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
        $data['judul'] = 'Form Pengembalian Barang';
        $data['page'] = 'Pengembalian_barang';
        $data['url'] = base_url('Pengembalian_barang');

        $this->db->select('*');
        $this->db->from('fma_pinjam');
        $this->db->join('fai_akun', 'fma_pinjam.id_user = fai_akun.id_akun');
        $this->db->join('fai_lokasi', 'fma_pinjam.id_lokasi = fai_lokasi.id_lokasi');
        $this->db->join('fma_barang', 'fma_pinjam.id_barang = fma_barang.id_barang');
        $this->db->where('fma_pinjam.id_user', $_SESSION['id_akun']);
        $this->db->where('fma_pinjam.status', 2);   //sedang dipinjam
        $this->db->where('fma_pinjam.tgl_delete', null);
        $this->db->order_by('fma_pinjam.tgl_pinjam', 'asc');
        $data['pinjam'] = $this->db->get()->result();

        $this->load->view('header', $data);
        $this->load->view('pengembalian_barang', $data);
        $this->load->view('footer');
    }

    private function get_data_aset($id_lokasi)
    {
        $this->db->where('id_lokasi', $id_lokasi);
        $this->db->where('tgl_delete', null);
        $data = $this->db->get('fma_barang')->result();
        return $data;
    }

    public function simpan_data()
    {
        try {
            $this->db->trans_start();
            date_default_timezone_set('Asia/Jakarta');

            $id_pinjam = $this->db->escape_str($this->input->post('id_pinjam'));

            for ($n = 0; $n < count($id_pinjam); $n++) {
                //echo $n . '<br>';
                //echo $id_barang[0] . '<br>';
                //echo $id_barang[1] . '<br>';
                //echo $this->input->post('id_' . $id_pinjam[$n]) . '<br>';
                if($this->input->post('id_' . $id_pinjam[$n]) == true){
                    $this->update_status($id_pinjam[$n]);  
                }
            }
            
            $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>Pengembalian Barang berhasil diajukan</b></center></div>');
            $this->db->trans_complete();
        } catch (\Throwable $e) {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
        }
        redirect('Pengembalian_barang');
    }

    //update status ke pending kembali
    private function update_status($id_pinjam)
    {
        $this->db->set('status', 3);    //rubah ke status pending kembali
        $this->db->where('id_pinjam', $id_pinjam);
        $this->db->update('fma_pinjam');            
    }


}
