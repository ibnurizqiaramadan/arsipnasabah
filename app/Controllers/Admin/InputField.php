<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class InputField extends BaseController
{

    function __construct()
    {
        $this->req = \Config\Services::request();
        $this->table = "field_input";
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $data = [
            'title' => 'Inputan',
            'menu' => 'master',
            'subMenu' => 'inputan',
            'roti' => [
                'Home:blank' => base_url(),
                'Dashboard' => base_url(ADMIN_PATH . '/dashboard'),
                'Master' => '',
                'Inputan:active' => '',
            ],
            'table' => [
                'path' => 'inputan',
                'id' => 'inputan-list',
                'headerFooter' => [
                    '',
                    'Nama Inputan',
                    'Tipe',
                    'Wajib Isi',
                    'Aksi',
                ],
            ],
            'scripts' => [
                base_url('assets/js/page/inputan.js')
            ]
        ];
        return View('admin/table/vTable', $data);
    }

    public function store()
    {
        try {
            $validate = Validate([
                'input_label' => 'required',
                'input_type' => 'required|number',
                'input_required' => 'required|number',
            ], ["input_name" => str_replace(" ", "_", strtolower(Input_("input_label")))]);

            $user = $this->db->table($this->table)->where('input_label', Input_('input_label'))->get()->getRow();
            if ($user) $validate = ValidateAdd($validate, 'input_label', 'Nama Inputan ada yang sama');
            if (!$validate['success']) throw new \Exception("Error Processing Request");
            if (!Create($this->table, $validate['data'])) throw new \Exception("Gagal memasukan data !");

            $message = [
                'status' => 'ok',
                'message' => "Berhasil memasukan data"
            ];
        } catch (\Throwable $th) {
            $message = [
                'status' => 'fail',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $message = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } finally {
            $message = array_merge($message, ['validate' => $validate]);
            echo json_encode($message);
        }
    }

    public function update()
    {
        try {
            $validate = Validate([
                'input_name' => 'required',
                'input_type' => 'required|number',
                'input_required' => 'required|number',
            ]);
            if (!$validate['success']) throw new \Exception("Error Processing Request");
            if (!Update($this->table, Guard($validate['data'], ['id']), [EncKey('id') => Input_('id')])) throw new \Exception("Tidak ada perubahan");

            $message = [
                'status' => 'ok',
                'message' => "Berhasil merubah data"
            ];
        } catch (\Throwable $th) {
            $message = [
                'status' => 'fail',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $message = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } finally {
            $message = array_merge($message, ['validate' => $validate, 'modalClose' => true]);
            echo json_encode($message);
        }
    }

    public function delete()
    {
        try {

            if (!isset($_POST['id'])) throw new \Exception("no param");

            $id = Input_('id');

            if (Delete($this->table, [EncKey('id') => $id]) == false) throw new \Exception("Gagal menghapus data");

            $message = [
                'status' => 'ok',
                'message' => 'Berhasil menghapus data'
            ];
        } catch (\Throwable $th) {
            $message = [
                'status' => 'fail',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $message = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } finally {
            echo json_encode($message);
        }
    }

    public function deleteMultiple()
    {
        try {

            if (!isset($_POST['dataId'])) throw new \Exception("no param");

            $dataId = explode(",", Input_('dataId'));

            $jmlSukses = 0;
            foreach ($dataId as $key) {
                if (Delete($this->table, [EncKey('id') => $key])) $jmlSukses++;
            }

            $message = [
                'status' => 'ok',
                'message' => "Berhasil menghapus <b>$jmlSukses</b> data dari <b>" . count($dataId) . "</b> data"
            ];
        } catch (\Throwable $th) {
            $message = [
                'status' => 'fail',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $message = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } finally {
            echo json_encode($message);
        }
    }
}
