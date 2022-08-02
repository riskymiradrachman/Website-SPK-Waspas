<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');     ////form_validation adalah library dan harus disimpan di autoload

    }

    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            //validasinya suksess
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        //usernya adaaa
        if ($user) {
            //usernya aktif
            if ($user['is_active'] == 1) {
                // cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    $this->session->set_userdata($data);
                    if ($user['role_id'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert 
                    alert-danger" role="alert">Password salah ! </div>');

                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert 
                alert-danger" role="alert">Email tidak aktif ! </div>');

                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert 
            alert-danger" role="alert">Email tidak terdaftar ! </div>');

            redirect('auth');
        }
    }



    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

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
            $this->load->view('templates/auth_header');
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email', true);
            $data = [
                'name' => htmlspecialchars($this->input->post('name', 'true')),
                'email' =>  htmlspecialchars($email),
                'image' => '1.png',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 0,
                'date_created' => time()
            ];

            // siapkan token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

            $this->_sendEmail($token, 'verify');   ///buat kirim email aktivasi/verifikasi email

            $this->db->insert('user', $data);
            $this->session->set_flashdata('message', '<div class="alert 
            alert-success" role="alert">Selamat, akun anda telah dibuat. Silahkan Login</div>');

            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'iinjuliana.budiman123@gmail.com',
            'smtp_pass' => 'cpxf zlyy gaad vkew',
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n",

        ];

        $this->email->initialize($config);

        $this->email->from('iinjuliana.budiman123@gmail.com', 'Iin Juliana Budiman');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Verifikasi Akun Website SPK Beasiswa Gembira Cerdas');
            $this->email->message('Silahkan klik link ini untuk verifikasi akun anda : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Aktivasi Akun</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password Akun Website SPK Beasiswa Gembira Cerdas');
            $this->email->message('Silahkan klik link ini untuk mereset password akun anda : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }


    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();


        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {

                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert 
                    alert-success" role="alert">' . $email . ' Telah diaktivasi ! Silahkan Login</div>');

                    redirect('auth');
                } else {

                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);


                    $this->session->set_flashdata('message', '<div class="alert 
                    alert-danger" role="alert">Aktivasi Akun Gagal ! Token Kadaluarsa</div>');

                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert 
                alert-danger" role="alert">Aktivasi Akun Gagal ! Token salah</div>');

                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert 
            alert-danger" role="alert">Aktivasi Akun Gagal ! Email salah</div>');

            redirect('auth');
        }
    }


    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        $this->session->set_flashdata('message', '<div class="alert 
            alert-success" role="alert">Anda telah Logout !</div>');

        redirect('auth');
    }


    public function blocked()
    {
        $this->load->view('auth/blocked');
    }


    public function lupaPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Lupa Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/lupa-password');
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user  = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();


            if ($user) {
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()

                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                $this->session->set_flashdata('message', '<div class="alert 
                alert-success" role="alert">Silahkan cek email untuk mengubah Password !</div>');

                redirect('auth/lupaPassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert 
                alert-danger" role="alert">Email tidak terdaftar atau belum verifikasi!</div>');

                redirect('auth/lupaPassword');
            }
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->ubahPassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert 
                alert-danger" role="alert">Reset Password Gagal! Token salah</div>');

                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert 
            alert-danger" role="alert">Reset Password Gagal! Email salah</div>');

            redirect('auth');
        }
    }

    public function ubahPassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        $this->form_validation->set_rules('password1', 'Password', 'trim|required|min_length[3]|matches[password2]');
        $this->form_validation->set_rules('password2', 'Password', 'trim|required|min_length[3]|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Ubah Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/ubah-password');
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert 
            alert-success" role="alert">Password berhasil diubah, Silahkan Login</div>');

            redirect('auth');
        }
    }
}
