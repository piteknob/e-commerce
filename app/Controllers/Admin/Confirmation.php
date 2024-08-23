<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class Confirmation extends AuthController
{

    public function list_transaction() //done
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

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
            "WHERE sales_order_status = 'payed' OR sales_order_status = 'pending'"
        ];
        $query['pagination'] = [true];

        $data = (array) generateListData($this->request->getGet(), $query, $this->db);

        if (!empty($data)) {
            $dataProduct = $data['data'];
            foreach ($dataProduct as $key => $value) {
                $photo = $value['proof'];
                if (empty($photo)) {
                    $photo = 'upload/default/default.jpg';
                } else {
                    $photo = 'upload/photo/' . $photo . '';
                }
                $id = $value['id'];
                $status = $value['status'];
                $price = $value['price'];
                $customer_id = $value['customer_id'];
                $customer_name = $value['customer_name'];
                $customer_address = $value['customer_address'];
                $customer_no_handphone = $value['customer_no_handphone'];
                $date = $value['date'];
                $data_array[] = [
                    'id' => $id,
                    'status' => $status,
                    'price' => $price,
                    'customer_id' => $customer_id,
                    'customer_name' => $customer_name,
                    'customer_address' => $customer_address,
                    'customer_no_handphone' => $customer_no_handphone,
                    'date' => $date,
                    'proof' => $photo
                ];
            }
        }
        if (!empty($data_array)) {
            $data_result = [
                'data' => $data_array,
                'pagination' => $data['pagination']
            ];
            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Transaction', $data_result);
        }

        return $this->responseSuccess(ResponseInterface::HTTP_NOT_FOUND, 'Data Not Found', $data = [
            'data' => []
        ]);
    }

    public function list_order_product()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $id = $this->request->getVar();
        $id = $id['id'];

        $query['data'] = ['sales_product'];
        $query['select'] = [
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
        $query['where_detail'] = [
            "WHERE sales_product_order_id = $id"
        ];
        $query['pagination'] = [true];
        $data = generateListData($this->request->getVar(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Order Product', $data);
    }

    public function detail()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }
        // $id = $this->request->getGet();
        // $id = $id['id'];

        $query_order['data'] = ['sales_order'];
        $query_order['select'] = [
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
        $query_order['where_detail'] = [
            "WHERE sales_order_status = 'pending' OR sales_order_status = 'payed'"
        ];

        $data_order = (array) generateListData($this->request->getVar(), $query_order, $this->db);
        $result = [];

        // check data empty or not
        if (!empty($data_order['data'])) {
            $id = $data_order['data'][0]['id'];
        } else {
            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Empty', ['data' => []]);
        }
        
        $query_product['data'] = ['sales_product'];
        $query_product['select'] = [
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
        $query_product['where_detail'] = [
            "WHERE sales_product_order_id = '{$id}'"
        ];
        $data_product = (array) generateListData($this->request->getVar(), $query_product, $this->db);

        // ----------------- GET TOTAL QUANTITY ------------------ //
        $total_quantity = 0;
        foreach ($data_product['data'] as $key => $value) {
            $total_quantity = $total_quantity + $value['quantity'];
        }

        // ----------------- MAKE RESPONSE RETURN ------------------- //
        foreach ($data_order['data'] as $key => $value) {
            $id = $value['id'];

            $query_product['data'] = ['sales_product'];
            $query_product['select'] = [
                'sales_product_id' => 'id',
                'sales_product_status' => 'status',
                'sales_product_product_name' => 'product_name',
                'sales_product_product_variant' => 'product_variant',
                'sales_product_product_category' => 'product_category',
                'sales_product_quantity' => 'quantity',
                'sales_product_price' => 'price',
                'sales_product_price * sales_product_quantity' => 'total_price',
                'sales_product_order_id' => 'order_id',
                'sales_product_customer_id' => 'customer_id',
            ];
            $query_product['where_detail'] = [
                "WHERE sales_product_order_id = '{$id}'"
            ];
            $data_product = (array) generateListData($this->request->getVar(), $query_product, $this->db);

            // ------------- HITUNG TOTAL BOX -------------- //
            $photo = $value['proof'];
            if (empty($photo)) {
                $photo = 'Belum di Bayar';
            } else {
                $photo = 'upload/photo/' . $photo . '';
            }
            $id = $value['id'];
            $status = $value['status'];
            $price = $value['price'];
            $customer_id = $value['customer_id'];
            $customer_name = $value['customer_name'];
            $customer_address = $value['customer_address'];
            $customer_no_handphone = $value['customer_no_handphone'];
            $date = $value['date'];

            $result[] = [
                'order' => [
                    'id' => $id,
                    'status' => $status,
                    'price' => $price,
                    'customer_id' => $customer_id,
                    'customer_name' => $customer_name,
                    'customer_address' => $customer_address,
                    'customer_no_handphone' => $customer_no_handphone,
                    'total_quantity' => (string) $total_quantity,
                    'date' => $date,
                    'proof' => $photo,
                ],
                'product' => $data_product['data']
            ];
        }
        $final = [
            'data' => $result
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail', $final);
    }

    public function history()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }
        // $id = $this->request->getGet();
        // $id = $id['id'];

        $query_order['data'] = ['sales_order'];
        $query_order['select'] = [
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
        $query_order['where_detail'] = [
            "WHERE sales_order_status NOT IN ('pending', 'payed')"
        ];

        $data_order = (array) generateListData($this->request->getVar(), $query_order, $this->db);
        $result = [];

        // check data empty or not
        if (!empty($data_order['data'])) {
            $id = $data_order['data'][0]['id'];
        } else {
            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Empty', ['data' => []]);
        }
        
        $query_product['data'] = ['sales_product'];
        $query_product['select'] = [
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
        $query_product['where_detail'] = [
            "WHERE sales_product_order_id = '{$id}'"
        ];
        $data_product = (array) generateListData($this->request->getVar(), $query_product, $this->db);

        // ----------------- GET TOTAL QUANTITY ------------------ //
        $total_quantity = 0;
        foreach ($data_product['data'] as $key => $value) {
            $total_quantity = $total_quantity + $value['quantity'];
        }

        // ----------------- MAKE RESPONSE RETURN ------------------- //
        foreach ($data_order['data'] as $key => $value) {
            $id = $value['id'];

            $query_product['data'] = ['sales_product'];
            $query_product['select'] = [
                'sales_product_id' => 'id',
                'sales_product_status' => 'status',
                'sales_product_product_name' => 'product_name',
                'sales_product_product_variant' => 'product_variant',
                'sales_product_product_category' => 'product_category',
                'sales_product_quantity' => 'quantity',
                'sales_product_price' => 'price',
                'sales_product_price * sales_product_quantity' => 'total_price',
                'sales_product_order_id' => 'order_id',
                'sales_product_customer_id' => 'customer_id',
            ];
            $query_product['where_detail'] = [
                "WHERE sales_product_order_id = '{$id}'"
            ];
            $data_product = (array) generateListData($this->request->getVar(), $query_product, $this->db);

            // ------------- HITUNG TOTAL BOX -------------- //
            $photo = $value['proof'];
            if (empty($photo)) {
                $photo = 'Transaksi Dibatalkan';
            } else {
                $photo = 'upload/photo/' . $photo . '';
            }
            $id = $value['id'];
            $status = $value['status'];
            $price = $value['price'];
            $customer_id = $value['customer_id'];
            $customer_name = $value['customer_name'];
            $customer_address = $value['customer_address'];
            $customer_no_handphone = $value['customer_no_handphone'];
            $date = $value['date'];

            $result[] = [
                'order' => [
                    'id' => $id,
                    'status' => $status,
                    'price' => $price,
                    'customer_id' => $customer_id,
                    'customer_name' => $customer_name,
                    'customer_address' => $customer_address,
                    'customer_no_handphone' => $customer_no_handphone,
                    'total_quantity' => (string) $total_quantity,
                    'date' => $date,
                    'proof' => $photo,
                ],
                'product' => $data_product['data']
            ];
        }
        $final = [
            'data' => $result
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'History', $final);
    }

    public function confirm()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }
        $post = $this->request->getVar();
        $id = $post['id'];

        $query_sales_order['data'] = ['sales_order'];

        $query_sales_order['select'] = [
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

        $query_sales_order['where_detail'] = [
            "WHERE sales_order_id = {$id}"
        ];

        $query_sales_order['pagination'] = [
            'pagination' => false
        ];

        $data_order = generateListData($this->request->getVar(), $query_sales_order, $this->db);

        $query_sales_product['data'] = ['sales_product'];
        $query_sales_product['select'] = [
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
        $query_sales_product['where_detail'] = [
            "WHERE sales_product_order_id = {$id}"
        ];
        $query_sales_product['pagination'] = [false];

        $data_product = generateListData($this->request->getVar(), $query_sales_product, $this->db);

        // -------------------- CHECK PRODUCT ALREADY CONFIRMED -------------------------- //
        if ($data_order[0]['status'] == 'confirmed') {
            $result_confirmed = [
                'data' => [
                    'order' => $data_order,
                    'product' => $data_product
                ]
            ];

            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Order Already Confirmed', $result_confirmed);
        }

        // -------------------- UPDATE FROM 'PAYED' TO 'CONFIRMED' ------------------------- //

        $sql_sales_order = "UPDATE sales_order SET 
                sales_order_status = 'confirmed'
                WHERE sales_order_status = 'payed' AND sales_order_id = {$id}";

        $this->db->query($sql_sales_order);

        $sql_sales_product = "UPDATE sales_product SET
                sales_product_status = 'confirmed'
                WHERE sales_product_status = 'payed' AND sales_product_order_id = {$id}";

        $this->db->query($sql_sales_product);


        foreach ($data_product as $key => $value) {
            $id_product = $value['product_id'];
            $product = $value['product_name'];
            $category = $value['product_category'];
            $variant = $value['product_variant'];
            $quantity = $value['quantity'];

            // ----------- GET VARIANT ID ----------- //
            $query_select_data['data'] = ['variant'];
            $query_select_data['select'] = [
                'variant_id' => 'id'
            ];
            $query_select_data['where_detail'] = ["WHERE variant_product_id = {$id_product}"];
            $id_variant = (array) generateDetailData($this->request->getVar(), $query_select_data, $this->db);
            $id_variant = $id_variant['data'][0]['id'];

            // --------- INSERT INTO log_stock --------- //
            $log = "INSERT INTO log_stock (
            log_stock_product_id,
            log_stock_variant_id,
            log_stock_category_id,
            log_stock_status,
            log_stock_quantity,
            log_stock_date
            )
            SELECT '{$id_product}', '{$id_variant}', category_id, 'sold', '{$quantity}', NOW()
            FROM category
            WHERE category_name = '{$category}'LIMIT 1;";
            $this->db->query($log);
        }

        $query_confirm_order['data'] = ['sales_order'];
        $query_confirm_order['select'] = [
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
        $query_confirm_order['where_detail'] = [
            "WHERE sales_order_id = {$id} AND sales_order_status = 'confirmed'"
        ];
        $query_confirm_order['pagination'] = [false];

        $data_confirm_order = generateDetailData($this->request->getVar(), $query_confirm_order, $this->db);
        foreach ($data_confirm_order as $key => $value) {
            $data_confirm_order = $value;
        }

        $query_confirm_product['data'] = ['sales_product'];
        $query_confirm_product['select'] = [
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
        $query_confirm_product['where_detail'] = [
            "WHERE sales_product_order_id = {$id} AND sales_product_status = 'confirmed'"
        ];

        $data_confirm_product = generateListData($this->request->getVar(), $query_confirm_product, $this->db);

        $result = [
            'data' => [
                'order' => $data_confirm_order,
                'product' => $data_confirm_product
            ]
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Order Successfully Confirmed', $result);
    }

    public function cancel()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        // get id
        $post = $this->request->getVar();
        $db = db_connect();
        $id = $post['id'];


        // CHECK ALREADY CANCELED 
        $query_check_canceled['data'] = ['sales_order'];
        $query_check_canceled['select'] = [
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
        $query_check_canceled['where_detail'] = [
            "WHERE sales_order_id = '{$id}' AND sales_order_status = 'canceled' AND sales_order_status = 'canceled'"
        ];

        $query_check_product['data'] = ['sales_product'];
        $query_check_product['select'] = [
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
        $query_check_product['where_detail'] = [
            "WHERE sales_product_order_id = '{$id}' AND sales_product_status = 'canceled'"
        ];

        $data_check_order = (array) generateDetailData($this->request->getVar(), $query_check_canceled, $this->db);
        $data_check_product = (array) generateListData($this->request->getVar(), $query_check_product, $db);
        if (!empty($data_check_order && $data_check_product)) {
            $data = [
                'data' => [
                    'order' => $data_check_order,
                    'product' => $data_check_product
                ]
            ];

            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Already Canceled', $data);
        }




        // ---------------------------- SQl UPADTE FROM 'PAYED' OR 'PENDING' TO 'CANCELED' ------------------------------ //
        $sql = "UPDATE sales_order SET sales_order_status = 'canceled' WHERE sales_order_id = '{$id}' AND (sales_order_status = 'pending' OR sales_order_status = 'payed')";

        $db->query($sql);

        $sql_product = "UPDATE sales_product SET sales_product_status = 'canceled' WHERE sales_product_order_id = '{$id}' AND (sales_product_status = 'pending' OR sales_product_status = 'payed')";

        $db->query($sql_product);

        $query_order['data'] = ['sales_order'];
        $query_order['select'] = [
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
        $query_order['where_detail'] = [
            "WHERE sales_order_id = '{$id}' AND sales_order_status = 'canceled'"
        ];

        $data_order_canceled = generateDetailData($this->request->getPost(), $query_order, $db);
        foreach ($data_order_canceled as $key => $value) {
            $data_order = $value;
        }

        $query_product['data'] = ['sales_product'];
        $query_product['select'] = [
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
        $query_product['where_detail'] = [
            "WHERE sales_product_order_id = '{$id}' AND sales_product_status = 'canceled'"
        ];
        $data_product_canceled = (array) generateListData($this->request->getVar(), $query_product, $db);

        // RESTORE STOCK 
        foreach ($data_product_canceled['data'] as $key => $value) {
            $product = $value['product_id'];
            $stock = $value['quantity'];

            $sql_add_stock = "UPDATE product_stock SET product_stock_stock = product_stock_stock + {$stock}, product_stock_out = product_stock_out - {$stock} WHERE product_stock_product_id = '{$product}'";
            $this->db->query($sql_add_stock);
        }


        $data = [
            'data' => [
                'order' => $data_order,
                'product' => $data_product_canceled
            ]
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Canceled', $data);
    }

    public function report()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }


        $query['data'] = ['customer'];

        $query['select'] = [
            'sales_order.sales_order_customer_id' => 'customer_id',
            'customer.customer_name' => 'customer_name',
            'sales_order.sales_order_status' => 'status',
            'sales_order.sales_order_product_name' => 'product',
            'sales_order.sales_order_category' => 'category',
            'sales_order.sales_order_unit' => 'unit',
            'sales_order.sales_order_price' => 'price',
            'sales_order.sales_order_value' => 'value',
            'sales_order.sales_order_date' => "'date'",
        ];

        $query['join'] = [
            'sales_order' => 'sales_order.sales_order_customer_id = customer.customer_id'
        ];

        $query['pagination'] = [
            'pagination' => true,
        ];

        $query['search_data'] = [
            'sales_order_category',
            'sales_order_unit',
            'sales_order_product_name',
        ];

        $query['filter'] = [
            "sales_order_category",
            "sales_order_unit",
        ];

        $query['limit'] = ['limit' => 10];

        $data = generateListData($this->request->getVar(), $query, $this->db);


        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Report Order', $data);
    }
}
