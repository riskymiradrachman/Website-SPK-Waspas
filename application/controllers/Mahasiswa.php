<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mahasiswa extends CI_Controller
{
    public function __construct()    ///fungsi pertama kali dijalankan saat controler ini di akses
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Data Mahasiswa';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();


        $data['nim'] = $this->db->get_where('data_mahasiswa')->result_array();    //menampilkan data user menu di tabel menu manajemen, dengan menggunakan fungsi result_array(); karena data bnyak. kalau misal hnya sebaris saja menggunakan row_array();
        $data['nama'] = $this->db->get_where('data_mahasiswa')->result_array();
        $mahasiswa = $this->db->get_where('data_mahasiswa')->result_array();
        $data["mahasiswa"] = $mahasiswa;
        // var_dump($this->db->get_where('data_mahasiswa')->result_array());
        // die;
        $this->form_validation->set_rules('nim', 'nim', 'required');        // 'menu' disini harus sesuai dengan 'name=menu' di kotak form tambah menu
        $this->form_validation->set_rules('nama', 'nama', 'required');
        $this->form_validation->set_rules('ipk', 'ipk');
        $this->form_validation->set_rules('semester', 'semester');
        $this->form_validation->set_rules('pekerjaan_family', 'pekerjaan_family');
        $this->form_validation->set_rules('universitas', 'universitas', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('mahasiswa/index', compact("data", "mahasiswa"));    // biar bisa parsing(ambil) data banyak
            $this->load->view('templates/footer');
        } else {
            $nim = $this->input->post('nim');
            $nama = $this->input->post('nama');
            $ipk = $this->input->post('ipk');
            $semester = $this->input->post('semester');
            $pekerjaan_family = $this->input->post('pekerjaan_family');
            $universitas = $this->input->post('universitas');

            $upload_sktm = $_FILES['sktm']['name'];

            if ($upload_sktm) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '6144';  /// 6144 = seukuran 6 mb
                $config['upload_path'] = './assets/img/sktm/';


                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('sktm')) {
                    $old_sktm = $data['mahasiswa']['sktm'];    /// untuk hapus gambar lama ketika gambar baru di upload
                    if ($old_sktm != 'sktm.jpeg') {
                        unlink(FCPATH . 'assets/img/sktm/' . $old_sktm);
                    }

                    $new_image = $this->upload->data('file_name');     /// untuk upload/ubah gambar profil
                    $this->db->set('sktm', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('mahasiswa');
                }
            }

            $upload_sktm = $_FILES['sktmb']['name'];

            if ($upload_sktm) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '6144';  /// 6144 = seukuran 6 mb
                $config['upload_path'] = './assets/img/sktmb/';


                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('sktmb')) {
                    $old_sktm = $data['mahasiswa']['sktmb'];    /// untuk hapus gambar lama ketika gambar baru di upload
                    if ($old_sktm != 'sktmb.jpeg') {
                        unlink(FCPATH . 'assets/img/sktmb/' . $old_sktm);
                    }

                    $new_image = $this->upload->data('file_name');     /// untuk upload/ubah gambar profil
                    $this->db->set('sktmb', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('mahasiswa');
                }
            }

            $upload_piagam = $_FILES['piagam']['name'];

            if ($upload_piagam) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '6144';  /// 6144 = seukuran 6 mb
                $config['upload_path'] = './assets/img/piagam/';


                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('piagam')) {
                    $old_sktm = $data['mahasiswa']['piagam'];    /// untuk hapus gambar lama ketika gambar baru di upload
                    if ($old_sktm != 'sktmb.jpeg') {
                        unlink(FCPATH . 'assets/img/piagam/' . $old_sktm);
                    }

                    $new_image = $this->upload->data('file_name');     /// untuk upload/ubah gambar profil
                    $this->db->set('piagam', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('mahasiswa');
                }
            }

            $this->db->set('nim', $nim);
            $this->db->set('nama', $nama);
            $this->db->set('ipk', $ipk);
            $this->db->set('semester', $semester);
            $this->db->set('pekerjaan_family', $pekerjaan_family);
            $this->db->set('universitas', $universitas);
            $this->db->insert('data_mahasiswa');


            $this->session->set_flashdata('message', '<div class="alert 
            alert-success" role="alert">Data Mahasiswa Berhasil Di Tambahkan !</div>');

            redirect('mahasiswa');
        }
    }



    public function edit($id)
    {
        $data['title'] = 'Edit Data Mahasiswa';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $mahasiswa = $this->db->get_where('data_mahasiswa', ['id' => $id])->result_array();
        $data["mahasiswa"] = $mahasiswa[0];

        // die;
        $this->form_validation->set_rules('nama', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('mahasiswa/edit', compact("data", "mahasiswa"));
            $this->load->view('templates/footer');
        } else {
            $nim = $this->input->post('nim');
            $nama = $this->input->post('nama');
            $ipk = $this->input->post('ipk');
            $semester = $this->input->post('semester');
            $pekerjaan_family = $this->input->post('pekerjaan_family');
            $universitas = $this->input->post('universitas');

            $upload_sktm = $_FILES['sktm']['name'];

            if ($upload_sktm) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '6144';  /// 6144 = seukuran 6 mb
                $config['upload_path'] = './assets/img/sktm/';


                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('sktm')) {
                    $old_sktm = $data['mahasiswa']['sktm'];    /// untuk hapus gambar lama ketika gambar baru di upload
                    if ($old_sktm != 'sktm.jpeg') {
                        unlink(FCPATH . 'assets/img/sktm/' . $old_sktm);
                    }

                    $new_image = $this->upload->data('file_name');     /// untuk upload/ubah gambar profil
                    $this->db->set('sktm', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('mahasiswa');
                }
            }

            $upload_sktm = $_FILES['sktmb']['name'];

            if ($upload_sktm) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '6144';  /// 6144 = seukuran 6 mb
                $config['upload_path'] = './assets/img/sktmb/';


                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('sktmb')) {
                    $old_sktm = $data['mahasiswa']['sktmb'];    /// untuk hapus gambar lama ketika gambar baru di upload
                    if ($old_sktm != 'sktmb.jpeg') {
                        unlink(FCPATH . 'assets/img/sktmb/' . $old_sktm);
                    }

                    $new_image = $this->upload->data('file_name');     /// untuk upload/ubah gambar profil
                    $this->db->set('sktmb', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('mahasiswa');
                }
            }

            $upload_piagam = $_FILES['piagam']['name'];

            if ($upload_piagam) {
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']     = '6144';  /// 6144 = seukuran 6 mb
                $config['upload_path'] = './assets/img/piagam/';


                $this->load->library('upload', $config);
                $this->upload->initialize($config);

                if ($this->upload->do_upload('piagam')) {
                    $old_sktm = $data['mahasiswa']['piagam'];    /// untuk hapus gambar lama ketika gambar baru di upload
                    if ($old_sktm != 'sktmb.jpeg') {
                        unlink(FCPATH . 'assets/img/piagam/' . $old_sktm);
                    }

                    $new_image = $this->upload->data('file_name');     /// untuk upload/ubah gambar profil
                    $this->db->set('piagam', $new_image);
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">' . $this->upload->display_errors() . '</div>');
                    redirect('mahasiswa');
                }
            }

            $this->db->set('nim', $nim);
            $this->db->set('nama', $nama);
            $this->db->set('ipk', $ipk);
            $this->db->set('semester', $semester);
            $this->db->set('pekerjaan_family', $pekerjaan_family);
            $this->db->set('universitas', $universitas);
            $this->db->where('id', $id);
            $this->db->update('data_mahasiswa');


            $this->session->set_flashdata('message', '<div class="alert 
            alert-success" role="alert">Data Mahasiswa Berhasil Di Ubah !</div>');

            redirect('mahasiswa');
        }
    }




    public function hapus($id)
    {
        $mahasiswa = $this->db->get_where('data_mahasiswa', ['id' => $id])->result_array()[0];
        $this->db->where('id', $id);

        unlink(FCPATH . 'assets/img/sktm/' . $mahasiswa['sktm']);
        unlink(FCPATH . 'assets/img/sktmb/' . $mahasiswa['sktmb']);
        unlink(FCPATH . 'assets/img/piagam/' . $mahasiswa['piagam']);

        $this->db->delete('data_mahasiswa');
        $this->session->set_flashdata('message', '<div class="alert 
                alert-success" role="alert">Data Mahasiswa Berhasil Dihapus ! </div>');
        redirect('mahasiswa');
    }

    // public function update($id)
    // {

    //     $this->db->where('id', $id);
    //     $this->db->update('data_mahasiswa', [
    //         'nim' => $this->input->post('nim'),
    //         'nama' => $this->input->post('nama'),
    //         'ipk' => $this->input->post('ipk'),
    //         'semester' => $this->input->post('semester'),
    //         'pekerjaan_family' => $this->input->post('pekerjaan_family'),
    //         'sktm' => $this->input->post('sktm'),
    //         'sktmb' => $this->input->post('sktmb'),
    //         'universitas' => $this->input->post('universitas'),

    //     ]);


    //     $this->session->set_flashdata('message', '<div class="alert 
    //         alert-success" role="alert">Data Mahasiswa Berhasil Di Ubah ! </div>');  //// menampilkan pesan berhasil tambah data menu
    //     redirect('mahasiswa');
    // }
}
