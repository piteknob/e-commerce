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
            'product.product_id' => 'id',
            'product.product_name' => 'name',
            'product.product_price' => 'price',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'variant.variant_id' => 'variant_id',
            'variant.variant_name' => 'variant_name',
            'product_stock.product_stock_stock' => 'stock_stock',
            'product_stock.product_stock_in' => 'stock_in',
            'product_stock.product_stock_out' => 'stock_out',
            'product.product_description' => 'description',
            'product.product_photo' => 'photo',
            'product.product_created_at' => 'created_at',
            'product.product_updated_at' => 'updated_at',
        ];
        $query['join'] = [
            'product_stock' => 'product.product_id = product_stock.product_stock_product_id',
            'variant' => 'product.product_id = variant.variant_product_id',
        ];
        $query['search_data'] = [
            'product_name',
        ];
        $query['filter'] = [
            "product_category_name",
        ];
        $query['pagination'] = [
            'pagination' => true
        ];

        $data = (array) generateListData($this->request->getVar(), $query, $this->db);

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

}
