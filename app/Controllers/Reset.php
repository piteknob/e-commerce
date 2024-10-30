<?php

namespace App\Controllers;

use App\Controllers\Core\DataController;
use CodeIgniter\HTTP\ResponseInterface;

class Reset extends DataController
{
    public function send_otp_reset_password() // super_user
    {
        date_default_timezone_set("Asia/Jakarta");
        $no = $this->request->getVar('no_handphone');
        $token = "YZ+iWZ+so_x!_eK#aZ9c";
        $otp = mt_rand(100000, 999999);

        // Get user role
        $query_select = "SELECT user_role FROM `user` WHERE user_no_handphone = '$no'";
        $role = $this->db->query($query_select)->getResultArray();
        if (!empty($role)) {
            foreach ($role as $key => $value) {
                $role = $value;
            }
        }

        // Get detail data user
        $query_data['data'] = ['user'];
        $query_data['select'] = [
            'user_role' => 'role',
            'user_no_handphone' => 'no_handphone',
        ];
        $query_data['where_detail'] = [
            "WHERE user_no_handphone = '{$no}'"
        ];
        $data_user = (array) generateDetailData($this->request->getVar(), $query_data, $this->db);
        // print_r($role); die;

        // check user role
        if (empty($role)) {
            return $this->responseFail(ResponseInterface::HTTP_NOT_FOUND, 'Akses ditolak: Nomor handphone tidak terdaftar', 'Nomor handphone tidak terdaftar.', ['data' => (object) []]);
        }

        // insert otp to database
        $date = date("Y-m-d H:i:s");
        $currentDate = strtotime($date);
        $futureDate = $currentDate + (45 * 2);
        $formatDate = date("Y-m-d H:i:s", $futureDate);

        $query = "UPDATE user SET user_otp = $otp, user_otp_expired = '{$formatDate}' WHERE user_no_handphone = '$no'";
        $this->db->query($query);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => "'$no'",
                'message' => "ini kode otp anda: $otp",
            ),
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token"
            ),
            CURLOPT_SSL_VERIFYPEER => false, // Disable SSL verification (not recommended for production)
        ));

        curl_exec($curl);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Pesan terkirim', ['data' => (object) []]);
    }

    public function check_otp()
    {
        // -------------------------- VALIDATION -------------------------- //
        $rules = [
            'otp' => 'required|numeric',
        ];
        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error validasi', $this->validator->getErrors());
        }

        $post = $this->request->getPost();
        $otp = $post['otp'];

        // check OTP 
        $query['data'] = ['user'];
        $query['select'] = [
            'user_otp_expired' => 'expired'
        ];
        $query['where_detail'] = [
            "WHERE user_otp = '{$otp}'"
        ];
        $data_user = (array) generateDetailData($this->request->getVar(), $query, $this->db);

        // get id from OTP
        $get_id['data'] = ['user'];
        $get_id['select'] = [
            'user_id' => 'id',
            'user_name' => 'name',
            'user_otp' => 'otp'
        ];
        $get_id['where_detail'] = ["WHERE user_otp = $otp"];
        $id = (array) generateDetailData($this->request->getVar(), $get_id, $this->db);

        // check otp valid or not
        if (empty($data_user['data'])) {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Invalid OTP', 'OTP tidak valid', ['data' => (object) []]);
        }
        if (!empty($data_user['data'])) {
            foreach ($data_user['data'] as $key => $value) {
                $date = new \DateTime(date('Y-m-d H:i:s'));
                $date->add(new \DateInterval('PT7H'));
                $now = $date->format('Y-m-d H:i:s');           
                $now = strtotime($now);
                $time = strtotime($value);
            }
            if ($time < $now) {
                return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'OTP sudah kedaluwarsa', 'OTP kedaluwarsa', ['data' => (object) []]);
            }
        }
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'OTP valid', ['data' => $id['data']]);
    }

    public function reset_password() // super_user
    {
        date_default_timezone_set("Asia/Jakarta");
        $post = $this->request->getPost();


        // -------------------------- VALIDATION -------------------------- //
        $rules = [
            'password' => 'required|min_length[5]',
            'confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error validasi', $this->validator->getErrors());
        }

        $otp = $post['otp'];
        $password = $post['password'];
        $id_user = $post['id'];

        // check OTP 
        $query['data'] = ['user'];
        $query['select'] = [
            'user_id' => 'id'
        ];
        $query['where_detail'] = ["WHERE user_otp = {$otp}"];
        $data = (array) generateDetailData($this->request->getVar(), $query, $this->db);
        if (empty($data['data'])) {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Invalid OTP', 'OTP tidak valid', ['data' => (object) []]);
        }

        $query_update_user = "UPDATE `user` SET user_password = '{$password}', user_otp = null, user_otp_expired = null WHERE user_id = {$id_user}";
        $this->db->query($query_update_user);
        $query_update_token = "UPDATE auth_user SET auth_user_token = NULL WHERE auth_user_user_id = $id_user";
        $this->db->query($query_update_token);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Reset password berhasil', ['data' => (object) []]);
    }
}