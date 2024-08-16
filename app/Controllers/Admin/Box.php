<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class Box extends AuthController
{
    public function list()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $query['data'] = ['Box'];
        $query['select'] = [
            'Box_id' => 'id',
            'Box_Value' => 'value',
            'Box_created_at' => 'created_at',
            'Box_updated_at' => 'updated_at',
            'Box_deleted_at' => 'deleted_at',
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Box', $data);
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

        $query['data'] = ['box'];
        $query['select'] = [
            'box_id' => 'id',
            'box_value' => 'value',
            'box_created_at' => 'created_at',
            'box_updated_at' => 'updated_at'
        ];
        $query['where_detail'] = [
            "WHERE box_id = $id"
        ];

        $data = generateDetailData($this->request->getGet(), $query, $this->db);

        foreach ($data as $key => $value) {
            $data = $value[0];
        }
        $response = [
            'data' => $data
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Box', $response);
    }

    public function insert()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $post = $this->request->getPost();

        $box = htmlspecialchars_decode($post['box']);
        $sql = "INSERT INTO `box`(box_value, box_created_at, box_updated_at, box_deleted_at)
        VALUES ('{$box}', NOW(), NULL, NULL)";

        $this->db->query($sql);

        // Get Inserted Id
        $id = $this->db->insertID();

        $query['data'] = ['box'];

        $query['select'] = [
            'box_value' => 'value',
            'box_created_at' => 'created',
        ];

        $query['where_detail'] = [
            "WHERE box_id = {$id}"
        ];

        $data = generateDetailData($this->request->getPost(), $query, $this->db);

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
        $post = $this->request->getPost();
        foreach ($id as $key => $value) {
            $id = $value;
        }

        $box = htmlspecialchars($post['box']);
        $sql = "UPDATE `box` SET 
        box_value = '{$box}',
        box_updated_at = NOW()
        WHERE box_id = {$id}";

        $this->db->query($sql);

        $query['data'] = ['box'];
        $query['select'] = [
            'box_value' => 'value',
            'box_created_at' => 'created',
            'box_updated_at' => 'updated',
        ];
        $query['where_detail'] = [
            "WHERE box_id = {$id}"
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
        foreach ($id as $key => $value) {
            $id = $value;
        }

        $query['data'] = ['box'];
        $query['select'] = [
            'box_id' => 'id',
            'box_value' => 'value',
            'box_created_at' => 'created',
            'box_updated_at' => 'updated',
            'box_deleted_at' => 'deleted',
        ];
        $query['where_detail'] = [
            "WHERE box_id = {$id}"
        ];

        $data = generateDetailData($this->request->getGet(), $query, $this->db);

        $sql = "UPDATE `box` 
        SET box_updated_at = NOW(),
            box_deleted_at = NOW()
        WHERE box_id = {$id}";

        $this->db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Soft Deleted', $data);
    }

    public function deleted_box()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $query['data'] = ['box'];
        $query['select'] = [
            'box_id' => 'id',
            'box_value' => 'value',
            'box_created_at' => 'created_at',
            'box_updated_at' => 'updated_at',
        ];
        $query['where_detail'] = [
            "WHERE box_deleted_at is not null"
        ];

        $data = generateListData($this->request->getGet(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Box', $data);
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

        $sql = "UPDATE `box` 
            SET box_deleted_at = NULL,
                box_updated_at = NOW()
            WHERE box_id = {$id}";
        $this->db->query($sql);

        $query['data'] = ['box'];
        $query['select'] = [
            'box_id' => 'id',
            'box_value' => 'value',
            'box_created_at' => 'created',
            'box_updated_at' => 'updated',
        ];
        $query['where_detail'] = [
            "WHERE box_id = {$id}"
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
        foreach ($id as $key => $value) {
            $id = $value;
        }

        $query['data'] = ['box'];
        $query['select'] = [
            'box_id' => 'id',
            'box_value' => 'value',
            'box_created_at' => 'created',
            'box_updated_at' => 'updated',
            'box_deleted_at' => 'deleted',
        ];
        $query['where_detail'] = [
            "WHERE box_id = {$id}"
        ];

        $data = generateDetailData($this->request->getGet(), $query, $this->db);

        $sql = "DELETE FROM `box` WHERE box_id = {$id}";

        $this->db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Deleted', $data);
    }
}
