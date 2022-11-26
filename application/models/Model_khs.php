<?php

class Model_khs extends CI_Model
{
    function cekmhs($username, $password)
    {
        $this->db->where('Username', $username);
        $this->db->where('Password', $password);
        return $this->db->get('mahasiswa');
    }

    function regis($data)
    {
        return $this->db->insert('mahasiswa', $data);
    }

    function getdata($nim)
    {
        $this->db->where('NIM', $nim);
        return $this->db->get('khs');
    }

    function inputkhs($namamk, $nilai)
    {
        $khs = array(
            'NIM' => $_SESSION['nim'],
            'namamk' => $namamk,
            'nilai' => $nilai
        );
        return $this->db->insert('khs', $khs);
    }

    function getid($id)
    {
        $this->db->where('Id_Nilai', $id);
        return $this->db->get('khs');
    }

    function actupdate($id, $data)
    {
        $this->db->where('Id_Nilai', $id);
        return $this->db->update('khs', $data);
    }

    function updateipk($nim, $data)
    {
        $this->db->where('NIM', $nim);
        return $this->db->update('mahasiswa', $data);
    }
}
