<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'menu_id' => $menu_id,
            'role_id' => $role_id
        ]);

        if ($userAccess->num_rows() < 1) {
            var_dump($menu);
            redirect('auth/blocked');
        }
    }
}

function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $result = $ci->db->get_where('user_access_menu', [
        'role_id' => $role_id,
        'menu_id' => $menu_id
    ]);

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function format_rupiah($angka)
{
    $rupiah = number_format($angka, 0, ',', '.');
    return $rupiah;
}

function reset_rupiah($rupiah)
{
    $pecah = explode('.', $rupiah);
    $return        = implode('', $pecah);
    return  $return;
}

function day($day, $format = 'dddd')
{
    if ($format == 'dddd') {
        $fd = array('Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu', 'Minggu');
    } elseif ($format == 'ddd') {
        $fd = array('Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min');
    }

    return $fd[$day - 1];
}

function month($month, $format = 'mmmm')
{
    if ($format == 'mmmm') {
        $fm = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    } elseif ($format == 'mmm') {
        $fm = array('Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des');
    }

    return $fm[$month - 1];
}

// Outputnya : Februari
// month(2);

// Outputnya : Feb
// month(2, 'mmm');

// Outputnya : 16 Mei 2018
// date("d") . " " . month(date("n")) . " " . date("Y");

// Outputnya : Rabu, 16 Mei 2018
// day(date("N")) . ", " . date("d") . " " . month(date("n")) . " " . date("Y");

// Outputnya : Rab, 16 Mei 2018
// day(date("N"), 'ddd') . ", " . date("d") . " " . month(date("n")) . " " . date("Y");

// $tanggal = "2018-04-01"; // Set tanggal 1 April 2018

//TANGGAL 01-04-2018 (Format Full)
// date("d", strtotime($tanggal)) . " " . month(date("n", strtotime($tanggal))) . " " . date("Y", strtotime($tanggal));

// TANGGAL 01-04-2018 (Format Singkatan)
//date("d", strtotime($tanggal)) . " " . month(date("n", strtotime($tanggal)), 'mmm') . " " . date("Y", strtotime($tanggal));

function penyebut($nilai)
{
    $nilai = abs($nilai);
    $huruf = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    $temp = '';
    if ($nilai < 12) {
        $temp = ' ' . $huruf[$nilai];
    } else if ($nilai < 20) {
        $temp = penyebut($nilai - 10) . ' belas';
    } else if ($nilai < 100) {
        $temp = penyebut($nilai / 10) . ' puluh' . penyebut($nilai % 10);
    } else if ($nilai < 200) {
        $temp = ' seratus' . penyebut($nilai - 100);
    } else if ($nilai < 1000) {
        $temp = penyebut($nilai / 100) . ' ratus' . penyebut($nilai % 100);
    } else if ($nilai < 2000) {
        $temp = ' seribu' . penyebut($nilai - 1000);
    } else if ($nilai < 1000000) {
        $temp = penyebut($nilai / 1000) . ' ribu' . penyebut($nilai % 1000);
    } else if ($nilai < 1000000000) {
        $temp = penyebut($nilai / 1000000) . ' juta' . penyebut($nilai % 1000000);
    } else if ($nilai < 1000000000000) {
        $temp = penyebut($nilai / 1000000000) . ' milyar' . penyebut(fmod($nilai, 1000000000));
    } else if ($nilai < 1000000000000000) {
        $temp = penyebut($nilai / 1000000000000) . ' trilyun' . penyebut(fmod($nilai, 1000000000000));
    }
    return $temp;
}

function terbilang($nilai)
{
    if ($nilai < 0) {
        $hasil = 'minus ' . trim(penyebut($nilai));
    } else {
        $hasil = trim(penyebut($nilai));
    }
    return $hasil;
}

function monthSqlToIndo($month)
{
    // $toArr = str_replace("0", "", $month);
    $toArr = ltrim($month, '0');
    $fm = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    return $fm[$toArr - 1];
}

function selisihWaktuLogin($waktuAwal, $waktuAkhir)
{
    //menghitung selisih dengan hasil detik
    $diff    = $waktuAkhir - $waktuAwal;
    //membagi detik menjadi jam
    $jam    = floor($diff / (60 * 60));
    //membagi sisa detik setelah dikurangi $jam menjadi menit
    $menit    = $diff - $jam * (60 * 60);
    if ($jam < 1) {
        if (floor($menit / 60) == 0) {
            $waktu = number_format($diff, 0, ',', '.') . ' detik yg lalu';
        } else {
            $waktu = floor($menit / 60) . ' menit yg lalu';
        }
    } elseif ($jam < 24) {
        $waktu = date('H:i', $waktuAwal);
        // $waktu = $jam;
    } elseif ($jam > 24) {
        $waktu = date('d', $waktuAwal) . ' ' . month(date('n', $waktuAwal), 'mmm') . ' ' . date('Y', $waktuAwal) . ', ' . date('H:i', $waktuAwal);
    }
    return $waktu;
}
