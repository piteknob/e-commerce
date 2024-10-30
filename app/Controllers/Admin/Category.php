<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Category extends AuthController
{
    public function list_category()
    {

        $query['data'] = ['category'];
        $query['select'] = [
            'category_id' => 'id',
            'category_name' => 'name',
            'category_created_at' => 'created_at',
            'category_updated_at' => 'updated_at',
            'category_deleted_at' => 'deleted_at',
        ];
        $query['where_detail'] = [
            "WHERE category_deleted_at IS NULL"
        ];
        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Category', $data);
    }

    public function detail()
    {

        $id = $this->request->getGet();
        $id = $id['id'];
        $query['data'] = ['category'];
        $query['select'] = [
            'category_id' => 'id',
            'category_name' => 'name',
            'category_created_at' => 'created_at',
            'category_updated_at' => 'updated_at',
        ];
        $query['where_detail'] = [
            "WHERE category_id = $id"
        ];

        $data = generateDetailData($this->request->getGet(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Category', $data);
    }

    public function insert()
    {


        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'name' => 'required|is_unique[category.category_name]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        try {
            $post = $this->request->getPost();
            $category = htmlspecialchars($post['name']);
            $db = db_connect();
            $data = [
                'category_name' => $category,
                'category_created_at' => date('Y-m-d H:i:s'),
                'category_updated_at' => NULL,
                'category_deleted_at' => NULL
            ];
            $db->table('category')->insert($data);
            $id = $db->insertID();
        } catch (Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', $e->getMessage());
        }

        // print_r($id); die;
        $query['data'] = ['category'];
        $query['select'] = [
            'category_name' => 'category',
            'category_created_at' => 'created',
        ];
        $query['where_detail'] = [
            "WHERE category_id = {$id}"
        ];

        $data = generateDetailData($this->request->getPost(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', $data);
    }

    public function update()
    {

        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'id' => 'required|numeric',
            'name' => 'required|is_unique[category.category_name]|max_length[50]'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        try {
            $post = $this->request->getPost();
            $id = htmlspecialchars($post['id']);
            $category = htmlspecialchars($post['name']);

            $data = [
                'category_name' => $category,
                'category_updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('category')
                ->where('category_id', $id)
                ->update($data);
        } catch (\Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', $e->getMessage());
        }

        $query['data'] = ['category'];
        $query['select'] = [
            'category_name' => 'category',
            'category_created_at' => 'created',
            'category_updated_at' => 'updated',
        ];
        $query['where_detail'] = [
            "WHERE category_id = {$id}"
        ];

        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Updated', $data);
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

        $query['data'] = ['category'];
        $query['select'] = [
            'category_id' => 'id',
            'category_name' => 'name',
            'category_created_at' => 'created_at',
            'category_updated_at' => 'updated_at',
            'category_deleted_at' => 'deleted_at',
        ];
        $query['where_detail'] = [
            "WHERE category_id = {$id}"
        ];

        $data = (array) generateDetailData($this->request->getGet(), $query, $this->db);
        // print_r($data['data']); die;

        if ($data['data']['deleted_at'] == null) {
            $data['data']['deleted_at'] = date('Y-m-d H:i:s');
        } else {

            $query['data'] = ['category'];
            $query['select'] = [
                'category_id' => 'id',
                'category_name' => 'name',
                'category_deleted_at' => 'deleted_at',
            ];
            $query['where_detail'] = [
                "WHERE category_id = {$id}"
            ];
            $data = (array) generateDetailData($this->request->getGet(), $query, $this->db);


            return $this->responseFail(ResponseInterface::HTTP_NOT_FOUND,  'The requested data has already been deleted', 'The data you are trying to access has been deleted and is no longer available.', $data);
        }
        $sql = "UPDATE `category` 
        SET category_updated_at = NOW(),
            category_deleted_at = NOW()
        WHERE category_id = {$id}";

        $this->db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Soft Deleted', $data);
    }

    public function deleted_category()
    {


        $query['data'] = ['category'];
        $query['select'] = [
            'category_id' => 'id',
            'category_name' => 'name',
            'category_created_at' => 'created_at',
            'category_updated_at' => 'updated_at',
            'category_deleted_at' => 'deleted_at',
        ];
        $query['where_detail'] = [
            "WHERE category_deleted_at is not null"
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

        $sql = "UPDATE `category` 
            SET category_deleted_at = NULL,
                category_updated_at = NOW()
            WHERE category_id = {$id}";
        $this->db->query($sql);

        $query['data'] = ['category'];
        $query['select'] = [
            'category_id' => 'id',
            'category_name' => 'category',
            'category_created_at' => 'created',
            'category_updated_at' => 'updated',
        ];
        $query['where_detail'] = [
            "WHERE category_id = {$id}"
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

        $query['data'] = ['category'];
        $query['select'] = [
            'category_name' => 'name',
        ];
        $query['where_detail'] = [
            "WHERE category_id = $id"
        ];
        $data = (array) generateDetailData($this->request->getVar(), $query, $this->db);

        if (empty($data['data'])) {
            return $this->responseFail(ResponseInterface::HTTP_GONE, 'Data already deleted from database', 'Data already deleted', "");
        }


        try {
            // delete category
            $db = db_connect();
            $db->table('category')
                ->where('category_id', $id)
                ->delete();
        } catch (Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', $e->getMessage());
        }

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data berhasil di hapus', ['data' => (object) []]);
    }
}
