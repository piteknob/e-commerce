<?php

namespace App\Controllers\Admin;

use App\Controllers\Core\AuthController;
use CodeIgniter\HTTP\ResponseInterface;

class Outlet extends AuthController
{
    public function list_outlet()
    {

        $query['data'] = ['outlet'];
        $query['select'] = [
            'outlet_id' => 'id'
        ];
        $query['pagination'] = [false];
        $data = (array) generateListData($this->request->getGet(), $query, $this->db);
        // print_r($data); die;

        // GET CATEGORY ID FROM PRODUCT
        $return = [];
        foreach ($data as $key => $value) {
            $id = $value['id'];
            // print_r($id); die;

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
            $data_outlet = (array) generateDetailData($this->request->getVar(), $query, $this->db);
            // print_r($data_outlet); die;
            if (empty($data_outlet['data'][0]['photo'])) {
                $photo = 'upload/default/default_photo.webp';
            } else {
                $photo = 'upload/photo/' . $data_outlet['data'][0]['photo'];
            }
            $data_outlet = $data_outlet['data'][0];
            $return[] = [
                'id' => $data_outlet['id'],
                'title' => $data_outlet['title'],
                'address' => $data_outlet['address'],
                'link' => $data_outlet['link'],
                'photo' => $photo,
                'created_at' => $data_outlet['created_at'],
                'updated_at' => $data_outlet['updated_at'],
            ];
        }

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'List Outlet', $return);
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

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Detail Outlet', $return);
    }

    public function insert()
    {

        $post = $this->request->getPost();

        $title = $post['title'];
        $address = $post['address'];
        $link = $post['link'];

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
            $photo_name = "$title" . "_" . "$random" . "." . "$extension";
            $photo_name = $photo_name;
            $photo_name = strtolower($photo_name);
            $photo_name = str_replace(' ', '_', $photo_name);
            // move file to directory
            $photo->move('./upload/photo', $photo_name);
        }

        $sql = "INSERT INTO outlet (
        outlet_title,
        outlet_address,
        outlet_photo,
        outlet_link,
        outlet_created_at,
        outlet_updated_at
        ) VALUES (
        '{$title}',
        '{$address}',
        CASE 
            WHEN '{$photo_name}' = '' THEN NULL
            ELSE '{$photo_name}'
        END, 
        '{$link}',
        NOW(),
        NULL);";
        // print_r($sql);
        // die;

        $this->db->query($sql);
        $id = $this->db->insertID();

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

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Added', $data);
    }

    public function update()
    {

        $id = $this->request->getGet();
        $id = $id['id'];
        $post = $this->request->getPost();

        $title = $post['title'];
        $address = $post['address'];
        $link = $post['link'];


        // --------------------- SET VALIDATION && UPLOAD GET POST PHOTO ------------------------ //
        $query['data'] = ['outlet'];
        $query['select'] = [
            'outlet_photo' => 'photo'
        ];
        $query['where_detail'] = [
            "WHERE outlet_id = '{$id}'"
        ];
        $data_photo = (array) generateDetailData($this->request->getGet(), $query, $this->db);
        $data_photo = $data_photo['data'][0]['photo'];

        if (empty($data_photo)) {
            $data_photo = 'empty';
        }
        if (file_exists("upload/photo/" . $data_photo)) {
            unlink("upload/photo/" . $data_photo);
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
            $photo_name = "$title" . "_" . "$random" . "." . "$extension";
            $photo_name = $photo_name;
            $photo_name = strtolower($photo_name);
            $photo_name = str_replace(' ', '_', $photo_name);
            // move file to directory
            $photo->move('./upload/photo', $photo_name);
        }

        $sql = "UPDATE outlet
        SET outlet_title = '{$title}',
        outlet_address = '{$address}',
        outlet_link = '{$link}',
        outlet_photo = CASE 
            WHEN '{$photo_name}' = '' THEN outlet_photo  
            ELSE '{$photo_name}'  
        END, 
        outlet_updated_at = NOW()
        WHERE outlet_id = {$id}
        ";

        $this->db->query($sql);

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
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfully Updated', $data);
    }

    public function delete()
    {

        $id = $this->request->getGet();
        $id = $id['id'];

        // --------------------- DELETE PHOTO  ------------------------ //
        $query['data'] = ['outlet'];
        $query['select'] = [
            'outlet_photo' => 'photo'
        ];
        $query['where_detail'] = [
            "WHERE outlet_id = '{$id}'"
        ];
        $data_photo = (array) generateDetailData($this->request->getGet(), $query, $this->db);
        $data_photo = $data_photo['data'][0]['photo'];
        if (!empty($data_photo)) {
            if (file_exists("upload/photo/" . $data_photo)) {
                unlink("upload/photo/" . $data_photo);
            }
        }

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

        $sql = "DELETE FROM outlet WHERE outlet_id = $id";
        $this->db->query($sql);

        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'Data Successfull Deleted', $data);
    }

    public function test_update_core() // test update core DONE
    {
        $id = $this->request->getGet(); 
        $id = $id['id'];
        $query['table'] = ['outlet'];
        $query['update'] = [
            'outlet_title' => 'core',
            'outlet_address' => 'core',
            'outlet_photo' => 'core',
            'outlet_link' => 'core',
        ];
        // $query['where_detail'] = [
        //     "WHERE outlet_id = $id"
        // ];
        $query['where'] = [$id];

        $data = (array) update($query, $this->db);
        return $this->responseSuccess(ResponseInterface::HTTP_OK, 'test', $data);
    }
}
