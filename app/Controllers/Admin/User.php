<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class User extends AuthController
{
    public function list_user()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $token = $this->request->getHeaderLine('Token');
        $check['data'] = ['auth_user'];
        $check['select'] = [
            'auth_user_user_id' => 'id'
        ];
        $check['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];
        $data_auth = (array) generateDetailData($this->request->getVar(), $check, $this->db);
        $id_user = $data_auth['data'][0]['id'];
        $user['data'] = ['user'];
        $user['select'] = [
            'user_role' => 'role'
        ];
        $user['where_detail'] = ["WHERE user_id = '{$id_user}'"];
        $role = (array) generateDetailData($this->request->getVar(), $user, $this->db);
        $role = $role['data'][0]['role'];
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
            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List User', $data);
        } else {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, "You Don't Have Permission To Do This Action", 'Access Denied', ['data' => '']);
        }
    }

    public function register()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

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
        $id_user = $data_check['data'][0]['user_id'];

        $check_role['data'] = ['user'];
        $check_role['select'] = ['user_role' => 'role'];
        $check_role['where_detail'] = ["WHERE user_role = $id_user"];
        $data_role = (array) generateDetailData($this->request->getVar(), $check_role, $this->db);
        $role = $data_role['data'][0]['role'];

        if ($role == 'super_user') {
            $post = $this->request->getPost();

            $rules = [
                'username' => 'required|is_unique[user.user_username]',
                'password' => 'required|min_length[5]',
                'confirm' => 'required|matches[password]',
                'email' => 'required|valid_email|is_unique[user.user_email]',
                'no_handphone' => 'required|is_unique[user.user_no_handphone]',
            ];

            if (!$this->validate($rules)) {
                return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
            }

            $username = htmlspecialchars($post['username']);
            $password = htmlspecialchars($post['password']);
            $name = htmlspecialchars($post['name']);
            $email = htmlspecialchars($post['email']);
            $no_handphone = htmlspecialchars($post['no_handphone']);

            $insert = "INSERT INTO user VALUES('', '{$username}', '{$password}', '{$name}', '{$email}', '{$no_handphone}', 'admin', NOW(), NULL)";

            $this->db->query($insert);

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
                "WHERE user_username = '$username'AND user_name = '{$name}' AND user_email = '{$email}' AND user_no_handphone = '{$no_handphone}' AND user_role = 'admin'"
            ];

            $data = generateDetailData($this->request->getGet(), $query, $this->db);
            foreach ($data as $key => $value) {
                $data = $value[0];
            }
            $response = [
                'data' => $data
            ];

            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Account Successfully Registered', $response);
        } else {
            return $this->responseSuccess(ResponseInterface::HTTP_UNAUTHORIZED, "You Don't Have Permission To Do This Action", [], 'Access Denied');
        }
    }

    public function logout()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

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

        $data = ['data' => ''];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Log Out Success', $data);
    }

    public function detail()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        // GET ID ADMIN
        $token = $this->request->getHeaderLine('Token');
        $query_user['data'] = ['auth_user'];
        $query_user['select'] = ['auth_user_user_id' => 'id'];
        $query_user['where_detail'] = ["WHERE auth_user_token = '$token'"];
        $data_id_admin = (array) generateDetailData($this->request->getVar(), $query_user, $this->db);
        $data_id_admin = $data_id_admin['data'][0]['id'];
        
        // GET ADMIN ROLE
        $query_admin['data'] = ['user'];
        $query_admin['select'] = ['user_role' => 'role'];
        $query_admin['where_detail'] = ["WHERE user_id = '$data_id_admin'"];
        $data_admin = (array) generateDetailData($this->request->getVar(), $query_admin, $this->db);
        $data_admin = $data_admin['data'][0]['role'];

        if ($data_admin == 'admin') {
            return $this->responseSuccess(ResponseInterface::HTTP_OK, "You're Not Super User", ['data' => []], "Access Denied");
        } 
        

        $token = $this->request->getHeaderLine('Token');
        $query['data'] = ['auth_user'];
        $query['select'] = [
            'auth_user_user_id' => 'id'
        ];
        $query['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];
        $data_id = (array) generateDetailData($this->request->getVar(), $query, $this->db);
        $data_id = $data_id['data'][0]['id'];
        
        $detail['data'] = ['user'];
        $detail['select'] = [
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
        $detail['where_detail'] = [
            "WHERE user_id = '{$data_id}'"
        ];
        $data = generateDetailData($this->request->getVar(), $detail, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail User Account', $data);
    }

    public function update()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $token = $this->request->getHeaderLine('Token');
        $check['data'] = ['auth_user'];
        $check['select'] = [
            'auth_user_user_id' => 'id'
        ];
        $check['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];
        $data = (array) generateDetailData($this->request->getVar(), $check, $this->db);
        $id_user = $data['data'][0]['id'];

        $role['data'] = ['user'];
        $role['select'] = [
            'user_role' => 'role',
        ];
        $role['where_detail'] = [
            "WHERE user_id = '{$id_user}'"
        ];
        $role = (array) generateDetailData($this->request->getVar(), $role, $this->db);
        $role = $role['data'][0]['role'];

        if ($role == 'super_user') {
            $getID = $this->request->getGet();

            foreach ($getID as $key => $value) {
                $id = $value;
            }

            $sql = "UPDATE `user` SET
            user_username = 'break_username',
            user_email = 'break@gmail.com', 
            user_no_handphone = NULL
            WHERE user_id = '{$id}' AND user_role = 'admin'";
            $this->db->query($sql);

            $rules = [
                'username' => 'required|is_unique[user.user_username]',
                'password' => 'required|min_length[5]',
                'email' => 'required|valid_email|is_unique[user.user_email]',
                'no_handphone' => 'required|is_unique[user.user_no_handphone]',
            ];

            if (!$this->validate($rules)) {
                return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
            }

            $post = $this->request->getPost();
            $username = htmlspecialchars($post['username']);
            $password = htmlspecialchars($post['password']);
            $name = htmlspecialchars($post['name']);
            $email = htmlspecialchars($post['email']);
            $no_handphone = htmlspecialchars($post['no_handphone']);

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
            ];
            $query['where_detail'] = [
                "WHERE user_id = $id"
            ];

            $data = generateDetailData(ResponseInterface::HTTP_OK, $query, $this->db);

            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Account Successfully Updated', $data);
        } else {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, "Yout Don't Have Permission To Do This Action", 'Access Denied', ['data' => '']);
        }
    }

    public function delete()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $token = $this->request->getHeaderLine('Token');
        $check['data'] = ['auth_user'];
        $check['select'] = [
            'auth_user_user_id' => 'id'
        ];
        $check['where_detail'] = [
            "WHERE auth_user_token = '{$token}'"
        ];
        $data_auth = (array) generateDetailData($this->request->getVar(), $check, $this->db);
        $id_user = $data_auth['data'][0]['id'];
        $user['data'] = ['user'];
        $user['select'] = [
            'user_role' => 'role'
        ];
        $user['where_detail'] = ["WHERE user_id = '{$id_user}'"];
        $role = (array) generateDetailData($this->request->getVar(), $user, $this->db);
        $role = $role['data'][0]['role'];
        if ($role == 'super_user') {

            // get ID from params
            $id = $this->request->getGet();
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
            $data_role = $data['data'][0]['role'];
            if ($data_role == 'super_user') {
                return $this->responseFail(ResponseInterface::HTTP_OK, "You Can't Delete Super User");
            }

            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Deleted', $data);
        }
    }
}
