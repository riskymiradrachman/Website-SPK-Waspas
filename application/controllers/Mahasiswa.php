<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{
    public function index()
    {
        $data['title'] = 'Data Mahasiswa';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();


        $data['nim'] = $this->db->get_where('data_mahasiswa')->result_array();    //menampilkan data user menu di tabel menu manajemen, dengan menggunakan fungsi result_array(); karena data bnyak. kalau misal hnya sebaris saja menggunakan row_array();
        $data['nama'] = $this->db->get_where('data_mahasiswa')->result_array();
        $mahasiswa = $this->db->get_where('data_mahasiswa')->result_array();
        // var_dump($this->db->get_where('data_mahasiswa')->result_array());
        // die;
        $this->form_validation->set_rules('nim', 'nim', 'required');        // 'menu' disini harus sesuai dengan 'name=menu' di kotak form tambah menu
        $this->form_validation->set_rules('nama', 'nama', 'required');        // 'menu' disini harus sesuai dengan 'name=menu' di kotak form tambah menu
        $this->form_validation->set_rules('ipk', 'ipk', 'required');        // 'menu' disini harus sesuai dengan 'name=menu' di kotak form tambah menu
        $this->form_validation->set_rules('semester', 'semester', 'required');        // 'menu' disini harus sesuai dengan 'name=menu' di kotak form tambah menu
        $this->form_validation->set_rules('pekerjaan_family', 'pekerjaan_family', 'required');        // 'menu' disini harus sesuai dengan 'name=menu' di kotak form tambah menu
        $this->form_validation->set_rules('sktm', 'sktm', 'required');        // 'menu' disini harus sesuai dengan 'name=menu' di kotak form tambah menu
        $this->form_validation->set_rules('sktmb', 'sktmb', 'required');        // 'menu' disini harus sesuai dengan 'name=menu' di kotak form tambah menu
        $this->form_validation->set_rules('universitas', 'universitas', 'required');        // 'menu' disini harus sesuai dengan 'name=menu' di kotak form tambah menu

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('mahasiswa/index', compact("data", "mahasiswa"));    // biar bisa parsing(ambil) data banyak
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('data_mahasiswa', [
                'nim' => $this->input->post('nim'),
                'nama' => $this->input->post('nama'),
                'ipk' => $this->input->post('ipk'),
                'semester' => $this->input->post('semester'),
                'pekerjaan_family' => $this->input->post('pekerjaan_family'),
                'sktm' => $this->input->post('sktm'),
                'sktmb' => $this->input->post('sktmb'),
                'universitas' => $this->input->post('universitas'),

            ]);    //// untuk tambah data menu
            $this->session->set_flashdata('message', '<div class="alert 
                alert-success" role="alert">Data Mahasiswa Baru Berhasil Ditambahkan ! </div>');  //// menampilkan pesan berhasil tambah data menu

            redirect('mahasiswa');
        }
    }

    public function hapus($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('data_mahasiswa');
        $this->session->set_flashdata('message', '<div class="alert 
                alert-success" role="alert">Data Mahasiswa Berhasil Dihapus ! </div>');
        redirect('mahasiswa');
    }



    public function edit($id)
    {
        $mahasiswa = $this->db->get_where('data_mahasiswa', ['id' => $id])->result_array();
        $data['title'] = 'Edit Data Mahasiswa';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('mahasiswa/edit', compact("data", "mahasiswa"));
            $this->load->view('templates/footer');
        }
    }

    public function update($id)
    {
        $this->db->where('id', $id);
        $this->db->update('data_mahasiswa', [
            'nim' => $this->input->post('nim'),
            'nama' => $this->input->post('nama'),
            'ipk' => $this->input->post('ipk'),
            'semester' => $this->input->post('semester'),
            'pekerjaan_family' => $this->input->post('pekerjaan_family'),
            'sktm' => $this->input->post('sktm'),
            'sktmb' => $this->input->post('sktmb'),
            'universitas' => $this->input->post('universitas'),

        ]);


        $this->session->set_flashdata('message', '<div class="alert 
        alert-success" role="alert">Data Mahasiswa Berhasil Di Ubah ! </div>');  //// menampilkan pesan berhasil tambah data menu
        redirect('mahasiswa');
    }
}
