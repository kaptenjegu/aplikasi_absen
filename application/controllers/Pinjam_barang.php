<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Pinjam_barang extends CI_Controller
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
        $data['judul'] = 'Form Pinjam Barang';
        $data['page'] = 'Pinjam_barang';
        $data['url'] = base_url('Pinjam_barang');


        if (isset($_GET['id_lokasi'])) {
            $id_lokasi = $this->db->escape_str($_GET['id_lokasi']);
            $data['id_lokasi'] = $id_lokasi;

            $data['aset'] = $this->get_data_aset($id_lokasi);
        } else {
            $data['id_lokasi'] = '';
            $data['aset'] = [];
        }

        $this->db->where('tgl_delete', null);
        $data['lokasi'] = $this->db->get('fai_lokasi')->result();



        $this->load->view('header', $data);
        $this->load->view('pinjam_barang', $data);
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

            $id_barang = $this->input->post('id_barang');
            $id_lokasi_pakai = $this->input->post('id_lokasi_pakai');
            $qr = $this->input->post('qr');
            $kode = 2;

            //blok tulis data pinjam barang
            $q = "INSERT INTO fma_pinjam(id_pinjam,id_barang,qty_pinjam,tgl_pinjam,tgl_kembali,status,kondisi_barang_asal,kondisi_barang_kembali,id_lokasi,id_user)
                            VALUES ";

            for ($n = 0; $n < count($qr); $n++) {
                //generate query
                if ($n == count($qr) - 1) { 
                    $q .= "('" . randid() . "','" . $id_barang[$n] . "'," . $qr[$n] . " ,'" . date('Y-m-d') . "', '', 1, '" . $this->kondisi_barang($id_barang[$n]) . "', '','" . $id_lokasi_pakai . "', '" . $_SESSION['id_akun'] . "')";
                } else {
                    $q .= "('" . randid() . "','" . $id_barang[$n] ."'," . $qr[$n] . " , '" . date('Y-m-d') . "', '', 1, '" . $this->kondisi_barang($id_barang[$n]) . "', '','" . $id_lokasi_pakai . "', '" . $_SESSION['id_akun'] . "'),";
                }
            }
            
            $this->db->query($q);
            //echo $q;
            $kode = 1;
            $msg = '';
            $this->db->trans_complete();
        } catch (\Throwable $e) {
            //$this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
			//		<center><b>Caught exception: ' .  $e->getMessage() . '</b></center></div>');
            $msg = $e->getMessage();
            $kode = 2;
        }

        $data = array(
            'kode' => $kode,    //1 - sukses; 2 -  gagal
            'msg' => $msg
        );
        echo json_encode($data);
    }

    //cek kondisi barang sebelum dipinjam
    private function kondisi_barang($id_barang)
    {
        $this->db->where('id_barang', $id_barang);
        $this->db->where('tgl_delete', null);
        $data = $this->db->get('fma_barang')->first_row();
        return $data->kondisi_barang;                     
    }

    public function riwayat()
    {
        $data['judul'] = 'Riwayat Peminjaman Barang';
        $data['page'] = 'Riwayat_pinjam';
        $data['url'] = base_url('Pinjam_barang/riwayat/');

        $this->db->select('*');
        $this->db->from('fma_pinjam');
        $this->db->join('fai_akun', 'fma_pinjam.id_user = fai_akun.id_akun');
        $this->db->join('fai_lokasi', 'fma_pinjam.id_lokasi = fai_lokasi.id_lokasi');
        $this->db->join('fma_barang', 'fma_pinjam.id_barang = fma_barang.id_barang');
        $this->db->where('fma_pinjam.id_user', $_SESSION['id_akun']);
        //$this->db->where('fma_pinjam.status = 3 OR fma_pinjam.status = 4');   //pending kembali
        $this->db->where('fma_pinjam.tgl_delete', null);
        $this->db->order_by('fma_pinjam.tgl_pinjam', 'desc');
        $data['riwayat'] = $this->db->get()->result();

        $this->load->view('header', $data);
        $this->load->view('riwayat_pinjam', $data);
        $this->load->view('footer');
    }
}
