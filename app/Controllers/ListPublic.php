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
            'product.product_category_name' => 'category_name',
            'product.product_variant_name' => 'variant_name',
            'product_stock.product_stock_stock' => 'stock',
            'product.product_description' => 'description',
            'product.product_photo' => 'photo',
        ];
        $query['join'] = [
            'product_stock' => 'product.product_id = product_stock.product_stock_product_id',
        ];
        $query['search_data'] = [
            'product_name',
            'product_variant_name'
        ];
        $query['filter'] = [
            "product_category_name",
        ];
        $query['filter_between'] = [
            'product_price'
        ];
        $query['pagination'] = [
            'pagination' => true
        ];

        $data = (array) generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List data produk', $data);
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

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List data kategori', $data);
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

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List data varian', $data);
    }
}
