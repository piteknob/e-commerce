<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class Stock extends AuthController
{
    public function list_stock()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $query['data'] = ['product'];
        $query['select'] = [
            'product_stock.product_stock_id' => 'id',
            'product.product_name' => 'name',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'variant.variant_id' => 'variant_id',
            'variant.variant_name' => 'variant_name',
            'product_stock.product_stock_stock' => 'stock_stock',
            'product_stock.product_stock_in' => 'stock_in',
            'product_stock.product_stock_out' => 'stock_out',
        ];
        $query['join'] = [
            'product_stock' => 'product.product_id = product_stock.product_stock_product_id',
            'variant' => 'product.product_id = variant.variant_product_id',
        ];
        $query['pagination'] = [
            'pagination' => true
        ];

        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Stock', $data);
    }

    public function detail_stock()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }
        $id = $this->request->getVar('id');

        $query['data'] = ['product'];
        $query['select'] = [
            'product_stock.product_stock_id' => 'id',
            'product.product_name' => 'name',
            'product.product_price' => 'price',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'variant.variant_id' => 'variant_id',
            'variant.variant_name' => 'variant_name',
            'product_stock.product_stock_stock' => 'stock_stock',
            'product_stock.product_stock_in' => 'stock_in',
            'product_stock.product_stock_out' => 'stock_out',

        ];
        $query['join'] = [
            'product_stock' => 'product.product_id = product_stock.product_stock_product_id',
            'variant' => 'product.product_id = variant.variant_product_id',
        ];
        $query['where_detail'] = [
            "WHERE product_stock_id = $id"
        ];

        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Data', $data);
    }

    public function reduce()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }
        $id = $this->request->getVar();
        $post = $this->request->getPost();
        $id = $id['id'];

        // get detail box, variant, category
        $query['data'] = ['product'];
        $query['select'] = [
            'product_variant_id' => 'variant_id',
            'product_category_id' => 'category_id',
            'product_box_id' => 'box_id',
        ];
        $query['where_detail'] = [
            "WHERE product_id = $id"
        ];
        $data = generateDetailData($this->request->getGet(), $query, $this->db);
        foreach ($data as $key => $value) {
            $data = $value[0];
        }

        $queryB['data'] = ['product_stock'];
        $queryB['select'] = [
            'product_stock_product_name' => 'product_name',
            'product_stock_stock' => 'stock'
        ];
        $queryB['where_detail'] = [
            "WHERE product_stock_product_id = $id"
        ];

        $data1 = generateDetailData($this->request->getGet(), $queryB, $this->db);

        // get file to insert
        $quantity = htmlspecialchars($post['value']);
        $variant = $data['variant_id'];
        $category = $data['category_id'];
        $box = $data['box_id'];

        $sql = "UPDATE product_stock SET product_stock_stock = product_stock_stock - {$quantity},
        product_stock_out = product_stock_out + {$quantity} WHERE product_stock_product_id = '{$id}'";
        $this->db->query($sql);

        $log = "INSERT INTO log_stock (log_stock_product_id, log_stock_product_name, log_stock_status, log_stock_quantity, log_stock_variant_id, log_stock_variant_name, log_stock_category_id, log_stock_category_name, log_stock_box_id, log_stock_box_value, log_stock_date)
            SELECT product_id, product_name, 'reduce', {$quantity}, {$variant}, variant_name, {$category}, category_name, {$box}, box_value, NOW()
            FROM product, category, `variant`, `box`
            WHERE product_id = '$id' AND variant_id = {$variant} AND category_id = {$category} AND box_id = {$box}";
        $this->db->query($log);

        $queryA['data'] = ['product_stock'];

        $queryA['select'] = [
            'product_stock_product_name' => 'product_name',
            'product_stock_stock' => 'stock',
        ];

        $queryA['where_detail'] = [
            " WHERE product_stock_product_id = '{$id}'"
        ];

        $data2 = generateDetailData($this->request->getVar(), $queryA, $this->db);

        foreach ($data1 as $key => $value) {
            $data1 = $value[0];
        }
        foreach ($data2 as $key => $value) {
            $data2 = $value[0];
        }
        $data = [
            'data' => [
                'before' => $data1,
                'after' => $data2,
            ]
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Reduced', $data);
    }

    public function add()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }
        $id = $this->request->getVar();
        $post = $this->request->getPost();
        $id = $id['id'];

        // get detail box, variant, category
        $query['data'] = ['product'];
        $query['select'] = [
            'product_variant_id' => 'variant_id',
            'product_category_id' => 'category_id',
            'product_box_id' => 'box_id',
        ];
        $query['where_detail'] = [
            "WHERE product_id = $id"
        ];
        $data = generateDetailData($this->request->getGet(), $query, $this->db);
        foreach ($data as $key => $value) {
            $data = $value[0];
        }

        $queryB['data'] = ['product_stock'];
        $queryB['select'] = [
            'product_stock_product_name' => 'product_name',
            'product_stock_stock' => 'stock'
        ];
        $queryB['where_detail'] = [
            "WHERE product_stock_product_id = $id"
        ];

        $data1 = generateDetailData($this->request->getGet(), $queryB, $this->db);

        // get file to insert
        $quantity = htmlspecialchars($post['value']);
        $variant = $data['variant_id'];
        $category = $data['category_id'];
        $box = $data['box_id'];

        $sql = "UPDATE product_stock SET product_stock_stock = product_stock_stock + {$quantity},
        product_stock_in = product_stock_in + {$quantity} WHERE product_stock_product_id = '{$id}'";
        $this->db->query($sql);

        $log = "INSERT INTO log_stock (log_stock_product_id, log_stock_product_name, log_stock_status, log_stock_quantity, log_stock_variant_id, log_stock_variant_name, log_stock_category_id, log_stock_category_name, log_stock_box_id, log_stock_box_value, log_stock_date)
            SELECT product_id, product_name, 'add', {$quantity}, {$variant}, variant_name, {$category}, category_name, {$box}, box_value, NOW()
            FROM product, category, `variant`, `box`
            WHERE product_id = '$id' AND variant_id = {$variant} AND category_id = {$category} AND box_id = {$box}";
        $this->db->query($log);

        $queryA['data'] = ['product_stock'];
        $queryA['select'] = [
            'product_stock_product_name' => 'product_name',
            'product_stock_stock' => 'stock',
        ];
        $queryA['where_detail'] = [
            " WHERE product_stock_product_id = '{$id}'"
        ];

        $data2 = generateDetailData($this->request->getVar(), $queryA, $this->db);

        foreach ($data1 as $key => $value) {
            $data1 = $value[0];
        }
        foreach ($data2 as $key => $value) {
            $data2 = $value[0];
        }
        $data = [
            'data' => [
                'before' => $data1,
                'after' => $data2,
            ]
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', $data);
    }

    public function update()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $id = $this->request->getGet('id');
        $post = $this->request->getPost();

        $stock = htmlspecialchars($post['stock']);

        $sql = "UPDATE product_stock SET product_stock_stock = '{$stock}' WHERE product_stock_id = {$id}";
        $this->db->query($sql);

        $query['data'] = ['product_stock'];
        $query['select'] = [
            'product_stock.product_stock_id' => 'id',
            'product.product_name' => 'name',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'variant.variant_id' => 'variant_id',
            'variant.variant_name' => 'variant_name',
            'product_stock.product_stock_stock' => 'stock_stock',
            'product_stock.product_stock_in' => 'stock_in',
            'product_stock.product_stock_out' => 'stock_out',

        ];
        $query['join'] = [
            'product' => 'product.product_id = product_stock.product_stock_product_id',
            'variant' => 'product.product_id = variant.variant_product_id',
        ];
        $query['where_detail'] = ["WHERE product_stock_id = $id"];
        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Updated', $data);
    }
}
