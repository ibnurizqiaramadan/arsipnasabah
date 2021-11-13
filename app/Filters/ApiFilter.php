<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class ApiFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            $this->req = \Config\Services::request();
            $this->db = \Config\Database::connect();
            $token = $this->db->table('users')->select('token')->where('token', $this->req->getPost('_token'))->get()->getRow();
            if (!$token) throw new \Exception("Not Authorized");
            $response = [
                'status' => 'ok',
                'message' => 'ok'
            ];
        } catch (\Throwable $th) {
            $response = [
                'status' => 'fail',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $response = [
                'status' => 'fail',
                'message' => $ex->getMessage()
            ];
        } finally {
            if ($response['status'] == 'fail') {
                echo json_encode($response);
                exit;
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
