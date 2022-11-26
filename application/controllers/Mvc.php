<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Mvc extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_khs');
    }

    public function index()
    {
        redirect('mvc/login');
    }

    public function login()
    {
        $this->load->view('login');
    }

    public function actlogin()
    {
        $username = $_POST['Username'];
        $password = $_POST['Password'];

        $cek = $this->Model_khs->cekmhs($username, $password)->num_rows();
        if ($cek > 0) {
            $data = $this->Model_khs->cekmhs($username, $password)->result();
            foreach ($data as $d) {
                $_SESSION['username'] = $d->Username;
                $_SESSION['nim'] = $d->NIM;
                $_SESSION['nama'] = $d->Nama;
            }
            redirect('input/inputkhs');
        } else {
            redirect('mvc/login');
        }
    }

    public function register()
    {
        $this->load->view('register');
    }

    public function actregister()
    {
        $data = array('NIM' => $_POST['nim'], 'Nama' => $_POST['name'], 'Username' => $_POST['username'], 'Password' => $_POST['password']);
        $cek = $this->Model_khs->regis($data);
        if ($cek) {
            redirect('mvc/login');
        } else {
            redirect('register');
        }
    }
}
