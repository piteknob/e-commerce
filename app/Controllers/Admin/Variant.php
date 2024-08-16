<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class Variant extends AuthController
{
    public function list_variant()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_id' => 'id',
            'variant_name' => 'name',
            'variant_created_at' => 'created_at',
            'variant_updated_at' => 'updated_at',
            'variant_deleted_at' => 'deleted_at',
        ];
        $data = generateListData($this->request->getGet(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Variant', $data);
    }

    public function detail()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

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

        $data = generateDetailData($this->request->getVar(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Data Variant', $data);
    }

    public function insert()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $post = $this->request->getPost();

        $variant = $post['variant'];

        $sql = "INSERT INTO variant(variant_name, variant_created_at, variant_updated_at, variant_deleted_at)
                VALUES ('{$variant}', NOW(), NULL, NULL)";
        $result = $this->db->query($sql);
        $id = $this->db->insertID();

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
        $data = generateDetailData($this->request->getVar(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', $data);
    }

    public function update()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $id = $this->request->getGet();
        $id = $id['id'];

        $post = $this->request->getPost();

        $variant = $post['variant'];

        $sql = "UPDATE variant SET variant_name = '{$variant}' WHERE variant_id = $id";
        $this->db->query($sql);

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
        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Updated', $data);
    }

    public function soft_delete()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $id = $this->request->getGet();
        foreach ($id as $key => $variant) {
            $id = $variant;
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

        $data = generateDetailData($this->request->getGet(), $query, $this->db);

        $sql = "UPDATE `variant` 
        SET variant_updated_at = NOW(),
            variant_deleted_at = NOW()
        WHERE variant_id = {$id}";

        $this->db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Soft Deleted', $data);
    }

    public function deleted_variant()
    {

        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
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
            "WHERE variant_deleted_at is not null"
        ];

        $data = generateListData($this->request->getGet(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Value', $data);
    }

    public function restore()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $id = $this->request->getGet();

        foreach ($id as $key => $value) {
            $id = $value;
        }

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
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

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
        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        $sql = "DELETE FROM variant WHERE variant_id = $id";
        $this->db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Deleted', $data);
    }
}
