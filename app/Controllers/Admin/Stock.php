<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class Stock extends AuthController
{
    public function list_stock()
    {

        $query['data'] = ['product'];
        $query['select'] = [
            'product_stock.product_stock_id' => 'id',
            'product.product_name' => 'name',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'product.product_variant_id' => 'variant_id',
            'product.product_variant_name' => 'variant_name',
            'product_stock.product_stock_stock' => 'stock_stock',
            'product_stock.product_stock_in' => 'stock_in',
            'product_stock.product_stock_out' => 'stock_out',
        ];
        $query['join'] = [
            'product_stock' => 'product.product_id = product_stock.product_stock_product_id',
        ];
        $query['search_data'] = ['product_name'];
        $query['filter'] = ['product_category_name'];

        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Stock', $data);
    }

    public function detail_stock()
    {
        $id = $this->request->getVar('id');

        $query['data'] = ['product'];
        $query['select'] = [
            'product_stock.product_stock_id' => 'id',
            'product.product_name' => 'name',
            'product.product_price' => 'price',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'product.product_variant_id' => 'variant_id',
            'product.product_variant_name' => 'variant_name',
            'product_stock.product_stock_stock' => 'stock_stock',
            'product_stock.product_stock_in' => 'stock_in',
            'product_stock.product_stock_out' => 'stock_out',

        ];
        $query['join'] = [
            'product_stock' => 'product.product_id = product_stock.product_stock_product_id',
        ];
        $query['where_detail'] = [
            "WHERE product_stock_id = $id"
        ];

        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Data', $data);
    }

    public function reduce()
    {

        // set validation 
        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'id' => 'required|numeric',
            'value' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        $id = $this->request->getVar();
        $post = $this->request->getPost();
        $id = $id['id'];

        // get detail box, variant, category
        $query['data'] = ['product'];
        $query['select'] = [
            'product_variant_id' => 'variant_id',
            'product_category_id' => 'category_id',
        ];
        $query['where_detail'] = [
            "WHERE product_id = $id"
        ];
        $data = generateDetailData($this->request->getGet(), $query, $this->db);
        foreach ($data as $key => $value) {
            $data = $value;
        }

        // get file to insert
        $quantity = htmlspecialchars($post['value']);
        $variant = $data['variant_id'];
        $category = $data['category_id'];

        $sql = "UPDATE product_stock SET product_stock_stock = product_stock_stock - {$quantity},
        product_stock_out = product_stock_out + {$quantity} WHERE product_stock_product_id = '{$id}'";
        $this->db->query($sql);

        $log = "INSERT INTO log_stock (log_stock_product_id, log_stock_status, log_stock_quantity, log_stock_variant_id, log_stock_category_id, log_stock_date)
            SELECT {$id}, 'reduce', '{$quantity}', '{$variant}', '{$category}', NOW()
            FROM `product`, `category`, `variant`
            WHERE product_id = '$id' AND variant_id = {$variant} AND category_id = {$category};";
        $this->db->query($log);

        $return = [
            'data reduced' => $quantity
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Reduced', ['data' => (object) []]);
    }

    public function add()
    {

        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'id' => 'required|numeric',
            'value' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        $id = $this->request->getVar();
        $post = $this->request->getPost();
        $id = $id['id'];

        // get detail box, variant, category
        $query['data'] = ['product'];
        $query['select'] = [
            'product_variant_id' => 'variant_id',
            'product_category_id' => 'category_id',
        ];
        $query['where_detail'] = [
            "WHERE product_id = $id"
        ];
        $data = generateDetailData($this->request->getGet(), $query, $this->db);
        foreach ($data as $key => $value) {
            $data = $value;
        }

        // get file to insert
        $quantity = htmlspecialchars($post['value']);
        $variant = $data['variant_id'];
        $category = $data['category_id'];

        $sql = "UPDATE product_stock SET product_stock_stock = product_stock_stock + {$quantity},
        product_stock_out = product_stock_out + {$quantity} WHERE product_stock_product_id = '{$id}'";
        $this->db->query($sql);

        $log = "INSERT INTO log_stock (log_stock_product_id, log_stock_status, log_stock_quantity, log_stock_variant_id, log_stock_category_id, log_stock_date)
            SELECT {$id}, 'add', '{$quantity}', '{$variant}', '{$category}', NOW()
            FROM `product`, `category`, `variant`
            WHERE product_id = '$id' AND variant_id = {$variant} AND category_id = {$category};";
        $this->db->query($log);

        $return = [
            'data reduced' => $quantity
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', ['data' => (object) []]);
    }

    public function update()
    {

        // ---------------------- SET VALIDATION ------------------------ //
        $rules = [
            'id' => 'required|numeric',
            'stock' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        try {
            $post = $this->request->getPost();
            $id = htmlspecialchars($post['id']);
            $stock = htmlspecialchars($post['stock']);

            $this->db->table('product_stock')
                ->set('product_stock_stock', $stock)
                ->where('product_stock_id', $id)
                ->update();
        } catch (\Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error Update Stock', $e->getMessage());
        }

        $query['data'] = ['product_stock'];
        $query['select'] = [
            'product_stock.product_stock_id' => 'id',
            'product.product_name' => 'name',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'product.product_variant_id' => 'variant_id',
            'product.product_variant_name' => 'variant_name',
            'product_stock.product_stock_stock' => 'stock_stock',
            'product_stock.product_stock_in' => 'stock_in',
            'product_stock.product_stock_out' => 'stock_out',

        ];
        $query['join'] = [
            'product' => 'product.product_id = product_stock.product_stock_product_id',
        ];
        $query['where_detail'] = ["WHERE product_stock_id = $id"];
        $data = generateDetailData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Updated', $data);
    }
}
