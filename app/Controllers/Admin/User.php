<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends AuthController
{
    public function list_user() // super_user
    {

        $token = $this->request->getHeaderLine('Token');
        $check['data'] = ['auth_user'];
        $check['select'] = [
            'auth_user_user_id' => 'id'
        ];
        $check['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];
        $data_auth = (array) generateDetailData($this->request->getVar(), $check, $this->db);
        $id_user = $data_auth['data']['id'];
        $user['data'] = ['user'];
        $user['select'] = [
            'user_role' => 'role'
        ];
        $user['where_detail'] = ["WHERE user_id = '{$id_user}'"];
        $role = (array) generateDetailData($this->request->getVar(), $user, $this->db);
        $role = $role['data']['role'];
        if ($role == 'super_user') {
            $query['data'] = ['user'];
            $query['select'] = [
                'user_id' => 'id',
                'user_username' => 'username',
                'user_password' => 'password',
                'user_name' => 'name',
                'user_email' => 'email',
                'user_no_handphone' => 'no_handphone',
                'user_role' => 'role',
                'user_created_at' => 'created_at',
                'user_updated_at' => 'updated_at',
            ];

            $data = (array) generateListData($this->request->getVar(), $query, $this->db);
            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List user', $data);
        } else {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Anda tidak memiliki izin untuk melakukan tindakan ini', 'Akses ditolak', ['data' => '']);

        }
    }

    public function detail() // super_user
    {

        // check role
        $token_admin = $this->request->getHeaderLine('Token');
        $query['data'] = ['auth_user'];
        $query['select'] = [
            'auth_user_user_id' => 'user_id',
        ];
        $query['where_detail'] = ["WHERE auth_user_token = '$token_admin'"];
        $id_user = (array) generateDetailData($this->request->getVar(), $query, $this->db);
        $id_user = $id_user['data']['user_id'];

        $query_role['data'] = ['user'];
        $query_role['select'] = [
            'user_role' => 'role'
        ];
        $query_role['where_detail'] = [
            "WHERE user_id = $id_user"
        ];
        $role = (array) generateDetailData($this->request->getVar(), $query_role, $this->db);
        if ($role['data']['role'] != 'super_user') {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Anda Tidak Memiliki Izin Untuk Melakukan Tindakan Ini', 'Akses Ditolak', ['data' => '']);
        }
        // get id admin
        $id = $this->request->getGet('id');
        $query_admin['data'] = ['user'];
        $query_admin['select'] = [
            'user_id' => 'id',
            'user_username' => 'username',
            'user_password' => 'password',
            'user_name' => 'name',
            'user_email' => 'email',
            'user_no_handphone' => 'no_handphone',
            'user_role' => 'role',
            'user_created_at' => 'created_at',
            'user_updated_at' => 'updated_at',
        ];
        $query_admin['where_detail'] = ["WHERE user_id = '$id'"];
        $data_admin = (array) generateDetailData($this->request->getVar(), $query_admin, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, "Detail akun", $data_admin);
    }

    public function register() // super_user
    {

        // check super user
        $token = $this->request->getHeaderLine('Token');
        $check['data'] = ['auth_user'];
        $check['select'] = [
            'auth_user_user_id' => 'user_id',
        ];
        $check['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];
        $data_check = (array) generateDetailData($this->request->getVar(), $check, $this->db);
        $id_user = $data_check['data']['user_id'];

        $check_role['data'] = ['user'];
        $check_role['select'] = ['user_role' => 'role'];
        $check_role['where_detail'] = ["WHERE user_id = $id_user"];
        $data_role = (array) generateDetailData($this->request->getVar(), $check_role, $this->db);
        $role = $data_role['data']['role'];

        if ($role == 'super_user') {
            $post = $this->request->getPost();


            // -------------------------- VALIDATION -------------------------- //
            $rules = [
                'username' => 'required|is_unique[user.user_username]',
                'password' => 'required|min_length[5]',
                'confirm' => 'required|matches[password]',
                'email' => 'required|valid_email|is_unique[user.user_email]',
                'no_handphone' => 'required|numeric|min_length[11]|is_unique[user.user_no_handphone]',
            ];

            if (!$this->validate($rules)) {
                return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error validasi', $this->validator->getErrors(), ['data' => (object) []]);
            }
            // -------------------------- END VALIDATION -------------------------- //


            $username = htmlspecialchars($post['username']);
            $password = htmlspecialchars($post['password']);
            $name = htmlspecialchars($post['name']);
            $email = htmlspecialchars($post['email']);
            $no_handphone = htmlspecialchars($post['no_handphone']);

            $insert = "INSERT INTO user VALUES('', '{$username}', '{$password}', '{$name}', '{$email}', '{$no_handphone}', 'admin', NULL, NULL,  NOW(), NULL)";

            $this->db->query($insert);
            $id = $this->db->insertID();

            $query['data'] = ['user'];
            $query['select'] = [
                'user_id' => 'id',
                'user_username' => 'username',
                'user_name' => 'name',
                'user_email' => 'email',
                'user_no_handphone' => 'no_handphone',
                'user_role' => 'role',
                'user_created_at' => 'created_at',
                'user_updated_at' => 'updated_at',
            ];
            $query['where_detail'] = [
                "WHERE user_id = '$id'"
            ];

            $data = generateDetailData($this->request->getGet(), $query, $this->db);

            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Akun berhasil ditambahkan', $data);
        } else {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Anda Tidak Memiliki Izin Untuk Melakukan Tindakan Ini', 'Akses Ditolak', ['data' => '']);
        }
    }

    public function logout()
    {

        $token = getallheaders();
        $token = $token['Token'];
        $query['data'] = ['auth_user'];
        $query['select'] = [
            'auth_user_id' => 'id',
            'auth_user_user_id' => 'user_id',
            'auth_user_username' => 'username',
            'auth_user_token' => 'token',
            'auth_user_date_login' => 'date_login',
            'auth_user_date_expired' => 'date_expired',
        ];
        $query['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];

        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        $sql = "UPDATE auth_user SET auth_user_token = null WHERE auth_user_token = '{$token}'";
        $this->db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Logout berhasil', ['data' => (object) []]);
    }

    public function update()
    {

        // -------------------------- VALIDATION -------------------------- //
        $rules = [
            'username' => 'required|is_unique[user.user_username]',
            'password' => 'required|min_length[5]',
            'email' => 'required|valid_email|is_unique[user.user_email]',
            'no_handphone' => 'required|numeric|min_length[11]|is_unique[user.user_no_handphone]',
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error validasi', $this->validator->getErrors(), ['data' => (object) []]);
        }
        // -------------------------- END VALIDATION -------------------------- //


        $token = $this->request->getHeaderLine('Token');
        $check['data'] = ['auth_user'];
        $check['select'] = [
            'auth_user_user_id' => 'id'
        ];
        $check['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];
        $data = (array) generateDetailData($this->request->getVar(), $check, $this->db);
        $id = $data['data']['id'];

        $post = $this->request->getPost();
        $username = htmlspecialchars($post['username']);
        $password = htmlspecialchars($post['password']);
        $name = htmlspecialchars($post['name']);
        $email = htmlspecialchars($post['email']);
        $no_handphone = htmlspecialchars($post['no_handphone']);

        // get data array from post
        $array1 = [
            'username' => $username,
            'password' => $password,
            'name' => $name,
            'email' => $email,
            'no_handphone' => $no_handphone,
        ];

        // get data array from database
        $data_2['data'] = ['user'];
        $data_2['select'] = [
            'user_username' => 'username',
            'user_password' => 'password',
            'user_name' => 'name',
            'user_email' => 'email',
            'user_no_handphone' => 'no_handphone',
        ];
        $data_2['where_detail'] = [
            "WHERE user_id = $id"
        ];
        $array2 = (array) generateDetailData($this->request->getVar(), $data_2, $this->db);
        $result = array_diff($array1, $array2['data']);

        // print_r($result); die;



        // VALIDATION FOR USERNAME
        if (!empty($result['username'])) {
            $username_data = $result['username'];
            $check_username['data'] = ['user'];
            $check_username['select'] = [
                'user_username' => 'username'
            ];
            $check_username['where_detail'] = [
                "WHERE user_username = '$username_data'"
            ];
            $data_check_username = (array) generateDetailData($this->request->getVar(), $check_username, $this->db);
            $data_check_username = $data_check_username['data'];
        }
        // print_r($data_check_username); die;
        if (!empty($data_check_username)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error validasi', ['username' => 'Username harus memiliki value yang unik.']);
        }
        // END VALIDATION FOR USERNAME

        // update user
        $sql = "UPDATE user 
            SET user_username = '{$username}',
                user_password = '{$password}',
                user_name = '{$name}',
                user_email = '{$email}',
                user_no_handphone = '{$no_handphone}',
                user_updated_at = NOW()
            WHERE user_id = {$id}";
        $this->db->query($sql);

        // generate TOKEN
        $auth = $username;
        $auth .= $password;

        $auth = base64_encode($auth);

        // update auth_user
        $authSql = "UPDATE auth_user 
                SET auth_user_username = '{$username}',
                    auth_user_token = '{$auth}'
    
            WHERE auth_user_user_id = '{$id}'";

        $this->db->query($authSql);


        // generate detail user
        $query['data'] = ['user'];
        $query['select'] = [
            'user_id' => 'id',
            'user_username' => 'username',
            'user_password' => 'password',
            'user_name' => 'name',
            'user_email' => 'email',
            'user_no_handphone' => 'no_handphone',
            'user_role' => 'role',
            'user_created_at' => 'created_at',
            'user_updated_at' => 'updated_at',
            'auth_user.auth_user_token' => 'token',
        ];
        $query['where_detail'] = [
            "WHERE user_id = $id"
        ];
        $query['join'] = [
            'auth_user' => 'user.user_id = auth_user.auth_user_user_id'
        ];

        $data = generateDetailData(ResponseInterface::HTTP_OK, $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Akun berhasil di update', $data);
    }

    public function update_admin() // super_user
    {

        // -------------------------- VALIDATION -------------------------- //
        $rules = [
            'username' => 'required',
            'password' => 'required|min_length[5]',
            'email' => 'required|valid_email',
            'no_handphone' => 'required|min_length[11]|numeric',
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error validasi', $this->validator->getErrors(), ['data' => (object) []]);
        }
        // -------------------------- END VALIDATION -------------------------- //

        $token = $this->request->getHeaderLine('Token');

        $query_auth['data'] = ['auth_user'];
        $query_auth['select'] = ['auth_user_user_id' => 'id'];
        $query_auth['where_detail'] = [
            "WHERE auth_user_token = '$token'"
        ];

        $id = (array) generateDetailData($this->request->getVar(), $query_auth, $this->db);
        $id = $id['data']['id'];


        $query_user['data'] = ['user'];
        $query_user['select'] = ['user_role' => 'role'];
        $query_user['where_detail'] = [
            "WHERE user_id = $id"
        ];

        $role = (array) generateDetailData($this->request->getVar(), $query_user, $this->db);
        $role = $role['data']['role'];

        if ($role != 'super_user') {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Anda Tidak Memiliki Izin Untuk Melakukan Tindakan Ini', 'Akses Ditolak', ['data' => '']);

        }


        // GET DATA POST
        $post = $this->request->getPost();
        $id = $post['id'];
        $username = $post['username'];
        $password = $post['password'];
        $name = $post['name'];
        $email = $post['email'];
        $no_handphone = $post['no_handphone'];

        // get data array from post
        $array1 = [
            'username' => $username,
            'password' => $password,
            'name' => $name,
            'email' => $email,
            'no_handphone' => $no_handphone,
        ];

        // get data array from database
        $data_2['data'] = ['user'];
        $data_2['select'] = [
            'user_username' => 'username',
            'user_password' => 'password',
            'user_name' => 'name',
            'user_email' => 'email',
            'user_no_handphone' => 'no_handphone',
        ];
        $data_2['where_detail'] = [
            "WHERE user_id = $id"
        ];
        $array2 = (array) generateDetailData($this->request->getVar(), $data_2, $this->db);
        $result = array_diff($array1, $array2['data']);


        // update user
        $sql = "UPDATE user 
            SET user_username = '{$username}',
                user_password = '{$password}',
                user_name = '{$name}',
                user_email = '{$email}',
                user_no_handphone = '{$no_handphone}',
                user_updated_at = NOW()
            WHERE user_id = {$id}";
        $this->db->query($sql);

        // generate TOKEN
        $auth = $username;
        $auth .= $password;

        $auth = base64_encode($auth);

        // check token
        $query_updated['data'] = ['auth_user'];
        $query_updated['select'] = ['auth_user_token' => 'token'];
        $query_updated['where_detail'] = ["WHERE auth_user_user_id = $id"];
        $data_updated = (array) generateDetailData($this->request->getVar(), $query_updated, $this->db);
        if (!empty($data_updated['data'])) {
            $data_updated_token = $data_updated['data']['token'];
        }
        // update auth_user
        if (empty($data_updated_token)) {
            $authSql = "UPDATE auth_user 
            SET auth_user_username = '{$username}'
            WHERE auth_user_user_id = '{$id}'";

            $this->db->query($authSql);
        } else {
            $authSql = "UPDATE auth_user 
            SET auth_user_username = '{$username}',
                auth_user_token = '{$auth}'     
            WHERE auth_user_user_id = '{$id}'";

            $this->db->query($authSql);
        }

        // generate detail user
        $query['data'] = ['user'];
        $query['select'] = [
            'user_id' => 'id',
            'user_username' => 'username',
            'user_password' => 'password',
            'user_role' => 'role',
            'user_name' => 'name',
            'user_email' => 'email',
            'user_no_handphone' => 'no_handphone',
            'user_created_at' => 'created_at',
            'user_updated_at' => 'updated_at',
        ];
        $query['where_detail'] = [
            "WHERE user_id = $id"
        ];
        $data = (array) generateDetailData(ResponseInterface::HTTP_OK, $query, $this->db);
        $data = $data['data'];

        $response = [
            'data' =>  $data,
        ];
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Akun berhasil diubah', $response);
    }

    public function delete() // super_user
    {

        $token = $this->request->getHeaderLine('Token');
        $check['data'] = ['auth_user'];
        $check['select'] = [
            'auth_user_user_id' => 'id'
        ];
        $check['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];
        $data_auth = (array) generateDetailData($this->request->getVar(), $check, $this->db);
        $id_user = $data_auth['data']['id'];
        $user['data'] = ['user'];
        $user['select'] = [
            'user_role' => 'role'
        ];
        $user['where_detail'] = ["WHERE user_id = '{$id_user}'"];
        $role = (array) generateDetailData($this->request->getVar(), $user, $this->db);
        $role = $role['data']['role'];
        if ($role == 'super_user') {

            // get ID from params
            $id = $this->request->getPost();
            $id = $id['id'];

            // generate detail data
            $query['data'] = ['user'];
            $query['select'] = [
                'user_id' => 'id',
                'user_username' => 'username',
                'user_password' => 'password',
                'user_name' => 'name',
                'user_email' => 'email',
                'user_no_handphone' => 'no_handphone',
                'user_role' => 'role',
                'user_created_at' => 'created_at',
                'user_updated_at' => 'updated_at',
            ];
            $query['where_detail'] = [
                "WHERE user_id = $id"
            ];
            $data = (array) generateDetailData($this->request->getGet(), $query, $this->db);
            if (empty($data['data'])) {
                return $this->responseFail(ResponseInterface::HTTP_GONE, 'Data sudah dihapus dari database', 'Data sudah dihapus', ['data' => (object) []]);
            }
            $data_role = $data['data']['role'];
            if ($data_role == 'super_user') {
                return $this->responseFail(ResponseInterface::HTTP_OK, 'Anda tidak bisa menghapus super user dari database', 'Tidak dapat menghapus super user', ['data' => (object) []]);
            }

            // delete data from database
            $auth['data'] = ['auth_user'];
            $auth['select'] = ['auth_user_token' => 'token'];
            $auth['where_detail'] = ["WHERE auth_user_user_id = $id"];
            $auth_data = generateDetailData($this->request->getVar(), $auth, $this->db);

            if (!empty($auth_data->data)) {
                $status = true;
            } else {
                $status = false;
            }
            if ($status == true) {
                $sql_auth = "DELETE FROM auth_user WHERE auth_user_user_id = {$id}";
                $this->db->query($sql_auth);
            }

            $sql = "DELETE FROM `user` WHERE user_id = {$id} AND user_role = 'admin'";
            $this->db->query($sql);

            // check super user


            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data berhasil diubah', $data);
        }
    }

    public function user_logged_in()
    {

        $token = $this->request->getHeaderLine('Token');

        $query['data'] = ['auth_user'];
        $query['select'] = [
            'user.user_id' => 'id',
            'auth_user_username' => 'username',
            'auth_user_date_login' => 'date_login',
            'auth_user_date_expired' => 'date_expired',
            'user.user_role' => 'role',
            'user.user_created_at' => 'created_at',
            'user.user_updated_at' => 'updated_at',
        ];
        $query['join'] = [
            'user' => 'auth_user.auth_user_user_id = user.user_id'
        ];
        $query['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];

        $data = (array) generateDetailData($this->request->getVar(), $query, $this->db);
        $data = $data['data'];
        $date = strftime("%A %d %B");
        $result = [
            'data' => [
                'user' => $data,
                'date' => $date
            ]
        ];
        return $this->responseSuccess(ResponseInterface::HTTP_OK, "Detail user login", $result);
    }
}
