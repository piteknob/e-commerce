<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Controllers\Core\DataController;
use Config\Services;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $dataController = new DataController();
        $request = \Config\Services::request();
        $token = $request->getHeaderLine('Token');
        // print_r($headers); die;
        $db = db_connect();

        // Authorization Token
        // print_r($request); die;
        if (empty($token)) {
            return $dataController->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Token not inputed', "Undefined array key Token", (object)[]);
        }
        $getResult = "SELECT auth_user_token FROM auth_user WHERE auth_user_token = '{$token}'";
        $getResult = $db->query($getResult);
        $getResult = $getResult->getResultArray();

        // check token exist
        if (empty($token)) {
            $token = (object) [];
            return Services::response()
                ->setJSON([
                    'status' => ResponseInterface::HTTP_UNAUTHORIZED,
                    'message' => 'Token Required',
                    'error' => 'Token not inputed',
                    'result' => [
                        'data' => ['inputed_token' => $token]
                    ]
                ]);
                return $dataController->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Token Required', "Token not inputed", (object)[]);

        }
        if (!$getResult) {
            return Services::response()
                ->setJSON([
                    'status' => ResponseInterface::HTTP_UNAUTHORIZED,
                    'message' => 'Invalid Token',
                    'error' => 'Token is not registered',
                    'result' => [
                        'data' => ['inputed_token' => $token]
                    ]
                ]);
        } else {
            $user = "SELECT *
                FROM auth_user
                WHERE auth_user_token = '{$token}';
                ";
            $user = $db->query($user)->getFirstRow('array');

            $payload = [
                "expired" => $user['auth_user_date_expired']
            ];

            $expired = $payload["expired"];
            $tanggal = date('Y-m-d H:i:s');

            // Check Expired Token
            if ($expired < $tanggal) {
                return Services::response()
                    ->setJSON([
                        'status' => ResponseInterface::HTTP_REQUEST_TIMEOUT,
                        'message' => 'Token Expired',
                        'error' => 'Token date expired',
                        'result' => [
                            'data' => ['inputed_token' => $token]
                        ]
                    ]);
            }
            // Add Active Time Expired Token (1 hour)
            $tanggal = date('Y-m-d H:i:s');
            $strtotime = strtotime($tanggal);
            $tambahBiling = $strtotime + (60 * 60 * 31);
            $biling = date('Y-m-d H:i:s', $tambahBiling);

            $updateExpired = "UPDATE auth_user 
                SET 
                auth_user_date_login = NOW(),
                auth_user_date_expired = '{$biling}'
                WHERE auth_user_token = '{$token}'";
            $db->query($updateExpired);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
