<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

    public function __construct()    ///fungsi pertama kali dijalankan saat controler ini di akses
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Profil'; //// harus sama nama dengan title di database agar fitur bold/aktive ketika di klik aktif
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        $data['title'] = 'Edit Profil';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');


            /// Cek jika ada Gambar yg  Akan di upload

            //$upload_image = $_FILES['image']; ///// buat cek array apakah berhasil atau data masuk
            // var_dump($upload_image);   ////////buat cek array apakah berhasil atau data masuk
            // die;

            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '6144';  /// 6144 = seukuran 6 mb
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];    /// untuk hapus gambar lama ketika gambar baru di upload
                    if ($old_image != '1.png') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }


                    $new_image = $this->upload->data('file_name');     /// untuk upload/ubah gambar profil
                    $this->db->set('image', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('user');
                }
            }


            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert 
            alert-success" role="alert">Profil anda berhasil diubah !</div>');

            redirect('user');
        }
    }


    public function ubahpassword()
    {
        $data['title'] = 'Ubah Password'; //// harus sama nama dengan title di database agar fitur bold/aktive ketika di klik aktif
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Password Saat Ini', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'Password Baru', 'required|trim|min_length[3]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Konfirmasi Password Baru', 'required|trim|min_length[3]|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/ubahpassword', $data);
            $this->load->view('templates/footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert 
                alert-danger" role="alert">Password Saat Ini Salah !</div>');

                redirect('user/ubahpassword');
            } else {
                if ($current_password = $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert 
                    alert-danger" role="alert">Password Baru tidak boleh sama dengan Password Saat Ini !</div>');

                    redirect('user/ubahpassword');
                } else {
                    /// password sudah ok/benar

                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);


                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert 
                    alert-success" role="alert">Password Berhasil Diubah !</div>');

                    redirect('user/ubahpassword');
                }
            }
        }
    }
}
