<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;
use Exception;

class Product extends AuthController
{
    public function list_product() //done
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }


        $query['data'] = ['product'];
        $query['select'] = [
            'product.product_id' => 'id'
        ];
        $query['pagination'] = [false];
        $data = (array) generateListData($this->request->getGet(), $query, $this->db);
        // print_r($data); die;
        if (empty($data)) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error occurred', 'Error Data Not Found', "");
        }

        // GET CATEGORY ID FROM PRODUCT
        $return = [];
        foreach ($data as $key => $value) {
            $id = $value['id'];
            // print_r($id); die;

            $query['data'] = ['product'];
            $query['select'] = [
                'product.product_id' => 'id',
                'product.product_name' => 'name',
                'product.product_price' => 'price',
                'product.product_category_id' => 'category_id',
                'product.product_category_name' => 'category_name',
                'product.product_variant_id' => 'variant_id',
                'product.product_variant_name' => 'variant_name',
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
            ];
            $query['where_detail'] = [
                "WHERE product_id = $id"
            ];
            $data_product = (array) generateDetailData($this->request->getVar(), $query, $this->db);
            $id_category = $data_product['data']['category_id'];

            // GET DATA SELECTED
            $query_category_selected = "SELECT * FROM `category` WHERE category_id = {$id_category}";
            $data_category_selected = $this->db->query($query_category_selected)->getResultArray();

            // GET DATA NOT SELECTED
            $query_category = "SELECT * FROM `category` WHERE category_id != {$id_category}";
            $data_category = $this->db->query($query_category)->getResultArray();

            $category_array = array_merge($data_category_selected, $data_category);




            // MAKE LIST CATEGORY (SELECTED OR NOT SELECTED)
            $product_data = $data_product['data'];
            if (empty($product_data['photo'])) {
                $photo = 'upload/default/default_photo.webp';
            } else {
                $photo = 'upload/product/' . $product_data['photo'];
            }
            $return[] = [
                'product' => [
                    'id' => $product_data['id'],
                    'name' => $product_data['name'],
                    'price' => $product_data['price'],
                    'category_id' => $product_data['category_id'],
                    'category_name' => $product_data['category_name'],
                    'variant_id' => $product_data['variant_id'],
                    'variant_name' => $product_data['variant_name'],
                    'stock_stock' => $product_data['stock_stock'],
                    'stock_in' => $product_data['stock_in'],
                    'stock_out' => $product_data['stock_out'],
                    'description' => $product_data['description'],
                    'photo' => $photo,
                    'created_at' => $product_data['created_at'],
                    'updated_at' => $product_data['updated_at'],
                ],
                'category_list' => $category_array,
            ];
            // $result = ['data' => $return];
        }

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Product', $return);
    }

    public function list_product_pagination()
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $query['data'] = ['product'];
        $query['select'] = [
            'product.product_id' => 'id'
        ];
        $query['join'] = [
            'product_stock' => 'product.product_id = product_stock.product_stock_product_id',
        ];
        $query['search_data'] = [
            'product_name',
        ];
        $query['filter'] = [
            "product_category_name",
        ];
        $query['pagination'] = [false];
        $data = (array) generateListData($this->request->getGet(), $query, $this->db);

        if (empty($data)) {
            return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Product', $data);
        }

        // GET CATEGORY ID FROM PRODUCT
        $return = [];
        foreach ($data as $key => $value) {
            $id = $value['id'];

            $query['data'] = ['product'];
            $query['select'] = [
                'product.product_id' => 'id',
                'product.product_name' => 'name',
                'product.product_price' => 'price',
                'product.product_category_id' => 'category_id',
                'product.product_category_name' => 'category_name',
                'product.product_variant_id' => 'variant_id',
                'product.product_variant_name' => 'variant_name',
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
            ];
            $query['where_detail'] = [
                "WHERE product_id = $id"
            ];
            $data_product = (array) generateDetailData($this->request->getVar(), $query, $this->db);
            $id_category = $data_product['data']['category_id'];

            // GET DATA SELECTED
            $query_category_selected = "SELECT * FROM `category` WHERE category_id = {$id_category}";
            $data_category_selected = $this->db->query($query_category_selected)->getResultArray();

            // GET DATA NOT SELECTED
            $query_category = "SELECT * FROM `category` WHERE category_id != {$id_category}";
            $data_category = $this->db->query($query_category)->getResultArray();





            // MAKE LIST CATEGORY (SELECTED OR NOT SELECTED)
            $product_data = $data_product['data'];
            if (empty($product_data['photo'])) {
                $photo = 'upload/default/default_photo.webp';
            } else {
                $photo = 'upload/product/' . $product_data['photo'];
            }
            $return[] = [
                'id' => $product_data['id'],
                'name' => $product_data['name'],
                'price' => $product_data['price'],
                'category_id' => $product_data['category_id'],
                'category_name' => $product_data['category_name'],
                'variant_id' => $product_data['variant_id'],
                'variant_name' => $product_data['variant_name'],
                'stock_stock' => $product_data['stock_stock'],
                'stock_in' => $product_data['stock_in'],
                'stock_out' => $product_data['stock_out'],
                'description' => $product_data['description'],
                'photo' => $photo,
                'created_at' => $product_data['created_at'],
                'updated_at' => $product_data['updated_at'],
            ];
            // $result = ['data' => $return];
        }
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 5;

        $paginationResult = paginate($return, $page, $limit);


        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Product', $paginationResult);
    }

    public function detail() //done
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }
        $id = $this->request->getVar('id');

        $query['data'] = ['product'];
        $query['select'] = [
            'product.product_id' => 'id',
            'product.product_name' => 'name',
            'product.product_price' => 'price',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'product.product_variant_id' => 'variant_id',
            'product.product_variant_name' => 'variant_name',
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
        ];
        $query['where_detail'] = [
            "WHERE product_id = $id"
        ];

        $data = (array) generateDetailData($this->request->getVar(), $query, $this->db);

        $product_data = $data['data'];
        if (empty($product_data['photo'])) {
            $photo = 'upload/default/default_photo.webp';
        } else {
            $photo = 'upload/product/' . $product_data['photo'];
        }
        $return = (object) [];
        $return->data = [
            'id' => $product_data['id'],
            'name' => $product_data['name'],
            'price' => $product_data['price'],
            'category_id' => $product_data['category_id'],
            'category_name' => $product_data['category_name'],
            'variant_id' => $product_data['variant_id'],
            'variant_name' => $product_data['variant_name'],
            'stock_stock' => $product_data['stock_stock'],
            'stock_in' => $product_data['stock_in'],
            'stock_out' => $product_data['stock_out'],
            'description' => $product_data['description'],
            'photo' => $photo,
            'created_at' => $product_data['created_at'],
            'updated_at' => $product_data['updated_at'],
        ];

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Data', $return);
    }

    public function insert() //done
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        // ---------------------- SET VALIDATION ------------------------ //

        $rules = [
            'name' => 'required|max_length[50]',
            'variant_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'description' => 'max_length[500]',
            'photo' => 'uploaded[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]|max_size[photo,2048]'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }


        $post = $this->request->getPost();

        $product = htmlspecialchars($post['name']);
        $variant = htmlspecialchars($post['variant_id']);
        $category = htmlspecialchars($post['category_id']);
        $price = htmlspecialchars($post['price']);
        $stock = htmlspecialchars($post['stock']);
        $desc = htmlspecialchars($post['description']);

        // ----------------------- RANDOM DATE --------------------------- //

        $start = time();
        $end = time() + 3600;
        $random = mt_rand($start, $end);

        // --------------------- UPLOAD GET POST PHOTO ------------------------ //


        $photo = $this->request->getFile('photo');
        if (empty($photo)) {
            $photo_name = '';
        } else {
            $extension = $photo->getExtension();
            $photo_name = "$product" . "_" . "$random" . "." . "$extension";
            $photo_name = $photo_name;
            $photo_name = strtolower($photo_name);
            $photo_name = str_replace(' ', '_', $photo_name);
            // move file to directory
            $photo->move('./upload/product', $photo_name);
        }
        $sql = "INSERT INTO product
            (
                product_name,
                product_price,
                product_category_id,
                product_category_name,
                product_variant_id,
                product_variant_name,
                product_description,
                product_photo,
                product_created_at,
                product_updated_at
            )
            SELECT 
                '{$product}', 
                '{$price}', 
                '{$category}', 
                category_name,
                '{$variant}',
                variant_name, 
                '{$desc}', 
                CASE 
                    WHEN '{$photo_name}' = '' THEN ''
                    ELSE '{$photo_name}'
                END, 
                NOW(), 
                NULL
            FROM category, variant
            WHERE category_id = '{$category}' AND variant_id = '{$variant}';";


        $this->db->query($sql);
        // Get Inserted Id
        $id_product = $this->db->insertID();
        // print_r($sql); die;

        $sql_stock = "INSERT INTO product_stock
        (
        product_stock_product_id,
        product_stock_variant_id,
        product_stock_category_id,
        product_stock_stock
        )
        VALUES('{$id_product}', '{$variant}', '{$category}', '{$stock}')
        ";
        $this->db->query($sql_stock);


        $query['data'] = ['product'];
        $query['select'] = [
            'product.product_id' => 'id',
            'product.product_name' => 'name',
            'product.product_price' => 'price',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'product.product_variant_id' => 'variant_id',
            'product.product_variant_name' => 'variant_name',
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
        ];
        $query['where_detail'] = [
            "WHERE product_stock_product_id = '{$id_product}' AND product_stock_variant_id = '{$variant}' AND product_stock_category_id = '{$category}'"
        ];

        $data = generateDetailData($this->request->getGet(), $query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', $data);
    }

    public function update() //done
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        $rules = [
            'id' => 'required|numeric',
            'name' => 'required|max_length[50]',
            'variant_id' => 'required|numeric',
            'category_id' => 'required|numeric',
            'description' => 'max_length[500]',
            'photo' => 'uploaded[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]|max_size[photo,2048]'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        $post = $this->request->getPost();

        $id = htmlspecialchars($post['id']);
        $product = htmlspecialchars($post['name']);
        $variant = htmlspecialchars($post['variant_id']);
        $category = htmlspecialchars($post['category_id']);
        $price = htmlspecialchars($post['price']);
        $stock = htmlspecialchars($post['stock']);
        $desc = htmlspecialchars($post['description']);

        // --------------------- SET VALIDATION && UPLOAD GET POST PHOTO ------------------------ //
        $query['data'] = ['product'];
        $query['select'] = [
            'product_photo' => 'photo'
        ];
        $query['where_detail'] = [
            "WHERE product_id = '{$id}'"
        ];
        $data_photo = (array) generateDetailData($this->request->getGet(), $query, $this->db);
        // print_r($data_photo); die;
        $data_photo = $data_photo['data']['photo'];

        if (empty($data_photo)) {
            $data_photo = 'empty';
        }
        if (file_exists("upload/product/" . $data_photo)) {
            unlink("upload/product/" . $data_photo);
        }

        // ----------------------- RANDOM DATE --------------------------- //

        $start = time();
        $end = time() + 3600;
        $random = mt_rand($start, $end);

        // --------------------- SET VALIDATION && UPLOAD GET POST PHOTO ------------------------ //

        $photo = $this->request->getFile('upload');



        if (empty($photo)) {
            $photo_name = '';
        } else {
            $extension = $photo->getExtension();
            $photo_name = "$product" . "_" . "$random" . "." . "$extension";
            $photo_name = $photo_name;
            $photo_name = strtolower($photo_name);
            $photo_name = str_replace(' ', '_', $photo_name);
            // move file to directory
            $photo->move('./upload/product', $photo_name);
        }


        $sql = "UPDATE product 
        SET
            product_name = '{$product}',
            product_price = '{$price}',
            product_category_id = '{$category}',
            product_category_name = (SELECT category_name FROM `category` WHERE category_id = '{$category}'),
            product_variant_id = '{$variant}',
            product_variant_name = (SELECT variant_name FROM `variant` WHERE variant_id = '{$variant}'),
            product_description = '{$desc}',
            product_photo = CASE 
                WHEN '{$photo_name}' = '' THEN product_photo  
                ELSE '{$photo_name}'  
            END, 
            product_updated_at = NOW()
        WHERE product_id = {$id}
            ";
        $this->db->query($sql);

        // Get Data Updated
        $query['data'] = ['product'];
        $query['select'] = [
            'product.product_id' => 'id',
            'product.product_name' => 'name',
            'product.product_price' => 'price',
            'product.product_category_id' => 'category_id',
            'product.product_category_name' => 'category_name',
            'product.product_variant_id' => 'variant_id',
            'product.product_variant_name' => 'variant_name',
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
        ];
        $query['where_detail'] = [
            "WHERE product_id = $id"
        ];

        $data = generateDetailData($this->request->getPost(), $query, $this->db);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfull Updated', $data);
    }

    public function delete() //done
    {
        // Authorization Token
        $token = $this->before(getallheaders());
        if (!empty($token)) {
            return $token;
        }

        // set validation
        $rules = [
            'id' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return $this->responseErrorValidation(ResponseInterface::HTTP_PRECONDITION_FAILED, 'Error Validation', $this->validator->getErrors());
        }

        // --------------------- DELETE PHOTO  ------------------------ //
        $id = $this->request->getPost('id');
        $query['data'] = ['product'];
        $query['select'] = [
            'product_id' => 'id',
            'product_photo' => 'photo'
        ];
        $query['where_detail'] = [
            "WHERE product_id = '{$id}'"
        ];
        $data_photo = (array) generateDetailData($this->request->getGet(), $query, $this->db);

        if (empty($data_photo['data']['id'])) {
            return $this->responseFail(ResponseInterface::HTTP_GONE, 'Data already deleted from database', 'Data already deleted', "");
        }

        $data_photo = $data_photo['data']['photo'];

        if (!empty($data_photo)) {
            if (file_exists("upload/product/" . $data_photo)) {
                unlink("upload/product/" . $data_photo);
            }
        }

        // delete action
        try {
            $this->db->table('product')->delete(['product_id' => $id]);
            $this->db->table('product_stock')->delete(['product_stock_product_id' => $id]);
        } catch (\Exception $e) {
            return $this->responseFail(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR, 'Error Delete Data', $e->getMessage());
        }

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Deleted', (object) []);
    }
}
