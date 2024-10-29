<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Bank extends AuthController
{
    public function list_bank()
    {

        $query['data'] = ['bank'];
        $query['select'] = [
            'bank_id' => 'id',
            'bank_name' => 'name',
            'bank_account_name' => 'account_name',
            'bank_account_number' => 'account_number',
            'bank_code' => 'code',
        ];
        $query['search_data'] = [
            'bank_name',
            'bank_account_name',

        ];
        $data = generateListData($this->request->getGet(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List data bank', $data);
    }

    public function detail()
    {

        $id = $this->request->getGet();
        $id = $id['id'];

        $query['data'] = ['bank'];
        $query['select'] = [
            'bank_id' => 'id',
            'bank_name' => 'name',
            'bank_account_name' => 'account_name',
            'bank_account_number' => 'account_number',
            'bank_code' => 'code',
            'bank_created_at' => 'created_at',
            'bank_updated_at' => 'updated_at',
        ];
        $query['where_detail'] = [
            "WHERE bank_id = $id"
        ];
        $data = generateDetailData($this->request->getVar(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail data bank', $data);
    }

    public function insert()
    {

        $db = db_connect();

        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'name' => 'required|is_unique[bank.bank_name]|max_length[50]',
            'account_name' => 'required|max_length[50]',
            'account_number' => 'required|numeric|max_length[20]|is_unique[bank.bank_account_number]',
            'code' => 'required|numeric|is_unique[bank.bank_code]'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        try {
            $post = $this->request->getPost();
            $bank = $post['name'];
            $account_name = $post['account_name'];
            $account_number = $post['account_number'];
            $code = $post['code'];

            $data = [
                'bank_name' => $bank,
                'bank_account_name' => $account_name,
                'bank_account_number' => $account_number,
                'bank_code' => $code,
                'bank_created_at' => date('Y-m-d H:i:s'),
                'bank_updated_at' => NULL
            ];
            $db->table('bank')->insert($data);
            $id = $db->insertID();
        } catch (Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', $e->getMessage());
        }

        $query['data'] = ['bank'];
        $query['select'] = [
            'bank_id' => 'id',
            'bank_name' => 'name',
            'bank_account_name' => 'account_name',
            'bank_account_number' => 'account_number',
            'bank_code' => 'code',
            'bank_created_at' => 'created_at',
            'bank_updated_at' => 'updated_at',
        ];
        $query['where_detail'] = [
            "WHERE bank_id = {$id}"
        ];
        $return = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', $return);
    }

    public function update()
    {

        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'name' => 'required|max_length[50]',
            'account_name' => 'required|max_length[50]',
            'account_number' => 'required|numeric|max_length[20]',
            'code' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        try {

            $post = $this->request->getPost();
            $id = $post['id'];
            $bank = $post['name'];
            $account_name = $post['account_name'];
            $account_number = $post['account_number'];
            $code = $post['code'];

            $data = [
                'bank_name' => $bank,
                'bank_account_name' => $account_name,
                'bank_account_number' => $account_number,
                'bank_code' => $code,
                'bank_updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('bank')
                ->where('bank_id', $id)
                ->update($data);
        } catch (Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', $e->getMessage());
        }


        $query['data'] = ['bank'];
        $query['select'] = [
            'bank_id' => 'id',
            'bank_name' => 'name',
            'bank_account_name' => 'account_name',
            'bank_account_number' => 'account_number',
            'bank_code' => 'code',
            'bank_created_at' => 'created_at',
            'bank_updated_at' => 'updated_at',
            'bank_deleted_at' => 'deleted_at',
        ];
        $query['where_detail'] = [
            "WHERE bank_id = $id"
        ];
        $return = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data successfully updated', $return);
    }

    public function delete()
    {

        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }
        $id = $this->request->getPost('id');

        $query['data'] = ['bank'];
        $query['select'] = [
            'bank_name' => 'name',
        ];
        $query['where_detail'] = [
            "WHERE bank_id = $id"
        ];
        $data = (array) generateDetailData($this->request->getVar(), $query, $this->db);

        if (empty($data['data'])) {
            return $this->responseFail(ResponseInterface::HTTP_GONE, 'Data already deleted from database', 'Data already deleted', "");
        }


        try {
            // delete bank
            $db = db_connect();
            $db->table('bank')
                ->where('bank_id', $id)
                ->delete();
        } catch (Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', $e->getMessage());
        }

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Deleted', (object) []);
    }
}
