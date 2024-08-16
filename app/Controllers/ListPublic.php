<?php

namespace App\Controllers;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class ListPublic extends AuthController
{
    public function product()
    {
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
        'product_stock.product_stock_stock' => 'stock'
        ];
        $query['join'] = [
            'product_stock' => 'product.product_id = product_stock.product_stock_product_id'
        ];
        $query['pagination'] = [
            'pagination' => true
        ];  
        $query['search_data'] = [
            'product_name',
            'product_category_name'
        ];
        $query['filter'] = [
            "product_category_name",
            "product_value_value",
        ];


        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Product', $data);
    }

    public function category()
    {
        $query['data'] = ['category'];
        $query['select'] = [
            'category_id' => 'id',
            'category_name' => 'name',
        ];
        $query['where_detail'] = [
            "WHERE category_deleted_at is null"
        ];

        $data = generateListData($this->request->getGet(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Category', $data);
    }

    public function variant()
    {
        $query['data'] = ['variant'];
        $query['select'] = [
            'variant_id' => 'id',
            'variant_name' => 'name',
        ];
        $query['where_detail'] = [
            "WHERE variant_deleted_at is null"
        ];

        $data = generateListData($this->request->getGet(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Variant', $data);
    }

    public function box()
    {
        $query['data'] = ['box'];
        $query['select'] = [
            'box_id' => 'id',
            'box_value' => 'value',
        ];
        $query['where_detail'] = [
            "WHERE box_deleted_at is null"
        ];

        $data = generateListData($this->request->getGet(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Box', $data);
    }

}
