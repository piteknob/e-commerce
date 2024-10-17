<?php

declare(strict_types=1);

/**
 * This file is part of CodeIgniter 4 framework.
 *
 * (c) CodeIgniter Foundation <admin@codeigniter.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 */

// Validation language settings
// indonesia version
return [
    // Core Messages
    'noRuleSets'      => 'Tidak ada aturan yang ditentukan dalam konfigurasi Validasi.',
    'ruleNotFound'    => '"{0}" bukan aturan yang valid.',
    'groupNotFound'   => '"{0}" bukan grup aturan validasi.',
    'groupNotArray'   => 'Grup aturan "{0}" harus berupa array.',
    'invalidTemplate' => '"{0}" bukan template Validasi yang valid.',

    // Rule Messages
    'alpha'                 => 'Kolom {field} hanya boleh berisi karakter alfabet.',
    'alpha_dash'            => 'Kolom {field} hanya boleh berisi karakter alfanumerik, garis bawah, dan tanda hubung.',
    'alpha_numeric'         => 'Kolom {field} hanya boleh berisi karakter alfanumerik.',
    'alpha_numeric_punct'   => 'Kolom {field} hanya boleh berisi karakter alfanumerik, spasi, dan karakter ~ ! # $ % & * - _ + = | : .',
    'alpha_numeric_space'   => 'Kolom {field} hanya boleh berisi karakter alfanumerik dan spasi.',
    'alpha_space'           => 'Kolom {field} hanya boleh berisi karakter alfabet dan spasi.',
    'decimal'               => 'Kolom {field} harus berisi angka desimal.',
    'differs'               => 'Kolom {field} harus berbeda dari kolom {param}.',
    'equals'                => 'Kolom {field} harus sama persis dengan: {param}.',
    'exact_length'          => 'Kolom {field} harus memiliki panjang tepat {param} karakter.',
    'field_exists'          => 'Kolom {field} harus ada.',
    'greater_than'          => 'Kolom {field} harus berisi angka yang lebih besar dari {param}.',
    'greater_than_equal_to' => 'Kolom {field} harus berisi angka yang lebih besar atau sama dengan {param}.',
    'hex'                   => 'Kolom {field} hanya boleh berisi karakter heksadesimal.',
    'in_list'               => 'Kolom {field} harus salah satu dari: {param}.',
    'integer'               => 'Kolom {field} harus berisi angka bulat.',
    'is_natural'            => 'Kolom {field} hanya boleh berisi angka.',
    'is_natural_no_zero'    => 'Kolom {field} hanya boleh berisi angka dan harus lebih besar dari nol.',
    'is_not_unique'         => 'Kolom {field} harus berisi nilai yang sudah ada sebelumnya di database.',
    'is_unique'             => 'Kolom {field} harus berisi nilai yang unik.',
    'less_than'             => 'Kolom {field} harus berisi angka yang lebih kecil dari {param}.',
    'less_than_equal_to'    => 'Kolom {field} harus berisi angka yang lebih kecil atau sama dengan {param}.',
    'matches'               => 'Kolom {field} tidak cocok dengan kolom {param}.',
    'max_length'            => 'Kolom {field} tidak boleh lebih dari {param} karakter.',
    'min_length'            => 'Kolom {field} harus memiliki panjang minimal {param} karakter.',
    'not_equals'            => 'Kolom {field} tidak boleh sama dengan: {param}.',
    'not_in_list'           => 'Kolom {field} tidak boleh salah satu dari: {param}.',
    'numeric'               => 'Kolom {field} harus berisi angka.',
    'regex_match'           => 'Kolom {field} tidak sesuai dengan format yang benar.',
    'required'              => 'Kolom {field} wajib diisi.',
    'required_with'         => 'Kolom {field} wajib diisi ketika {param} ada.',
    'required_without'      => 'Kolom {field} wajib diisi ketika {param} tidak ada.',
    'string'                => 'Kolom {field} harus berupa string yang valid.',
    'timezone'              => 'Kolom {field} harus berisi zona waktu yang valid.',
    'valid_base64'          => 'Kolom {field} harus berisi string base64 yang valid.',
    'valid_email'           => 'Kolom {field} harus berisi alamat email yang valid.',
    'valid_emails'          => 'Kolom {field} harus berisi semua alamat email yang valid.',
    'valid_ip'              => 'Kolom {field} harus berisi IP yang valid.',
    'valid_url'             => 'Kolom {field} harus berisi URL yang valid.',
    'valid_url_strict'      => 'Kolom {field} harus berisi URL yang valid.',
    'valid_date'            => 'Kolom {field} harus berisi tanggal yang valid.',
    'valid_json'            => 'Kolom {field} harus berisi json yang valid.',

    // Credit Cards
    'valid_cc_num' => '{field} tampaknya bukan nomor kartu kredit yang valid.',

    // Files
    'uploaded' => '{field} bukan file yang diunggah dengan benar.',
    'max_size' => '{field} terlalu besar.',
    'is_image' => '{field} bukan file gambar yang diunggah dengan benar.',
    'mime_in'  => '{field} tidak memiliki tipe mime yang valid.',
    'ext_in'   => '{field} tidak memiliki ekstensi file yang valid.',
    'max_dims' => '{field} bukan gambar, atau terlalu lebar atau tinggi.',

];

// english version 
// return [
//     // Core Messages
//     'noRuleSets'      => 'No rule sets specified in Validation configuration.',
//     'ruleNotFound'    => '"{0}" is not a valid rule.',
//     'groupNotFound'   => '"{0}" is not a validation rules group.',
//     'groupNotArray'   => '"{0}" rule group must be an array.',
//     'invalidTemplate' => '"{0}" is not a valid Validation template.',

//     // Rule Messages
//     'alpha'                 => 'The {field} field may only contain alphabetical characters.',
//     'alpha_dash'            => 'The {field} field may only contain alphanumeric, underscore, and dash characters.',
//     'alpha_numeric'         => 'The {field} field may only contain alphanumeric characters.',
//     'alpha_numeric_punct'   => 'The {field} field may contain only alphanumeric characters, spaces, and  ~ ! # $ % & * - _ + = | : . characters.',
//     'alpha_numeric_space'   => 'The {field} field may only contain alphanumeric and space characters.',
//     'alpha_space'           => 'The {field} field may only contain alphabetical characters and spaces.',
//     'decimal'               => 'The {field} field must contain a decimal number.',
//     'differs'               => 'The {field} field must differ from the {param} field.',
//     'equals'                => 'The {field} field must be exactly: {param}.',
//     'exact_length'          => 'The {field} field must be exactly {param} characters in length.',
//     'field_exists'          => 'The {field} field must exist.',
//     'greater_than'          => 'The {field} field must contain a number greater than {param}.',
//     'greater_than_equal_to' => 'The {field} field must contain a number greater than or equal to {param}.',
//     'hex'                   => 'The {field} field may only contain hexadecimal characters.',
//     'in_list'               => 'The {field} field must be one of: {param}.',
//     'integer'               => 'The {field} field must contain an integer.',
//     'is_natural'            => 'The {field} field must only contain digits.',
//     'is_natural_no_zero'    => 'The {field} field must only contain digits and must be greater than zero.',
//     'is_not_unique'         => 'The {field} field must contain a previously existing value in the database.',
//     'is_unique'             => 'The {field} field must contain a unique value.',
//     'less_than'             => 'The {field} field must contain a number less than {param}.',
//     'less_than_equal_to'    => 'The {field} field must contain a number less than or equal to {param}.',
//     'matches'               => 'The {field} field does not match the {param} field.',
//     'max_length'            => 'The {field} field cannot exceed {param} characters in length.',
//     'min_length'            => 'The {field} field must be at least {param} characters in length.',
//     'not_equals'            => 'The {field} field cannot be: {param}.',
//     'not_in_list'           => 'The {field} field must not be one of: {param}.',
//     'numeric'               => 'The {field} field must contain only numbers.',
//     'regex_match'           => 'The {field} field is not in the correct format.',
//     'required'              => 'The {field} field is required.',
//     'required_with'         => 'The {field} field is required when {param} is present.',
//     'required_without'      => 'The {field} field is required when {param} is not present.',
//     'string'                => 'The {field} field must be a valid string.',
//     'timezone'              => 'The {field} field must be a valid timezone.',
//     'valid_base64'          => 'The {field} field must be a valid base64 string.',
//     'valid_email'           => 'The {field} field must contain a valid email address.',
//     'valid_emails'          => 'The {field} field must contain all valid email addresses.',
//     'valid_ip'              => 'The {field} field must contain a valid IP.',
//     'valid_url'             => 'The {field} field must contain a valid URL.',
//     'valid_url_strict'      => 'The {field} field must contain a valid URL.',
//     'valid_date'            => 'The {field} field must contain a valid date.',
//     'valid_json'            => 'The {field} field must contain a valid json.',

//     // Credit Cards
//     'valid_cc_num' => '{field} does not appear to be a valid credit card number.',

//     // Files
//     'uploaded' => '{field} is not a valid uploaded file.',
//     'max_size' => '{field} is too large of a file.',
//     'is_image' => '{field} is not a valid, uploaded image file.',
//     'mime_in'  => '{field} does not have a valid mime type.',
//     'ext_in'   => '{field} does not have a valid file extension.',
//     'max_dims' => '{field} is either not an image, or it is too wide or tall.',
// ];
