<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class LoginFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // $req = service('request');
        // print_r();
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
                'status' => '401',
                'message' => $th->getMessage()
            ];
        } catch (\Exception $ex) {
            $response = [
                'status' => '401',
                'message' => $ex->getMessage()
            ];
        } finally {
            if ($response['status'] == '401' && $uri->getSegment(2) != 'login') {
                if (!$request->getHeader("Load-From-Ajax")) return redirect()->to(ADMIN_PATH . "/login"); // kalau tidak direquest menggunakan header "Load-From-Ajax"
                echo json_encode($response); // jika di load menggunakan header "Load-From-Ajax"
                exit;
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        echo "hehe";
    }
}
