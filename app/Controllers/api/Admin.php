<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;

class Admin extends BaseController
{
    public function __construct()
    {
        $this->req = \Config\Services::request();
        $this->masterModel = new \App\Models\MasterModel();
        $this->db = \Config\Database::connect();
    }

    private function dataTables($option)
    {
        try {
            $this->masterModel->table = $option['table'] ?? '';
            $this->masterModel->columnOrder = $option['columnOrder'] ?? [];
            $this->masterModel->columnSearch = $option['columnSearch'] ?? [];
            $this->masterModel->selectData = $option['selectData'] ?? '';
            $this->masterModel->tableJoin = $option['join'] ?? [];
            $this->masterModel->order = $option['order'] ?? ['id' => 'desc'];
            $this->masterModel->whereData = $option['whereData'] ?? [];
            $field = $option['field'] ?? [];
            $listData = $this->masterModel->get_datatables();
            // echo $this->db->getLastQuery();
            $data = [];
            foreach ($listData as $field_) {
                $row = [];
                $row['id'] = Enc($field_['id']);
                foreach ($field as $key) {
                    $row[$key] = $field_[$key];
                }
                $data[] = $row;
            }
            $draw = isset($_POST['draw']) ? $_POST['draw'] : null;
            $output = [
                'draw' => $draw,
                'recordsTotal' => $this->masterModel->count_all(),
                'recordsFiltered' => $this->masterModel->count_filtered(),
                'data' => $data,
            ];
            $result = $output;
        } catch (\Throwable $th) {
            $result = [
                'status' => 'fail',
                'message' => $th->getMessage() . ', Line : ' . $th->getLine() . ', File : ' . $th->getFile() . ', Query : ' . $this->db->getLastQuery(),
            ];
        } catch (\Exception $ex) {
            $result = [
                'status' => 'fail',
                'message' => $ex->getMessage(),
            ];
        } finally {
            echo json_encode($result);
        }
    }

    private function getRowTable($option = ['table' => '', 'select' => '', 'where' => [], 'guard' => []])
    {
        try {
            $data = $this->db->table($option['table'])->select(isset($option['select']) ? $option['select'] : '*')->where($option['where'])->get()->getRowArray();
            if (!$data) {
                throw new \Exception('no data');
            }
            $guard = ['id:hash', 'token', 'password'];
            if (!empty($option['guard'])) {
                $guard = array_merge($guard, $option['guard']);
            }
            $data = Guard($data, $guard);
            $result = [
                'status' => 'ok',
                'data' => $data,
            ];
        } catch (\Throwable $th) {
            $result = [
                'status' => 'fail',
                'message' => $th->getMessage(),
            ];
        } catch (\Exception $ex) {
            $result = [
                'status' => 'fail',
                'message' => $ex->getMessage(),
            ];
        } finally {
            echo json_encode($result);
        }
    }

    public function getDataOption($data = '')
    {
        try {
            if ($data == '') {
                throw new \Exception('no param');
            }
            $table = [
                'users' => [
                    'table' => 'users',
                    'protected' => ['id:hash', 'password', 'token'],
                ],
                'jobs' => [
                    'table' => 'jobs',
                    'protected' => ['id:hash'],
                ],
                'category' => [
                    'table' => 'category',
                    'protected' => ['id:hash'],
                ],
                'category-product' => [
                    'table' => 'category_product',
                    'protected' => ['id:hash'],
                ],
                'category-faq' => [
                    'table' => 'category_faq',
                    'protected' => ['id:hash'],
                ],
                'clients' => [
                    'table' => 'clients',
                    'protected' => ['id:hash'],
                ],
                'products' => [
                    'table' => 'products',
                    'protected' => ['id:hash'],
                ],
                'career' => [
                    'table' => 'career',
                    'protected' => ['id:hash'],
                ],
                'category-career' => [
                    'table' => 'category_career',
                    'protected' => ['id:hash'],
                ],
            ];
            if (!array_key_exists($data, $table)) {
                throw new \Exception('nothing there');
            }
            $builder = $this->db->table($table[$data]['table']);
            if (isset($_REQUEST['where'])) {
                $builder->where($_REQUEST['where']);
            }
            if (isset($_REQUEST['order'])) {
                $builder->orderBy(key($_REQUEST['order']), $_REQUEST['order'][key($_REQUEST['order'])]);
            }
            $data_ = $builder->get()->getResultArray();
            $resultData = [];
            foreach ($data_ as $rows) {
                $rows = Guard($rows, $table[$data]['protected']);
                unset($rows['created_at']);
                $resultData[] = $rows;
            }
            $result = [
                'status' => 'ok',
                'data' => $resultData,
            ];
        } catch (\Throwable $th) {
            $result = [
                'status' => 'fail',
                'message' => $th->getMessage(),
            ];
        } catch (\Exception $ex) {
            $result = [
                'status' => 'fail',
                'message' => $ex->getMessage(),
            ];
        } finally {
            echo json_encode($result);
        }
    }

    public function dataUsers()
    {
        return $this->dataTables([
            'table' => 'users',
            'selectData' => 'id, username, email, name, level, active',
            'field' => ['username', 'name', 'email', 'level', 'active'],
            'columnOrder' => [null, 'username', 'name', 'email', 'level', 'active'],
            'columnSearch' => ['username', 'name', 'email', 'level', 'active'],
            'order' => ['id' => 'desc'],
        ]);
    }

    public function dataNasabah()
    {
        return $this->dataTables([
            'table' => 'nasabah',
            'selectData' => 'id, nama, nik, norek',
            'field' => ['nama', 'nik', 'norek'],
            'columnOrder' => [null, 'nama', 'nik', 'norek'],
            'columnSearch' => ['nama', 'nik', 'norek'],
            'order' => ['id' => 'desc'],
        ]);
    }

    public function dataInputan()
    {
        return $this->dataTables([
            'table' => 'field_input',
            'selectData' => 'id, input_label, input_type, input_required',
            'field' => ['input_label', 'input_type', 'input_required'],
            'columnOrder' => [null, 'input_label', 'input_type', 'input_required'],
            'columnSearch' => ['input_label', 'input_type', 'input_required'],
            'order' => ['id' => 'desc'],
        ]);
    }

    public function getRowUsers($id)
    {
        return $this->getRowTable([
            'table' => 'users',
            'where' => [EncKey('id') => $id],
        ]);
    }

    public function getRowInputan($id)
    {
        return $this->getRowTable([
            'table' => 'field_input',
            'where' => [EncKey('id') => $id],
        ]);
    }

    public function getNasabahInput()
    {
        try {

            $inputNasabah = [];

            $dataInput = $this->db->table("field_input")->select("input_name name, input_label label, input_type type, input_required required")->get()->getResultArray();

            $inputType = ["text", "textarea", "number", "date", "time", "file"];

            foreach ($dataInput as $input) {
                array_push($inputNasabah, [
                    "label" => $input['label'],
                    "name" => $input['name'],
                    "type" => $inputType[intval($input['type'])],
                    "required" => $input['required'],
                ]);
            }

            $result = [
                'status' => 'ok',
                'data' => $inputNasabah
            ];
        } catch (\Exception $ex) {
            $result = [
                'status' => 'fail',
                'message' => $ex->getMessage,
            ];
        } catch (\Throwable $th) {
            $result = [
                'status' => 'fail',
                'message' => $ex->getMessage,
            ];
        } finally {
            echo json_encode($result);
        }
    }
}
