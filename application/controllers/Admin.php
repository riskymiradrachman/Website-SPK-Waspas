<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()    ///fungsi pertama kali dijalankan saat controler ini di akses
    {
        parent::__construct();
        is_logged_in();
    }


    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('templates/footer');
    }


    public function editakun()
    {
        $data['title'] = 'Manajemen Akun ';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['admin'] = $this->db->get_where('user')->result_array();    //menampilkan data user menu di tabel menu manajemen, dengan menggunakan fungsi result_array(); karena data bnyak. kalau misal hnya sebaris saja menggunakan row_array();


        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'Akun email ini telah terdaftar !'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[3]|matches[password2]', [
            'matches' => 'password tidak sama!',
            'min_length' => 'Password terlalu pendek!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/editakun', $data);
            $this->load->view('templates/footer');
        } else {
            $data = [
                'name' => htmlspecialchars($this->input->post('name', 'true')),
                'email' =>  htmlspecialchars($this->input->post('email', 'true')),
                'image' => '1.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert 
            alert-success" role="alert">Selamat, akun berhasil dibuat</div>');

            redirect('admin/editakun');
        }
    }

    public function edit($id)
    {
        $user = $this->db->get_where('user', ['id' => $id])->result_array();
        $data['title'] = 'Edit Data Mahasiswa';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('admin/edit', compact("data", "user"));
            $this->load->view('templates/footer');
        }
    }

    public function update($id)
    {
        $this->db->where('id', $id);
        $this->db->update('user', [
            'email' => htmlspecialchars($this->input->post('email', 'true')),
            'name' => htmlspecialchars($this->input->post('name', 'true')),
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),

        ]);


        $this->session->set_flashdata('message', '<div class="alert 
        alert-success" role="alert">Akun Mahasiswa Berhasil Di Ubah ! </div>');  //// menampilkan pesan berhasil tambah data menu
        redirect('admin/editakun');
    }


    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user');
        $this->session->set_flashdata('message', '<div class="alert 
                alert-success" role="alert">Akun Berhasil Dihapus ! </div>');
        redirect('admin/editakun');
    }
}
