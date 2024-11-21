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
            'product_category_id' => 'category_id',
            'product_category_name' => 'category_name',
            'product_variant_id' => 'variant_id',
            'product_variant_name' => 'variant_name',
            'product_stock.product_stock_stock' => 'stock',
            'product_description' => 'description',
            'product_photo' => 'photo',
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

        $result = (array) generateListData($this->request->getVar(), $query, $this->db);

        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as &$data) {
                if (isset($data['photo']) && $data['photo']) {
                    $data['photo'] = 'upload/product/' . $data['photo'];
                } else {
                    $data['photo'] = 'upload/default/default_photo1.webp';
                }
            }
        }

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List produk', $result);
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

    public function bank()
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

    public function outlet()
    {
        $query['data'] = ['outlet'];
        $query['select'] = [
            'outlet_id' => 'id',
            'outlet_title' => 'title',
            'outlet_address' => 'address',
            'outlet_photo' => 'photo',
            'outlet_link' => 'link',
            'outlet_created_at' => 'created_at',
            'outlet_updated_at' => 'updated_at',
        ];
        $query['search_data'] = [
            'outlet_address',
            'outlet_title',
        ];

        $result = (array) generateListData($this->request->getVar(), $query, $this->db);

        if (isset($result['data']) && is_array($result['data'])) {
            foreach ($result['data'] as &$data) {
                if (isset($data['photo']) && $data['photo']) {
                    $data['photo'] = 'upload/outlet/' . $data['photo'];
                } else {
                    $data['photo'] = 'upload/default/default_photo1.webp';
                }
            }
        }

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List produk', $result);
    }

    public function detail_outlet()
    {


        $id = $this->request->getGet();
        $id = $id['id'];
        $query['data'] = ['outlet'];
        $query['select'] = [
            'outlet_id' => 'id',
            'outlet_title' => 'title',
            'outlet_address' => 'address',
            'outlet_photo' => 'photo',
            'outlet_link' => 'link',
            'outlet_created_at' => 'created_at',
            'outlet_updated_at' => 'updated_at',
        ];
        $query['where_detail'] = [
            "WHERE outlet_id = $id"
        ];
        $data = (array) generateDetailData($this->request->getVar(), $query, $this->db);

        if (empty($data['data'][0]['photo'])) {
            $photo = 'upload/default/default_photo.webp';
        } else {
            $photo = 'upload/photo/' . $data['data'][0]['photo'];
        }
        $data_outlet = $data['data'][0];

        $return[] = [
            'id' => $data_outlet['id'],
            'title' => $data_outlet['title'],
            'address' => $data_outlet['address'],
            'link' => $data_outlet['link'],
            'photo' => $photo,
            'created_at' => $data_outlet['created_at'],
            'updated_at' => $data_outlet['updated_at'],
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail outlet', $return);
    }
}
