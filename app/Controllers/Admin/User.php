<?php

namespace App\Controllers\Admin;

use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;
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


            // -------------------------- VALIDATION -------------------------- //
            $rules = [
                'username' => 'required|is_unique[user.user_username]',
                'password' => 'required|min_length[5]',
                'confirm' => 'required|matches[password]',
                'email' => 'required|valid_email|is_unique[user.user_email]',
                'no_handphone' => 'required|min_length[11]|is_unique[user.user_no_handphone]',
            ];

            if (!$this->validate($rules)) {
                return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
            }
            // -------------------------- END VALIDATION -------------------------- //


            $username = htmlspecialchars($post['username']);
            $password = htmlspecialchars($post['password']);
            $name = htmlspecialchars($post['name']);
            $email = htmlspecialchars($post['email']);
            $no_handphone = htmlspecialchars($post['no_handphone']);

            $insert = "INSERT INTO user VALUES('', '{$username}', '{$password}', '{$name}', '{$email}', '{$no_handphone}', 'admin', NOW(), NULL)";

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

            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Account Successfully Registered', $data);
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
        $query_admin['where_detail'] = ["WHERE user_id = '$data_id_admin'"];
        $data_admin = (array) generateDetailData($this->request->getVar(), $query_admin, $this->db);
        $data_admin_role = $data_admin['data'][0]['role'];


        if ($data_admin_role == 'admin') {
            return $this->responseSuccess(ResponseInterface::HTTP_OK, "Detail Admin Account", $data_admin,);
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

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Super User Account', $data);
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
        $id = $data['data'][0]['id'];

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
        $result = array_diff($array1, $array2['data'][0]);


        // VALIDATION
        $rules = [
            'password' => 'required|min_length[5]',
            'email' => 'required|valid_email',
            'no_handphone' => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }
        // END VALIDATION

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
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', ['username' => 'The username field must contain a unique value.']);
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

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Account Successfully Updated', $data);
    }

    public function update_admin()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $token = $this->request->getHeaderLine('Token');

        $query_auth['data'] = ['auth_user'];
        $query_auth['select'] = ['auth_user_user_id' => 'id'];
        $query_auth['where_detail'] = [
            "WHERE auth_user_token = '$token'"
        ];

        $id = (array) generateDetailData($this->request->getVar(), $query_auth, $this->db);
        $id = $id['data'][0]['id'];


        $query_user['data'] = ['user'];
        $query_user['select'] = ['user_role' => 'role'];
        $query_user['where_detail'] = [
            "WHERE user_id = $id"
        ];

        $role = (array) generateDetailData($this->request->getVar(), $query_user, $this->db);
        $role = $role['data'][0]['role'];

        if ($role != 'super_user') {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, "You Don't Have Permission To Do This Action", 'Access Denied', ['data' => '']);
        }


        // GET DATA POST
        $id = $this->request->getGet();
        $id = $id['id'];
        $post = $this->request->getPost();
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
        $result = array_diff($array1, $array2['data'][0]);

        // VALIDATION
        $rules = [
            'name' => 'required',
            'username' => 'required',
            'password' => 'required|min_length[5]',
            'email' => 'required|valid_email',
            'no_handphone' => 'required|min_length[11]',
        ];


        if (!$this->validate($rules)) {
            $data = $this->validator->getErrors();
            // print_r($data); die;
            $message = '';
            foreach ($data as $key => $value) {
                $message .= "{$value}\n ";
            }
            $data = [
                'id' => $id,
                'error' => $this->validator->getErrors()
            ];
            $response = [
                'status' => ResponseInterface::HTTP_PRECONDITION_FAILED,
                'message' => $message,
                'error' => 'Error Validation',
                'result' => [
                    'data' => $data
                ]
            ];

            return $this->response->setJSON($response);
            // return $this->responseErrorValidation(
            //     ResponseInterface::HTTP_PRECONDITION_FAILED,
            //     'Error Validation',
            //     $this->validator->getErrors()
            // );
        }
        // END VALIDATION

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
            $data = [
                'status' => ResponseInterface::HTTP_PRECONDITION_FAILED,
                'message' => "The username field must contain a unique value.\n",
                'error' => 'Error Validation',
                'result' => [
                    'data' => [
                        'id' => $id,
                        'username' => 'The username field must contain a unique value.'
                    ]
                ]
            ];
            return $this->response->setJSON($data);
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

        // check token
        $query_updated['data'] = ['auth_user'];
        $query_updated['select'] = ['auth_user_token' => 'token'];
        $query_updated['where_detail'] = ["WHERE auth_user_user_id = $id"];
        $data_updated = (array) generateDetailData($this->request->getVar(), $query_updated, $this->db);
        if (!empty($data_updated['data'])) {
            $data_updated_token = $data_updated['data'][0]['token'];
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

        $response = ['data' => [
            'user' => $data,
            'token' => $auth
        ]];
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Account Successfully Updated', $response);
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
            $data_role = $data['data'][0]['role'];
            if ($data_role == 'super_user') {
                return $this->responseFail(ResponseInterface::HTTP_OK, "You Can't Delete Super User");
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


            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Deleted', $data);
        }
    }

    public function user_logged_in()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

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
        return $this->responseSuccess(ResponseInterface::HTTP_OK, "User Detail Login", $result);
    }

    public function send_otp_reset_password()
    {
        date_default_timezone_set("Asia/Jakarta");
        $no = $this->request->getVar('no_handphone');
        $token = "YZ+iWZ+so_x!_eK#aZ9c";
        $otp = mt_rand(100000, 999999);

        // Get user role
        $query_select = "SELECT user_role FROM `user` WHERE user_no_handphone = '$no'";
        $role = $this->db->query($query_select)->getResultArray();
        if (!empty($role)) {
            foreach ($role[0] as $key => $value) {
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
        $data_user = generateDetailData($this->request->getVar(), $query_data, $this->db);

        // check user role
        if (!empty($role)) {
            if ($role != 'super_user') {
                return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Access Denied: You do not have the necessary permissions to perform this action.', 'Unauthorized: User is not a super user.', $data_user);
            }
        } else {
            return $this->responseFail(ResponseInterface::HTTP_NOT_FOUND, 'Access Denied: The provided no handphone is not registered.', 'No handphone not found in the system.');
        }

        // insert otp to database
        $date = date("Y-m-d H:i:s");
        $currentDate = strtotime($date);
        $futureDate = $currentDate + (60 * 5);
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

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Message sent', $data_user);
    }

    public function reset_password()
    {
        date_default_timezone_set("Asia/Jakarta");
        $post = $this->request->getPost();

        // -------------------------- VALIDATION -------------------------- //
        $rules = [
            'otp' => 'required|numeric',
            'password' => 'required|min_length[5]',
            'confirm' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        // get data from post
        $otp = $post['otp'];
        $password = $post['password'];

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
        ];
        $get_id['where_detail'] = ["WHERE user_otp = $otp"];
        $id = (array) generateDetailData($this->request->getVar(), $get_id, $this->db);
        if(!empty($id['data'])) {
            foreach ($id['data'][0] as $key => $value) {
                $id_user = $value;
            }
        }

        // check otp valid or not
        if (empty($data_user['data'])) {
            return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'Invalid OTP', 'The OTP provided is incorrect.');
        } 
        if (!empty($data_user['data'])) {
            foreach ($data_user['data'][0] as $key => $value) {
                $expired = strtotime($value);
            }
            if ($expired < strtotime(date('Y-m-d H:i:s'))) {
                return $this->responseFail(ResponseInterface::HTTP_UNAUTHORIZED, 'The OTP has expired. Please request a new OTP and try again', 'OTP expired');
            }
        }
        
        $query_update_user = "UPDATE `user` SET user_password = '{$password}', user_otp = null, user_otp_expired = null WHERE user_otp = $otp";
        $this->db->query($query_update_user);
        $query_update_token = "UPDATE auth_user SET auth_user_token = NULL WHERE auth_user_user_id = $id_user";
        $this->db->query($query_update_token);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Password reset success');    

    }
}
