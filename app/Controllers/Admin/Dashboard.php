<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Dashboard',
            'menu' => 'dashboard',
            'roti' => [
                'Home:blank' => base_url(),
                'Dashboard:active' => '',
            ]
        ];
        return View('admin/dashboard', $data);
    }
}
