<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SudahLogin implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        try {
            $uri = service('uri');
            $this->db = \Config\Database::connect();
            $token = $this->db->table('users')->select('token')->where('token', session('token'))->get()->getRow();
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
            if ($response['status'] == 'ok' && $uri->getSegment(2) != 'destroy') {
                echo json_encode($response);
                exit;
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
