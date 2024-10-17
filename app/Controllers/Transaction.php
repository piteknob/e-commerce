<?php

namespace App\Controllers;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class Transaction extends AuthController
{
    public function select()
    {
        $json = $this->request->getJSON();
        $db = db_connect();
        $name_cust = $json->customer->name;
        $address_cust = $json->customer->address;
        $hp_cust = $json->customer->no_handphone;


        // --------------------------- VALIDATION PRODUCT ---------------------------- //
        foreach ($json->product as $key) {
            $validator = \Config\Services::validation();
            $validator->setRules([
                'product_id' => 'required',
            ]);

            if (!$validator->run((array)$key)) {
                $error = $validator->getErrors();
                if ($error) {
                    return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'error validation', $error);
                }
            }
        }

        // validation customer
        $validator = \Config\Services::validation();
        $validator->setRules([
            'name' => 'required',
            'no_handphone' => 'required|min_length[10]|max_length[20]',
            'address' => 'required'
        ]);

        $customer = (array) $json->customer;

        if (!$validator->run($customer)) {
            $error = $validator->getErrors();
            if ($error) {
                return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'error validation', $error);
            }
        }

        // check customer & add
        $name = htmlspecialchars($json->customer->name);
        $hp = $json->customer->no_handphone;
        $address = $json->customer->address;
        $error = [];

        $check = "SELECT customer_no_handphone, customer_name
            FROM customer
            WHERE customer_no_handphone = '{$hp}' AND customer_name = '{$name}'
            ;";

        $error = $db->query($check)->getResultArray();

        if (empty($error)) {
            $sql = "INSERT INTO customer (customer_id, customer_name, customer_address, customer_no_handphone)
                    VALUES ('', '{$name}', '{$address}', '{$hp}')";
            $sql = $db->query($sql);
            $idCustomer = $db->insertID();
        } else {
            // search id customer
            $idCustomer = "SELECT customer_id FROM customer WHERE customer_no_handphone = '{$hp}' AND customer_name = '{$name}'";
            $idCustomer = $db->query($idCustomer)->getResultArray();
            $idCustomer = $idCustomer[0]['customer_id'];
        }


        //------------------------------- CHECK PENDING -------------------------------//
        $query = "SELECT sales_order_status FROM sales_order WHERE sales_order_customer_id = ? AND  sales_order_status = 'pending'";

        $pending = $db->query($query, [$idCustomer])->getResultArray();

        if (empty($pending)) {
            $status = false;
        } else {
            $status = 'pending';
        }

        $selectHarga = "SELECT sales_order_price FROM sales_order WHERE sales_order_customer_id = {$idCustomer} AND sales_order_status = 'pending'";
        $selectHarga = $db->query($selectHarga)->getResultArray();

        $totalHarga = 0;
        foreach ($selectHarga as $key => $value) {
            $totalHarga += $value['sales_order_price'];
        }

        $gas['data'] = ['sales_order'];

        $gas['select'] = [
            'sales_order_id' => 'id',
            'sales_order_status' => 'status',
            'sales_order_price' => 'price',
            'sales_order_customer_id' => 'customer_id',
            'sales_order_customer_name' => 'customer_name',
            'sales_order_customer_address' => 'customer_address',
            'sales_order_customer_no_handphone' => 'customer_no_handphone',
            'sales_order_date' => 'date',
            'sales_order_proof' => 'proof',
        ];

        $gas['where_detail'] = [
            "WHERE sales_order_status = 'pending' AND sales_order_customer_id = {$idCustomer}"
        ];

        $gas['pagination'] = [
            'pagination' => false
        ];

        $gas = (array) generateDetailData($this->request->getPost(), $gas, $db);


        // check id customer 
        $cust_name = $json->customer->name;
        $cust_hp = $json->customer->no_handphone;
        $cust_address = $json->customer->address;
        $query_id_customer['data'] = ['customer'];
        $query_id_customer['select'] = [
            'customer_id' => 'id'
        ];
        $query_id_customer['where_detail'] = [
            "WHERE customer_name = '{$cust_name}' AND customer_address = '{$cust_address}' AND customer_no_handphone = {$cust_hp}"
        ];
        $id_customer = generateDetailData($this->request->getGet(), $query_id_customer, $this->db);

        foreach ($id_customer as $key => $value) {
            $id_customer = $value['id'];
        }

        $product_pending['data'] = ['sales_product'];
        $product_pending['select'] = [
            'sales_product_id' => 'id',
            'sales_product_status' => 'status',
            'sales_product_product_name' => 'product_name',
            'sales_product_product_variant' => 'product_variant',
            'sales_product_product_category' => 'product_category',
            'sales_product_quantity' => 'quantity',
            'sales_product_price' => 'price',
            'sales_product_order_id' => 'order_id',
            'sales_product_customer_id' => 'customer_id',
        ];
        $product_pending['where_detail'] = [
            "WHERE sales_product_customer_id = $id_customer AND sales_product_status = 'pending'"
        ];
        $product_pending = generateDetailData($this->request->getGet(), $product_pending, $this->db);
        // print_r($product_pending); die;
        foreach ($product_pending as $key => $value) {
            $product_pending = $value;
        }

        $comeplete = (object) [];
        $comeplete->customer_data = $gas['data'];
        $comeplete->product = [
            $product_pending
        ];
        $comeplete->payment = [
            'price_total' => $totalHarga,
            'payment_method' => 'transfer',
        ];
        $data_pending = [];
        $data_pending = [
            'data' => $comeplete
        ];

        if ($status == 'pending') {
            return $this->responseFail(ResponseInterface::HTTP_FAILED_DEPENDENCY, 'please complete ur last order', '', $data_pending);
        }


        // ------------------------------ TRANSACTION BEGIN ------------------------------- //

        // -------------------------------- REDUCE STOCK -------------------------------- //
        $data_stock = (array) $json->product;
        foreach ($data_stock as $key => $value) {
            $product_id_stock = $value->product_id;
            $product_stock_stock = $value->product_quantity;

            $reduce_stock = "UPDATE product_stock SET product_stock_stock = product_stock_stock - '{$product_stock_stock}', product_stock_out = product_stock_out + {$product_stock_stock} WHERE product_stock_product_id = '{$product_id_stock}'";
            $db->query($reduce_stock);
        }

        // -------------- TOTAL PRICE CHECK ------------- //

        // get detail data
        $post = $this->request->getJSON();
        $product = [];
        foreach ($post->product as $json) {
            $product[htmlspecialchars($json->product_id)] = $json->product_quantity;
        }
        $price_total = 0;
        foreach ($product as $id => $quantity) {
            $detail_price['data'] = ['product'];
            $detail_price['select'] = [
                'product_price' => 'price'
            ];
            $detail_price['where_detail'] = [
                "WHERE product_id = $id"
            ];
            $price = generateDetailData($this->request->getGet(), $detail_price, $this->db);
            foreach ($price as $key => $value) {
                $price = $value['price'];
            }

            $price = $price * $quantity;
            $price_total += $price;
        }

        $query_insert_sales_order = "INSERT INTO sales_order (
                            sales_order_status,
                            sales_order_price,
                            sales_order_customer_id,
                            sales_order_customer_name,
                            sales_order_customer_address,
                            sales_order_customer_no_handphone,
                            sales_order_date,
                            sales_order_proof
                            ) SELECT 
                            'pending',
                            {$price_total},
                            $idCustomer,
                            '{$name_cust}',
                            '{$address_cust}',
                            '{$hp_cust}',
                            NOW(),
                            NULL
                            FROM customer
                            WHERE customer_id = {$idCustomer}";
        $this->db->query($query_insert_sales_order);
        $id_order = $db->insertID();


        foreach ($product as $key => $value) {
            $detail_data['data'] = ['product'];
            $detail_data['select'] = [
                'product_stock.product_stock_id' => 'id',
                'product.product_id' => 'product_id',
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
            $detail_data['join'] = [
                'product_stock' => 'product.product_id = product_stock.product_stock_product_id',
            ];
            $detail_data['where_detail'] = [
                "WHERE product_id = $key"
            ];
            $data = generateDetailData($this->request->getPost(), $detail_data, $this->db);
            // print_r($data); die;
            foreach ($data as $key => $value) {
                // from post
                $id = $json->product_id;
                $quantity = $json->product_quantity;
                // from databasa detail
                $product_detail = $value['name'];
                $category_detail = $value['category_name'];
                $variant_detail = $value['variant_name'];
                $price_detail = $value['price'];
                $product_id = $value['product_id'];

                $query_insert_sales_product = "INSERT INTO sales_product (
                sales_product_status,
                sales_product_product_id,
                sales_product_product_name,
                sales_product_product_category,
                sales_product_product_variant,
                sales_product_quantity,
                sales_product_price,
                sales_product_order_id,
                sales_product_customer_id
                    ) VALUES (  
                        'pending',
                        '{$product_id}',
                        '{$product_detail}',
                        '{$category_detail}',
                        '{$variant_detail}',
                        '{$quantity}',
                        '{$price_detail}',
                        '{$id_order}',
                        '{$idCustomer}'
                    );";
                $this->db->query($query_insert_sales_product); // exec insert to sales_product
            }
        }

        $return_order['data'] = ['sales_order'];
        $return_order['select'] = [
            'sales_order_id' => 'id',
            'sales_order_status' => 'status',
            'sales_order_price' => 'price',
            'sales_order_customer_id' => 'customer_id',
            'sales_order_customer_name' => 'customer_name',
            'sales_order_customer_address' => 'customer_address',
            'sales_order_customer_no_handphone' => 'customer_no_handphone',
            'sales_order_date' => 'date',
            'sales_order_proof' => 'proof',
        ];
        $return_order['where_detail'] = [
            "WHERE sales_order_id = $id_order"
        ];
        $return_order = generateDetailData($this->request->getGet(), $return_order, $this->db);
        $return_order = (array) $return_order;

        $return_product['data'] = ['sales_product'];
        $return_product['select'] = [
            'sales_product_id' => 'id',
            'sales_product_status' => 'status',
            'sales_product_product_name' => 'product_name',
            'sales_product_product_variant' => 'product_variant',
            'sales_product_product_category' => 'product_category',
            'sales_product_quantity' => 'quantity',
            'sales_product_price' => 'price',
            'sales_product_order_id' => 'order_id',
            'sales_product_customer_id' => 'customer_id',
        ];
        $return_product['where_detail'] = [
            "WHERE sales_product_customer_id = $id_customer AND sales_product_status = 'pending'"
        ];
        $return_product = generateListData($this->request->getGet(), $return_product, $this->db);
        $return_product = (array) $return_product;
        $data_success = [
            'data' => [
                'customer_data' => $return_order['data'],
                'product' => $return_product['data']
            ]
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Order Result', $data_success);
    }

    public function payment()
    {
        // ------------------- GET ID ------------------- //
        $id = $this->request->getVar('id');

        // ------------------- GET FILE -------------------- //
        $photo = $this->request->getFile('upload');
        $db = db_connect();

        try {
            // Mulai transaksi
            $this->db->transBegin();

            // --------------------- CHECK ORDER EXIST ------------------------ //

            // Check pending order
            $query_exist_pending = $this->db->table('sales_order')
                ->select('sales_order_price as price')
                ->where('sales_order_id', $id)
                ->where('sales_order_status', 'pending')
                ->get()
                ->getResultArray();

            // Check payed order
            $query_exist_payed = $this->db->table('sales_order')
                ->select('sales_order_price as price')
                ->where('sales_order_id', $id)
                ->where('sales_order_status', 'payed')
                ->get()
                ->getResultArray();

            if (empty($query_exist_pending) && empty($query_exist_payed)) {
                return $this->responseFail(ResponseInterface::HTTP_NOT_FOUND, 'Order not found in database', 'Order not found', (object) []);
            }

            // -------------------------------- GET TOTAL HARGA --------------------------------- //

            $price = $this->db->table('sales_order')
                ->select('sales_order_price as price')
                ->where('sales_order_id', $id)
                ->where('sales_order_status', 'pending')
                ->get()
                ->getResultArray();

            $totalHarga = 0;
            foreach ($price as $value) {
                $totalHarga += $value['price'];
            }

            // --------------------- CHECK STATUS ORDER ------------------------ //

            // Check order status
            $data_check = $this->db->table('sales_order')
                ->select('sales_order_status')
                ->where('sales_order_id', $id)
                ->get()
                ->getResultArray();

            // Check product status
            $data_product = $this->db->table('sales_product')
                ->select('sales_product_status')
                ->where('sales_product_order_id', $id)
                ->get()
                ->getResultArray();

            $data_check_real = 'payed';
            $data_product_real = 'payed';

            foreach ($data_check as $value) {
                if ($value['sales_order_status'] == 'pending') {
                    $data_check_real = 'pending';
                }
            }

            foreach ($data_product as $value) {
                if ($value['sales_product_status'] == 'pending') {
                    $data_product_real = 'pending';
                }
            }

            if ($data_check_real == 'payed' && $data_product_real == 'payed') {
                return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Payment alreadt done',  (object) [], 'Order has been paid');
            }

            // --------------------- SET VALIDATION ------------------------ //
            $validator = \Config\Services::validation();
            $validator->setRules([
                'upload' => 'uploaded[upload]|max_size[upload,2048]|is_image[upload]|mime_in[upload,image/jpg,image/jpeg,image/png]',
            ]);

            if (!$validator->run((array)$photo)) {
                $error = $validator->getErrors();
                if ($error) {
                    return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error validation', $error);
                }
            }

            $pure_photo_name = $photo->getName();
            $photo_name = "customer_" . $id . "_" . $photo->getRandomName();
            $photo->move('./upload/photo', $photo_name);

            // ---------------------------------- UPDATE FROM 'PENDING' TO 'PAYED' ---------------------------------- //

            // Update sales_order to set proof and status
            $this->db->table('sales_order')
                ->where('sales_order_id', $id)
                ->where('sales_order_status', 'pending')
                ->update([
                    'sales_order_proof' => $photo_name,
                    'sales_order_status' => 'payed'
                ]);

            // Update sales_product to set status to 'payed'
            $this->db->table('sales_product')
                ->where('sales_product_order_id', $id)
                ->update(['sales_product_status' => 'payed']);

            // Commit transaksi
            if ($this->db->transStatus() === false) {
                // Rollback jika ada error
                $this->db->transRollback();
                return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Failed to complete payment', 'Transaction failed', (object) []);
            } else {
                // Commit transaksi
                $this->db->transCommit();
                $data = [
                    'data' => [
                        'total Payment' => $totalHarga,
                        'image' => $pure_photo_name
                    ]

                ];
                return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Paid', $data);
            }
        } catch (\Exception $e) {
            // Rollback jika terjadi exception
            $this->db->transRollback();
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred during the payment process', $e->getMessage(), (object) []);
        }
    }


    public function customer_cancel()
    {
        $post = $this->request->getPost();
        $id = $post['id'];
        $reason = $post['reason'];

        try {
            $this->db->transBegin();

            $this->db->table('sales_order')
                ->where('sales_order_id', $id)
                ->where('sales_order_status', 'pending')
                ->update(['sales_order_status' => 'break']);

            $this->db->table('sales_product')
                ->where('sales_product_order_id', $id)
                ->where('sales_product_status', 'pending')
                ->update(['sales_product_status' => 'break']);

            $check_payed = $this->db->table('sales_order')
                ->select('sales_order_status as status')
                ->where('sales_order_id', $id)
                ->get()
                ->getRowArray();

            if ($check_payed['status'] === 'payed' || $check_payed['status'] === 'confirmed') {
                return $this->responseFail(ResponseInterface::HTTP_OK, 'You Can Not Cancel This Order, Contact Admin To Cancel This Order', '', $check_payed);
            }

            // ----------------- RESTORE STOCK ---------------- //

            // Get order data where status is 'break'
            $query_data_order['data'] = ['sales_order'];
            $query_data_order['select'] = [
                'sales_order_id' => 'id',
                'sales_order_price' => 'price',
                'sales_order_customer_id' => 'customer_id',
                'sales_order_customer_name' => 'customer_name',
                'sales_order_customer_address' => 'customer_address',
                'sales_order_customer_no_handphone' => 'customer_no_handphone',
                'sales_order_date' => 'date',
                'sales_order_proof' => 'proof',
            ];
            $query_data_order['where_detail'] = ["WHERE sales_order_status = 'break'"];
            $data_order = (array) generateDetailData($this->request->getVar(), $query_data_order, $this->db);
            // print_r($data_order); die;

            $query_data_product['data'] = ['sales_product'];
            $query_data_product['select'] = [
                'sales_product_id' => 'id',
                'sales_product_product_id' => 'product_id',
                'sales_product_product_name' => 'product_name',
                'sales_product_product_variant' => 'product_variant',
                'sales_product_product_category' => 'product_category',
                'sales_product_quantity' => 'quantity',
                'sales_product_price' => 'price',
                'sales_product_order_id' => 'order_id',
                'sales_product_customer_id' => 'customer_id',
            ];
            $query_data_product['where_detail'] = ["WHERE sales_product_status = 'break'"];
            $query_data_product['pagination'] = [false];
            $data_product = (array) generateListData($this->request->getVar(), $query_data_product, $this->db);

            $this->db->table('sales_order')
                ->where('sales_order_id', $id)
                ->where('sales_order_status', 'break')
                ->update(['sales_order_status' => 'customer_canceled',
                          'sales_order_reason' => "$reason"]);

            $this->db->table('sales_product')
                ->where('sales_product_order_id', $id)
                ->where('sales_product_status', 'break')
                ->update(['sales_product_status' => 'customer_canceled']);

            // print_r($data_product); die;
            if (empty($data_product)) {
                return $this->responseFail(ResponseInterface::HTTP_GONE, 'Order already canceled by customer / admin', 'Order already canceled', (object) []);
            }

            // Restore stock
            // print_r($data_product); die;
            foreach ($data_product as $key => $value) {
                $quantity_stock = $value['quantity'];
                $product_id = $value['product_id'];

                // Update stock
                $this->db->table('product_stock')
                    ->where('product_stock_product_id', $product_id)
                    ->set('product_stock_stock', "product_stock_stock + {$quantity_stock}", false)
                    ->set('product_stock_out', "product_stock_out - {$quantity_stock}", false)
                    ->update();
            }

            // Commit transaction error or not
            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Failed to cancel the order', 'Transaction failed', (object) []);
            } else {
                $this->db->transCommit();
                $data = [
                    'data' => [
                        'order' => $data_order['data'],
                        'product' => $data_product,
                        'reason' => $reason
                    ]
                ];
                return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Successfully Canceled', $data);
            }
        } catch (\Exception $e) {
            $this->db->transRollback();
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'An error occurred while canceling the order', $e->getMessage(), (object) []);
        }
    }

    public function history_customer()
    {
        $id = $this->request->getVar();
        $id = $id['no_handphone'];


        $query['data'] = ['sales_order'];
        $query['select'] = [
            'sales_order_id' => 'id',
            'sales_order_status' => 'status',
            'sales_order_price' => 'price',
            'sales_order_customer_id' => 'customer_id',
            'sales_order_customer_name' => 'customer_name',
            'sales_order_customer_address' => 'customer_address',
            'sales_order_customer_no_handphone' => 'customer_no_handphone',
            'sales_order_date' => 'date',
            'sales_order_proof' => 'proof',
        ];
        $query['where_detail'] = [
            "WHERE sales_order_customer_no_handphone = {$id}"
        ];
        $data = (array) generateListData($this->request->getVar(), $query, $this->db);
        if (empty($data['data'])) {
            return $this->responseFail(ResponseInterface::HTTP_NOT_FOUND, 'Data customer not found in database', 'Data not found', (object)[]);
        }
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Data Customer', $data);
    }

    public function history_detail_customer()
    {
        $id = $this->request->getVar('id');

        $query['data'] = ['sales_product'];
        $query['select'] = [
            'sales_product_id' => 'id',
            'sales_product_status' => 'status',
            'sales_product_product_id' => 'product_id',
            'sales_product_product_name' => 'product_name',
            'sales_product_product_variant' => 'product_variant',
            'sales_product_product_category' => 'product_category',
            'sales_product_quantity' => 'quantity',
            'sales_product_price' => 'price',
            'sales_product_order_id' => 'order_id',
            'sales_product_customer_id' => 'customer_id',
        ];
        $query['where_detail'] = [
            "WHERE sales_product_order_id = {$id}"
        ];

        $data = (array) generateDetailData($this->request->getGet(), $query, $this->db);

        if (empty($data['data'])) {
            return $this->responseFail(ResponseInterface::HTTP_NOT_FOUND, 'Data customer not found in database', 'Data not found', (object)[]);
        }
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Order', $data);
    }
}
