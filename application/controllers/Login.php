<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function cek_akun()
    {
        $email = $this->db->escape_str($this->input->post('email'));
        $password = $this->input->post('password');
        $this->db->where('email', $email);
        $this->db->where('password', md5($password));
        $this->db->where('tgl_delete', null);
        $user = $this->db->get('fai_akun');

        if ($user->num_rows() == 1) {
            $data = $user->first_row();

            $_SESSION['id_akun'] = $data->id_akun;
            $_SESSION['nama_user'] = $data->nama_user;
            $_SESSION['id_jabatan'] = $data->id_jabatan;
            $_SESSION['role_user'] = $data->role_user;
            $_SESSION['kunci'] = 'Login@Absen';

            redirect('Absen');
        } else {
            $this->session->set_flashdata('msg', '<div class="alert alert-danger alert-dismissable">
					<center><b>!!! Akun belum terdaftar !!!</b></center></div>');
            redirect('Login');
        }
    }

    public function keluar()
    {
        session_destroy();
        $this->session->set_flashdata('msg', '<div class="alert alert-success alert-dismissable">
					<center><b>User Logout</b></center></div>');
        redirect('Login');
    }
}
