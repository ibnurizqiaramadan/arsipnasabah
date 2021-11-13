<?php

namespace App\Models;

use CodeIgniter\Model;

class MasterModel extends Model
{

    public $db;
    public $builder;
    public $table = '';
    public $columnOrder = [];
    public $columnSearch = [];
    public $whereData = '';
    public $selectData = '';
    public $tableJoin = [];
    public $order;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    protected function _get_datatables_query()
    {
        $this->builder = $this->db->table($this->table);

        if ($this->selectData != '') {
            $this->builder->select($this->selectData);
        }

        if (!empty($this->tableJoin)) {
            foreach ($this->tableJoin as $key => $value) {
                $this->builder->join($key, $value, 'left');
            }
        }

        $i = 0;

        foreach ($this->columnSearch as $item) {
            if (!isset($_REQUEST['search'])) {
                break;
            }
            if ($_POST['search']['value']) {

                if ($i === 0) {
                    $this->builder->groupStart();
                    $this->builder->like($item, $_POST['search']['value']);
                } else {
                    $this->builder->orLike($item, $_POST['search']['value']);
                }

                if (count($this->columnSearch) - 1 == $i)
                    $this->builder->groupEnd();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->builder->orderBy($this->columnOrder[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->builder->orderBy(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if (isset($_REQUEST['length']) && $_POST['length'] != -1)
            $this->builder->limit($_POST['length'], $_POST['start']);
        if ($this->whereData) {
            $this->builder->where($this->whereData);
        }

        $query = $this->builder->get();
        return $query->getResultArray();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        if ($this->whereData) {
            $this->builder->where($this->whereData);
        }
        $this->builder->get();
        return $this->builder->countAll();
    }

    public function count_all()
    {
        if ($this->whereData) {
            $this->builder->where($this->whereDataData);
        }
        $this->builder->from($this->table);

        return $this->builder->countAll();
    }
}
