<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Variant extends AuthController
{
    public function list_variant()
    {
        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_id' => 'id',
            'variant_name' => 'name',
            'variant_created_at' => 'created_at',
            'variant_updated_at' => 'updated_at',
            'variant_deleted_at' => 'deleted_at',
        ];
        $query['search_data'] = [
            'variant_name'
        ];
        $query['where_detail'] = [
            "WHERE variant_deleted_at IS NULL"
        ];
        $data = generateListData($this->request->getGet(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Variant', $data);
    }

    public function detail()
    {
        $id = $this->request->getGet();
        $id = $id['id'];

        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_id' => 'id',
            'variant_name' => 'name',
            'variant_created_at' => 'created_at',
            'variant_updated_at' => 'updated_at',
            'variant_deleted_at' => 'deleted_at',
        ];
        $query['where_detail'] = [
            "WHERE variant_id = $id"
        ];
        $query['where_detail'] = [
            "WHERE variant_deleted_at IS NULL"
        ];
        $data = generateDetailData($this->request->getVar(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Data Variant', $data);
    }

    public function insert()
    {
        $db = db_connect();

        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'name' => 'required|is_unique[variant.variant_name]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        try {
            $post = $this->request->getPost();
            $variant = $post['name'];

            $data = [
                'variant_name' => $variant,
                'variant_created_at' => date('Y-m-d H:i:s'),
                'variant_updated_at' => NULL,
                'variant_deleted_at' => NULL
            ];
            $db->table('variant')->insert($data);
            $id = $db->insertID();
        } catch (Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', $e->getMessage());
        }

        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_id' => 'id',
            'variant_name' => 'name',
            'variant_created_at' => 'created_at',
            'variant_updated_at' => 'updated_at',
            'variant_deleted_at' => 'deleted_at',
        ];
        $query['where_detail'] = [
            "WHERE variant_id = {$id}"
        ];
        $return = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', $return);
    }

    public function update()
    {
        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'id' => 'required|numeric',
            'name' => 'required|is_unique[variant.variant_name]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        try {

            $post = $this->request->getPost();
            $variant = $post['name'];
            $id = $post['id'];

            $data = [
                'variant_name' => $variant,
                'variant_updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('variant')
                ->where('variant_id', $id)
                ->update($data);
        } catch (Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', $e->getMessage());
        }


        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_id' => 'id',
            'variant_name' => 'name',
            'variant_created_at' => 'created_at',
            'variant_updated_at' => 'updated_at',
            'variant_deleted_at' => 'deleted_at',
        ];
        $query['where_detail'] = [
            "WHERE variant_id = $id"
        ];
        $return = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Updated', $return);
    }

    public function soft_delete()
    {
        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        $post = $this->request->getPost();
        $id = $post['id'];

        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_id' => 'id',
            'variant_name' => 'name',
            'variant_created_at' => 'created_at',
            'variant_updated_at' => 'updated_at',
            'variant_deleted_at' => 'deleted_at',
        ];
        $query['where_detail'] = [
            "WHERE variant_id = {$id}"
        ];

        $data = (array) generateDetailData($this->request->getGet(), $query, $this->db);
        // print_r($data['data']); die;

        if ($data['data']['deleted_at'] == null) {
            $data['data']['deleted_at'] = date('Y-m-d H:i:s');
        } else {

            $query['data'] = ['variant'];
            $query['select'] = [
                'variant_id' => 'id',
                'variant_name' => 'name',
                'variant_deleted_at' => 'deleted_at',
            ];
            $query['where_detail'] = [
                "WHERE variant_id = {$id}"
            ];
            $data = (array) generateDetailData($this->request->getGet(), $query, $this->db);


            return $this->responseFail(ResponseInterface::HTTP_NOT_FOUND,  'The requested data has already been deleted', 'The data you are trying to access has been deleted and is no longer available.', $data);
        }
        $sql = "UPDATE `variant` 
        SET variant_updated_at = NOW(),
            variant_deleted_at = NOW()
        WHERE variant_id = {$id}";

        $this->db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Soft Deleted', $data);
    }

    public function deleted_variant()
    {
        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_id' => 'id',
            'variant_name' => 'name',
            'variant_created_at' => 'created_at',
            'variant_updated_at' => 'updated_at',
            'variant_deleted_at' => 'deleted_at',
        ];
        $query['where_detail'] = [
            "WHERE variant_deleted_at is not null"
        ];

        $data = generateListData($this->request->getGet(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Value', $data);
    }

    public function restore()
    {
        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        $post = $this->request->getPost();
        $id = $post['id'];

        $sql = "UPDATE `variant` 
            SET variant_deleted_at = NULL,
                variant_updated_at = NOW()
            WHERE variant_id = {$id}";
        $this->db->query($sql);

        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_id' => 'id',
            'variant_name' => 'variant',
            'variant_created_at' => 'created',
            'variant_updated_at' => 'updated',
        ];
        $query['where_detail'] = [
            "WHERE variant_id = {$id}"
        ];

        $data = generateDetailData($this->request->getGet(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Restored', $data);
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

        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_name' => 'name',
        ];
        $query['where_detail'] = [
            "WHERE variant_id = $id"
        ];
        $data = (array) generateDetailData($this->request->getVar(), $query, $this->db);

        if (empty($data['data'])) {
            return $this->responseFail(ResponseInterface::HTTP_GONE, 'Data already deleted from database', 'Data already deleted', "");
        }


        try {
            // delete variant
            $db = db_connect();
            $db->table('variant')
                ->where('variant_id', $id)
                ->delete();
        } catch (Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', $e->getMessage());
        }

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Deleted', ['data' => (object) []]);
    }
}
