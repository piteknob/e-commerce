<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class Selected extends AuthController
{
    public function category_selected()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        // GET CATEGORY ID FROM PRODUCT
        $id = $this->request->getGet();
        $id = $id['id'];

        $query['data'] = ['product'];
        $query['select'] = [
            'product_id' => 'id',
            'product_name' => 'name',
            'product_price' => 'price',
            'product_variant_id' => 'variant_id',
            'product_variant_name' => 'variant_name',
            'product_category_id' => 'category_id',
            'product_category_name' => 'category_name',
            'product_box_id' => 'box_id',
            'product_box_value' => 'box_value',
            'product_created_at' => 'created_at',
            'product_updated_at' => 'updated_at',
        ];
        $query['where_detail'] = [
            "WHERE product_id = $id"
        ];
        $data_product = (array) generateDetailData($this->request->getVar(), $query, $this->db);
        $id_category = $data_product['data'][0]['category_id'];

        // GET DATA SELECTED
        $query_category_selected = "SELECT * FROM `category` WHERE category_id = {$id_category}";
        $data_category_selected = $this->db->query($query_category_selected)->getResultArray();

        // GET DATA NOT SELECTED
        $query_category = "SELECT * FROM `category` WHERE category_id != {$id_category}";
        $data_category= $this->db->query($query_category)->getResultArray();


        // MAKE LIST CATEGORY (SELECTED OR NOT SELECTED)

        $data = [
            'data' => [
                'category_selected' => $data_category_selected,
                'category_not_selected' => $data_category
            ]
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Category Selected', $data);
    }

    public function variant_selected()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        // GET CATEGORY ID FROM PRODUCT
        $id = $this->request->getGet();
        $id = $id['id'];

        $query['data'] = ['product'];
        $query['select'] = [
            'product_id' => 'id',
            'product_name' => 'name',
            'product_price' => 'price',
            'product_variant_id' => 'variant_id',
            'product_variant_name' => 'variant_name',
            'product_category_id' => 'category_id',
            'product_category_name' => 'category_name',
            'product_box_id' => 'box_id',
            'product_box_value' => 'box_value',
            'product_created_at' => 'created_at',
            'product_updated_at' => 'updated_at',
        ];
        $query['where_detail'] = [
            "WHERE product_id = $id"
        ];
        $data_product = (array) generateDetailData($this->request->getVar(), $query, $this->db);
        $id_variant = $data_product['data'][0]['variant_id'];

        // GET DATA SELECTED
        $query_variant_selected = "SELECT * FROM `variant` WHERE variant_id = {$id_variant}";
        $data_variant_selected = $this->db->query($query_variant_selected)->getResultArray();

        // GET DATA NOT SELECTED
        $query_variant = "SELECT * FROM `variant` WHERE variant_id != {$id_variant}";
        $data_variant = $this->db->query($query_variant)->getResultArray();

        // MAKE LIST CATEGORY (SELECTED OR NOT SELECTED)

        $data = [
            'data' => [
                'variant_selected' => $data_variant_selected,
                'variant_not_selected' => $data_variant
            ]
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Variant Selected', $data);
    }

    public function box_selected()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        // GET CATEGORY ID FROM PRODUCT
        $id = $this->request->getGet();
        $id = $id['id'];

        $query['data'] = ['product'];
        $query['select'] = [
            'product_id' => 'id',
            'product_name' => 'name',
            'product_price' => 'price',
            'product_variant_id' => 'variant_id',
            'product_variant_name' => 'variant_name',
            'product_category_id' => 'category_id',
            'product_category_name' => 'category_name',
            'product_box_id' => 'box_id',
            'product_box_value' => 'box_value',
            'product_created_at' => 'created_at',
            'product_updated_at' => 'updated_at',
        ];
        $query['where_detail'] = [
            "WHERE product_id = $id"
        ];
        $data_product = (array) generateDetailData($this->request->getVar(), $query, $this->db);
        $id_box = $data_product['data'][0]['box_id'];

        // GET DATA SELECTED
        $query_box_selected = "SELECT * FROM `box` WHERE box_id = {$id_box}";
        $data_box_selected = $this->db->query($query_box_selected)->getResultArray();

        // GET DATA NOT SELECTED
        $query_box = "SELECT * FROM `box` WHERE box_id != {$id_box}";
        $data_box = $this->db->query($query_box)->getResultArray();

        // MAKE LIST CATEGORY (SELECTED OR NOT SELECTED)

        $data = [
            'data' => [
                'box_selected' => $data_box_selected,
                'box_not_selected' => $data_box
            ]
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Box Selected', $data);
    }
}
