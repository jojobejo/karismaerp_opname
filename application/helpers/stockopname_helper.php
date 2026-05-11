<?php
defined('BASEPATH') or exit('No direct script access allowed');

if (!function_exists('stockopname_json')) {
    function stockopname_json($controller, $status, $message, $data = array(), $http_code = 200)
    {
        return $controller->output
            ->set_status_header($http_code)
            ->set_content_type('application/json')
            ->set_output(json_encode(array(
                'status' => (bool) $status,
                'message' => (string) $message,
                'data' => $data
            )));
    }
}

if (!function_exists('stockopname_clean')) {
    function stockopname_clean($value)
    {
        return trim(strip_tags((string) $value));
    }
}

if (!function_exists('stockopname_nullable_text')) {
    function stockopname_nullable_text($value)
    {
        $value = stockopname_clean($value);
        return $value === '' ? null : $value;
    }
}

if (!function_exists('stockopname_nullable_int')) {
    function stockopname_nullable_int($value)
    {
        $value = trim((string) $value);
        return $value === '' ? null : (int) $value;
    }
}

if (!function_exists('stockopname_decimal')) {
    function stockopname_decimal($value)
    {
        $value = str_replace(',', '.', trim((string) $value));
        return is_numeric($value) ? (float) $value : 0;
    }
}

if (!function_exists('stockopname_badge')) {
    function stockopname_badge($active)
    {
        return ((int) $active === 1)
            ? '<span class="badge badge-success">Aktif</span>'
            : '<span class="badge badge-secondary">Nonaktif</span>';
    }
}
