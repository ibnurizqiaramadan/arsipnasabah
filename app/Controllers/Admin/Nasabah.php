<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Nasabah extends BaseController
{

    function __construct()
    {
        $this->req = \Config\Services::request();
        $this->table = "users";
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Nasabah',
            'menu' => 'nasabah',
            'subMenu' => 'list',
            'roti' => [
                'Home:blank' => base_url(),
                'Dashboard' => base_url(ADMIN_PATH . '/dashboard'),
                'Nasabah:active' => '',
            ],
            'table' => [
                'path' => 'nasabah',
                'id' => 'nasabah-list',
                'headerFooter' => [
                    '',
                    'Nama',
                    'NIK',
                    'Nomor Rekening',
                    'Aksi'
                ],
            ],
            'scripts' => [
                base_url('assets/js/page/nasabah.js')
            ]
        ];
        return View('admin/table/vTable', $data);
    }

    public function baru()
    {
        $data = [
            'title' => 'Nasabah Baru',
            'menu' => 'nasabah',
            'subMenu' => 'baru',
            'roti' => [
                'Home:blank' => base_url(),
                'Dashboard' => base_url(ADMIN_PATH . '/dashboard'),
                'Nasabah' => base_url(ADMIN_PATH . '/nasabah'),
                'Baru:active' => '',
            ],
            'scripts' => [
                base_url('assets/js/page/nasabah.js')
            ]
        ];
        return View('admin/nasabah/vNew', $data);
    }
}
