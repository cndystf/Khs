<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Input extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Model_khs');
        if (!isset($_SESSION['nim'])) {
            redirect('mvc/login');
        }
    }

    public function index()
    {
        redirect('mvc/login');
    }

    public function inputkhs()
    {
        $data['khs'] = $this->Model_khs->getdata($_SESSION['nim'])->result();
        $this->load->view('inputkhs', $data);
    }

    public function actinput()
    {
        $mk = $_POST['namamk'];
        $nilai = $_POST['mk'];
        $cek = $this->Model_khs->inputkhs($mk, $nilai);
        if ($cek) {
            redirect('input/inputkhs');
        }
    }

    public function actlogout()
    {
        session_unset('NIM');
        session_destroy();
        redirect('mvc/login');
    }

    public function delete()
    {
        $id = $_GET['id'];
        $this->db->where('Id_Nilai', $id);
        $this->db->delete('khs');
        redirect('input/inputkhs');
    }

    public function loadupdate()
    {
        $id = $_GET['id'];
        $data['matkul'] = $this->Model_khs->getid($id)->result();
        $this->load->view('update', $data);
    }

    public function actupdate()
    {
        if (isset($_POST['submit'])) {
            $id = $_GET['id'];
            $data = array('namamk' => $_POST['namamk'], 'nilai' => $_POST['mk']);

            $cek = $this->Model_khs->actupdate($id, $data);

            if ($cek) {
                redirect('input/inputkhs');
            }
        }
    }

    public function actcetak()
    {
        $mhs = $this->Model_khs->getdata($_SESSION['nim'])->result();
        $jml = 0;
        $i = 0;
        foreach ($mhs as $row) {
            if ($row->nilai > 85) {
                $num = 4;
                $abjad[] = 'A';
            } elseif ($row->nilai > 70 && $row->nilai < 85) {
                $num = 3;
                $abjad[] = 'B';
            } elseif ($row->nilai > 55 && $row->nilai <= 70) {
                $num = 2;
                $abjad[] = 'C';
            } elseif ($row->nilai > 45 && $row->nilai <= 55) {
                $num = 1;
                $abjad[] = 'D';
            } elseif ($row->nilai <= 45) {
                $num = 0;
                $abjad[] = 'E';
            }
            $jml = $jml + $num;
            $i = $i + 1;
        }
        $ipresult = $jml / $i;
        $data = array('IPK' => $ipresult);
        $this->Model_khs->updateipk($_SESSION['nim'], $data);
        $data['khs'] = $this->Model_khs->getdata($_SESSION['nim'])->result();
        $this->load->view('printkhs', $data);
    }