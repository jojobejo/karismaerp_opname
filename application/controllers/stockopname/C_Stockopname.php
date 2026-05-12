<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Stockopname extends CI_Controller
{
    private $json_methods = array(
        'process', 'login_process', 'dashboard_stats', 'dashboard_chart',
        'barang_datatable', 'barang_show', 'barang_store', 'barang_delete', 'barang_import', 'barang_search', 'barang_all', 'barang_generate_codes',
        'gudang_datatable', 'gudang_show', 'gudang_store', 'gudang_delete', 'gudang_search',
        'lokasi_datatable', 'lokasi_show', 'lokasi_store', 'lokasi_delete', 'lokasi_search',
        'saldo_import',
        'session_datatable', 'session_show', 'session_store', 'session_close', 'session_select',
        'assignment_datatable', 'assignment_store', 'assignment_delete', 'checker_select',
        'opname_assignments', 'opname_stock_lookup', 'opname_save_input',
        'compare_datatable', 'compare_generate', 'compare_recheck', 'compare_approve',
        'audit_datatable',
        'supplier_select', 'warehouse_select', 'location_select'
    );

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library(array('session', 'form_validation', 'upload'));
        $this->load->helper(array('url', 'security', 'stockopname'));
        $this->load->model('stockopname/M_Stockopname', 'stockopname');

        $method = $this->router->fetch_method();
        if (!in_array($method, array('login', 'process', 'login_process', 'logout'), true)) {
            $this->require_auth(in_array($method, $this->json_methods, true));
        }
    }

    public function index()
    {
        $data = array(
            'page_title' => 'Stock Opname',
            'user' => $this->current_user(),
            'asset_version' => date('YmdHis')
        );
        $this->load->view('content/stockopname/app', $data);
    }

    public function login()
    {
        if ($this->is_authenticated()) {
            redirect('stockopname');
            return;
        }

        $this->load->view('content/stockopname/login', array(
            'page_title' => 'Login Stock Opname',
            'asset_version' => date('YmdHis')
        ));
    }

    public function login_process()
    {
        $username = trim((string) ($this->input->post('username', true) ?: $this->input->post('user_isi', true)));
        $password = (string) ($this->input->post('password', true) ?: $this->input->post('pass_isi', true));
        $remember = (int) $this->input->post('remember', true) === 1;

        if ($username === '' || $password === '') {
            return $this->json(false, 'Username dan password wajib diisi.');
        }

        $user = $this->stockopname->get_user_by_username($username);
        if (!$user || !password_verify($password, $user->password)) {
            $legacy = $this->stockopname->get_legacy_user_by_username($username);
            if (!$legacy || !password_verify($password, $legacy->password)) {
                return $this->json(false, 'Username atau password tidak sesuai.');
            }

            $this->session->set_userdata('logged_in', true);
            $this->session->set_userdata(array(
                'id' => isset($legacy->id) ? $legacy->id : null,
                'nik' => isset($legacy->nik) ? $legacy->nik : null,
                'departemen' => isset($legacy->departemen) ? $legacy->departemen : null,
                'lv' => isset($legacy->akses_lv) ? $legacy->akses_lv : null,
                'jobdesk' => isset($legacy->jobdesk) ? $legacy->jobdesk : 'STOCKOPNAME',
                'nama' => isset($legacy->nm_karyawan) ? $legacy->nm_karyawan : $legacy->username,
                'tim' => isset($legacy->tim) ? $legacy->tim : null,
                'username' => $legacy->username,
                'wilayah' => isset($legacy->wilayah) ? $legacy->wilayah : null
            ));

            return $this->json(true, 'Login berhasil menggunakan akun utama.', array('redirect' => site_url('stockopname')));
        }

        $session = array(
            'stockopname_logged_in' => true,
            'stockopname_user_id' => (int) $user->id,
            'stockopname_role_id' => (int) $user->role_id,
            'stockopname_role' => $user->role_name,
            'stockopname_name' => $user->full_name,
            'stockopname_username' => $user->username,
            'stockopname_remember' => $remember
        );

        $this->session->set_userdata($session);

        $this->stockopname->log_activity($user->id, 'AUTH', 'LOGIN', 'tbopname_user', $user->id, 'Login stock opname');
        return $this->json(true, 'Login berhasil.', array('redirect' => site_url('stockopname')));
    }

    public function process()
    {
        return $this->login_process();
    }

    public function logout()
    {
        $user = $this->current_user();
        if (!empty($user['id'])) {
            $this->stockopname->log_activity($user['id'], 'AUTH', 'LOGOUT', 'tbopname_user', $user['id'], 'Logout stock opname');
        }

        $keys = array('stockopname_logged_in', 'stockopname_user_id', 'stockopname_role_id', 'stockopname_role', 'stockopname_name', 'stockopname_username', 'stockopname_remember');
        $this->session->unset_userdata($keys);
        redirect('stockopname/login');
    }

    public function dashboard_stats()
    {
        return $this->json(true, 'OK', $this->stockopname->dashboard_stats());
    }

    public function dashboard_chart()
    {
        return $this->json(true, 'OK', $this->stockopname->dashboard_chart());
    }

    public function barang_datatable()
    {
        $result = $this->stockopname->datatable_items($this->input->post(null, true));
        return $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function barang_show($id)
    {
        $row = $this->stockopname->get_item((int) $id);
        return $this->json((bool) $row, $row ? 'OK' : 'Data barang tidak ditemukan.', $row);
    }

    public function barang_store()
    {
        $id = (int) $this->input->post('id', true);
        $payload = $this->item_payload();
        $errors = $this->validate_item($payload, $id);
        if ($errors) {
            return $this->json(false, 'Periksa kembali form barang.', array('errors' => $errors));
        }

        $result = $this->stockopname->save_item($payload, $id, $this->current_user_id());
        return $this->json($result['status'], $result['message'], isset($result['data']) ? $result['data'] : array());
    }

    public function barang_delete()
    {
        $id = (int) $this->input->post('id', true);
        $result = $this->stockopname->delete_item($id, $this->current_user_id());
        return $this->json($result['status'], $result['message']);
    }

    public function barang_import()
    {
        if (empty($_FILES['file']['tmp_name'])) {
            return $this->json(false, 'File import belum dipilih.');
        }

        $result = $this->stockopname->import_items($_FILES['file'], $this->current_user_id());
        return $this->json($result['status'], $result['message'], isset($result['data']) ? $result['data'] : array());
    }

    public function barang_generate_codes()
    {
        $payload = $this->item_payload();
        return $this->json(true, 'Kode berhasil dibuat.', $this->stockopname->generate_item_codes($payload));
    }

    public function saldo_import()
    {
        if (empty($_FILES['file']['tmp_name'])) {
            return $this->json(false, 'File saldo awal belum dipilih.');
        }

        $result = $this->stockopname->import_initial_stock($_FILES['file'], $this->current_user_id());
        return $this->json($result['status'], $result['message'], isset($result['data']) ? $result['data'] : array());
    }

    public function session_datatable()
    {
        $result = $this->stockopname->datatable_sessions($this->input->post(null, true));
        return $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function session_show($id)
    {
        $row = $this->stockopname->get_session((int) $id);
        return $this->json((bool) $row, $row ? 'OK' : 'Sesi opname tidak ditemukan.', $row);
    }

    public function session_store()
    {
        $id = (int) $this->input->post('id', true);
        $payload = array(
            'session_code' => stockopname_clean($this->input->post('session_code', true)),
            'session_name' => stockopname_clean($this->input->post('session_name', true)),
            'start_date' => stockopname_clean($this->input->post('start_date', true)),
            'end_date' => stockopname_nullable_text($this->input->post('end_date', true)),
            'status' => stockopname_clean($this->input->post('status', true)) ?: 'OPEN',
            'created_by' => $this->current_user_id()
        );
        $errors = $this->validate_session_payload($payload, $id);
        if ($errors) {
            return $this->json(false, 'Periksa kembali form sesi opname.', array('errors' => $errors));
        }
        $result = $this->stockopname->save_session($payload, $id, $this->current_user_id());
        return $this->json($result['status'], $result['message'], isset($result['data']) ? $result['data'] : array());
    }

    public function session_close()
    {
        $id = (int) $this->input->post('id', true);
        $result = $this->stockopname->close_session($id, $this->current_user_id());
        return $this->json($result['status'], $result['message']);
    }

    public function session_select()
    {
        return $this->json(true, 'OK', $this->stockopname->search_sessions(trim((string) $this->input->get('q', true))));
    }

    public function assignment_datatable()
    {
        $result = $this->stockopname->datatable_assignments($this->input->post(null, true));
        return $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function assignment_store()
    {
        $payload = array(
            'session_id' => (int) $this->input->post('session_id', true),
            'location_id' => (int) $this->input->post('location_id', true),
            'user_checker_1' => (int) $this->input->post('user_checker_1', true),
            'user_checker_2' => (int) $this->input->post('user_checker_2', true)
        );
        $errors = $this->validate_assignment_payload($payload);
        if ($errors) {
            return $this->json(false, 'Periksa kembali assignment checker.', array('errors' => $errors));
        }
        $result = $this->stockopname->save_assignment($payload, $this->current_user_id());
        return $this->json($result['status'], $result['message'], isset($result['data']) ? $result['data'] : array());
    }

    public function assignment_delete()
    {
        $result = $this->stockopname->delete_assignment((int) $this->input->post('id', true), $this->current_user_id());
        return $this->json($result['status'], $result['message']);
    }

    public function opname_assignments()
    {
        return $this->json(true, 'OK', $this->stockopname->get_user_assignments($this->current_user_id()));
    }

    public function opname_stock_lookup()
    {
        $assignment_id = (int) $this->input->get('assignment_id', true);
        $term = trim((string) $this->input->get('q', true));
        return $this->json(true, 'OK', $this->stockopname->lookup_stock_for_input($assignment_id, $term));
    }

    public function opname_save_input()
    {
        $payload = array(
            'assignment_id' => (int) $this->input->post('assignment_id', true),
            'stock_id' => (int) $this->input->post('stock_id', true),
            'qty_input' => stockopname_decimal($this->input->post('qty_input', true)),
            'scan_code' => stockopname_nullable_text($this->input->post('scan_code', true)),
            'input_type' => stockopname_clean($this->input->post('input_type', true)) ?: 'SEARCH',
            'device_id' => stockopname_nullable_text($this->input->post('device_id', true))
        );
        $result = $this->stockopname->save_opname_input($payload, $this->current_user_id());
        return $this->json($result['status'], $result['message'], isset($result['data']) ? $result['data'] : array());
    }

    public function compare_datatable()
    {
        $result = $this->stockopname->datatable_compare($this->input->post(null, true));
        return $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function compare_generate()
    {
        $result = $this->stockopname->generate_compare((int) $this->input->post('session_id', true), $this->current_user_id());
        return $this->json($result['status'], $result['message'], isset($result['data']) ? $result['data'] : array());
    }

    public function compare_recheck()
    {
        $result = $this->stockopname->mark_compare_recheck((int) $this->input->post('id', true), $this->current_user_id());
        return $this->json($result['status'], $result['message']);
    }

    public function compare_approve()
    {
        $result = $this->stockopname->approve_compare((int) $this->input->post('id', true), stockopname_decimal($this->input->post('qty_final', true)), $this->current_user_id());
        return $this->json($result['status'], $result['message']);
    }

    public function audit_datatable()
    {
        $result = $this->stockopname->datatable_audit($this->input->post(null, true));
        return $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function export_report()
    {
        $session_id = (int) $this->input->get('session_id', true);
        $rows = $this->stockopname->export_compare_rows($session_id);
        $filename = 'stockopname_report_' . date('Ymd_His') . '.csv';
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $out = fopen('php://output', 'w');
        fputcsv($out, array('session', 'item_code', 'item_name', 'warehouse', 'location', 'lot', 'expired_date', 'qty_system', 'qty_checker_1', 'qty_checker_2', 'qty_final', 'match', 'recheck'));
        foreach ($rows as $row) {
            fputcsv($out, array($row->session_code, $row->item_code, $row->item_name, $row->warehouse_name, $row->location_code, $row->lot_number, $row->expired_date, $row->qty_system, $row->qty_user_1, $row->qty_user_2, $row->qty_final, $row->is_match, $row->need_recheck));
        }
        fclose($out);
        exit;
    }

    public function barang_search()
    {
        $term = trim((string) $this->input->get('q', true));
        return $this->json(true, 'OK', $this->stockopname->search_items($term));
    }

    public function barang_all()
    {
        return $this->json(true, 'OK', $this->stockopname->get_all_items_for_print());
    }

    public function gudang_datatable()
    {
        $result = $this->stockopname->datatable_warehouses($this->input->post(null, true));
        return $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function gudang_show($id)
    {
        $row = $this->stockopname->get_warehouse((int) $id);
        return $this->json((bool) $row, $row ? 'OK' : 'Data gudang tidak ditemukan.', $row);
    }

    public function gudang_store()
    {
        $id = (int) $this->input->post('id', true);
        $payload = $this->warehouse_payload();
        $errors = $this->validate_warehouse($payload, $id);
        if ($errors) {
            return $this->json(false, 'Periksa kembali form gudang.', array('errors' => $errors));
        }

        $result = $this->stockopname->save_warehouse($payload, $id, $this->current_user_id());
        return $this->json($result['status'], $result['message'], isset($result['data']) ? $result['data'] : array());
    }

    public function gudang_delete()
    {
        $id = (int) $this->input->post('id', true);
        $result = $this->stockopname->delete_warehouse($id, $this->current_user_id());
        return $this->json($result['status'], $result['message']);
    }

    public function gudang_search()
    {
        $term = trim((string) $this->input->get('q', true));
        return $this->json(true, 'OK', $this->stockopname->search_warehouses($term));
    }

    public function lokasi_datatable()
    {
        $result = $this->stockopname->datatable_locations($this->input->post(null, true));
        return $this->output->set_content_type('application/json')->set_output(json_encode($result));
    }

    public function lokasi_show($id)
    {
        $row = $this->stockopname->get_location((int) $id);
        return $this->json((bool) $row, $row ? 'OK' : 'Data lokasi tidak ditemukan.', $row);
    }

    public function lokasi_store()
    {
        $id = (int) $this->input->post('id', true);
        $payload = $this->location_payload();
        $errors = $this->validate_location($payload, $id);
        if ($errors) {
            return $this->json(false, 'Periksa kembali form lokasi.', array('errors' => $errors));
        }

        $result = $this->stockopname->save_location($payload, $id, $this->current_user_id());
        return $this->json($result['status'], $result['message'], isset($result['data']) ? $result['data'] : array());
    }

    public function lokasi_delete()
    {
        $id = (int) $this->input->post('id', true);
        $result = $this->stockopname->delete_location($id, $this->current_user_id());
        return $this->json($result['status'], $result['message']);
    }

    public function lokasi_search()
    {
        $term = trim((string) $this->input->get('q', true));
        $warehouse_id = (int) $this->input->get('warehouse_id', true);
        return $this->json(true, 'OK', $this->stockopname->search_locations($term, $warehouse_id));
    }

    public function supplier_select()
    {
        $term = trim((string) $this->input->get('q', true));
        return $this->json(true, 'OK', $this->stockopname->search_suppliers($term));
    }

    public function warehouse_select()
    {
        $term = trim((string) $this->input->get('q', true));
        return $this->json(true, 'OK', $this->stockopname->search_warehouses($term, true));
    }

    public function location_select()
    {
        $term = trim((string) $this->input->get('q', true));
        $warehouse_id = (int) $this->input->get('warehouse_id', true);
        return $this->json(true, 'OK', $this->stockopname->search_locations($term, $warehouse_id));
    }

    public function checker_select()
    {
        $term = trim((string) $this->input->get('q', true));
        return $this->json(true, 'OK', $this->stockopname->search_checkers($term));
    }

    private function item_payload()
    {
        return array(
            'kd_barang' => stockopname_clean($this->input->post('kd_barang', true)),
            'kode_barang_system' => stockopname_clean($this->input->post('kode_barang_system', true)),
            'barcode' => stockopname_nullable_text($this->input->post('barcode', true)),
            'qrcode' => stockopname_nullable_text($this->input->post('qrcode', true)),
            'nama_barang' => stockopname_clean($this->input->post('nama_barang', true)),
            'satuan' => stockopname_clean($this->input->post('satuan', true)),
            'p' => max(0, (int) stockopname_decimal($this->input->post('p', true))),
            'l' => max(0, (int) stockopname_decimal($this->input->post('l', true))),
            't' => max(0, (int) stockopname_decimal($this->input->post('t', true))),
            'berat' => max(0, (int) stockopname_decimal($this->input->post('berat', true)))
        );
    }

    private function warehouse_payload()
    {
        $payload = array(
            'warehouse_code' => stockopname_clean($this->input->post('warehouse_code', true)),
            'warehouse_name' => stockopname_clean($this->input->post('warehouse_name', true))
        );

        if ($this->stockopname->column_exists('tbopname_warehouse', 'is_active')) {
            $payload['is_active'] = (int) $this->input->post('is_active', true) === 1 ? 1 : 0;
        }

        return $payload;
    }

    private function location_payload()
    {
        return array(
            'warehouse_id' => (int) $this->input->post('warehouse_id', true),
            'location_code' => stockopname_clean($this->input->post('location_code', true)),
            'location_name' => stockopname_clean($this->input->post('location_name', true)),
            'qr_location' => stockopname_nullable_text($this->input->post('qr_location', true)),
            'is_active' => (int) $this->input->post('is_active', true) === 1 ? 1 : 0
        );
    }

    private function validate_item($payload, $id)
    {
        $errors = array();
        if ($payload['kd_barang'] === '') {
            $errors['kd_barang'] = 'Kode barang wajib diisi.';
        }
        if ($payload['kode_barang_system'] === '') {
            $errors['kode_barang_system'] = 'Kode barang system wajib diisi.';
        }
        if ($payload['nama_barang'] === '') {
            $errors['nama_barang'] = 'Nama barang wajib diisi.';
        }
        if ($payload['satuan'] === '') {
            $errors['satuan'] = 'Satuan wajib diisi.';
        }
        if ($payload['kd_barang'] !== '' && $this->stockopname->exists_except('tb_master_barang_all', 'kd_barang', $payload['kd_barang'], $id)) {
            $errors['kd_barang'] = 'Kode barang sudah digunakan.';
        }
        if ($payload['kode_barang_system'] !== '' && $this->stockopname->exists_except('tb_master_barang_all', 'kode_barang_system', $payload['kode_barang_system'], $id)) {
            $errors['kode_barang_system'] = 'Kode barang system sudah digunakan.';
        }
        if ($payload['barcode'] && $this->stockopname->item_column_exists('barcode') && $this->stockopname->exists_except('tb_master_barang_all', 'barcode', $payload['barcode'], $id)) {
            $errors['barcode'] = 'Barcode sudah digunakan.';
        }
        if ($payload['qrcode'] && $this->stockopname->item_column_exists('qrcode') && $this->stockopname->exists_except('tb_master_barang_all', 'qrcode', $payload['qrcode'], $id)) {
            $errors['qrcode'] = 'QRCode sudah digunakan.';
        }
        return $errors;
    }

    private function validate_warehouse($payload, $id)
    {
        $errors = array();
        if ($payload['warehouse_code'] === '') {
            $errors['warehouse_code'] = 'Kode gudang wajib diisi.';
        }
        if ($payload['warehouse_name'] === '') {
            $errors['warehouse_name'] = 'Nama gudang wajib diisi.';
        }
        if ($payload['warehouse_code'] !== '' && $this->stockopname->exists_except('tbopname_warehouse', 'warehouse_code', $payload['warehouse_code'], $id)) {
            $errors['warehouse_code'] = 'Kode gudang sudah digunakan.';
        }
        return $errors;
    }

    private function validate_location($payload, $id)
    {
        $errors = array();
        if ($payload['warehouse_id'] <= 0 || !$this->stockopname->row_exists('tbopname_warehouse', $payload['warehouse_id'])) {
            $errors['warehouse_id'] = 'Gudang wajib dipilih.';
        }
        if ($payload['location_code'] === '') {
            $errors['location_code'] = 'Kode lokasi wajib diisi.';
        }
        if ($payload['location_name'] === '') {
            $errors['location_name'] = 'Nama lokasi wajib diisi.';
        }
        if ($payload['location_code'] !== '' && $this->stockopname->exists_except('tbopname_location', 'location_code', $payload['location_code'], $id)) {
            $errors['location_code'] = 'Kode lokasi sudah digunakan.';
        }
        return $errors;
    }

    private function validate_session_payload($payload, $id)
    {
        $errors = array();
        if ($payload['session_code'] === '') {
            $errors['session_code'] = 'Kode sesi wajib diisi.';
        }
        if ($payload['session_name'] === '') {
            $errors['session_name'] = 'Nama sesi wajib diisi.';
        }
        if ($payload['start_date'] === '') {
            $errors['start_date'] = 'Tanggal mulai wajib diisi.';
        }
        if (!in_array($payload['status'], array('OPEN', 'PROGRESS', 'RECHECK', 'DONE', 'CLOSED'), true)) {
            $errors['status'] = 'Status sesi tidak valid.';
        }
        if ($payload['session_code'] !== '' && $this->stockopname->exists_except('tbopname_session', 'session_code', $payload['session_code'], $id)) {
            $errors['session_code'] = 'Kode sesi sudah digunakan.';
        }
        if (!$payload['created_by'] || !$this->stockopname->row_exists('tbopname_user', $payload['created_by'])) {
            $errors['created_by'] = 'User login belum terhubung ke tbopname_user.';
        }
        return $errors;
    }

    private function validate_assignment_payload($payload)
    {
        $errors = array();
        if (!$this->stockopname->row_exists('tbopname_session', $payload['session_id'])) {
            $errors['session_id'] = 'Sesi opname wajib dipilih.';
        }
        if (!$this->stockopname->row_exists('tbopname_location', $payload['location_id'])) {
            $errors['location_id'] = 'Lokasi wajib dipilih.';
        }
        if (!$this->stockopname->row_exists('tbopname_user', $payload['user_checker_1'])) {
            $errors['user_checker_1'] = 'Checker 1 wajib dipilih.';
        }
        if (!$this->stockopname->row_exists('tbopname_user', $payload['user_checker_2'])) {
            $errors['user_checker_2'] = 'Checker 2 wajib dipilih.';
        }
        if ($payload['user_checker_1'] === $payload['user_checker_2']) {
            $errors['user_checker_2'] = 'Checker 2 harus berbeda dari checker 1.';
        }
        return $errors;
    }

    private function require_auth($json = false)
    {
        if ($this->is_authenticated()) {
            return;
        }

        if ($json || $this->input->is_ajax_request()) {
            $this->json(false, 'Sesi login berakhir. Silakan login kembali.', array('redirect' => site_url('stockopname/login')), 401);
            exit;
        }

        redirect('stockopname/login');
        exit;
    }

    private function is_authenticated()
    {
        if ($this->session->userdata('stockopname_logged_in')) {
            return true;
        }

        $legacy_jobdesk = strtoupper((string) $this->session->userdata('jobdesk'));
        return $this->session->userdata('logged_in') && in_array($legacy_jobdesk, array('STOCKOPNAME', 'SUPERVISI', 'ADMINICS'), true);
    }

    private function current_user()
    {
        if ($this->session->userdata('stockopname_logged_in')) {
            return array(
                'id' => (int) $this->session->userdata('stockopname_user_id'),
                'name' => $this->session->userdata('stockopname_name'),
                'username' => $this->session->userdata('stockopname_username'),
                'role' => $this->session->userdata('stockopname_role')
            );
        }

        return array(
            'id' => null,
            'name' => $this->session->userdata('nama') ?: 'User Stock Opname',
            'username' => $this->session->userdata('username'),
            'role' => $this->session->userdata('jobdesk') ?: 'LEGACY'
        );
    }

    private function current_user_id()
    {
        $user = $this->current_user();
        if (!empty($user['id'])) {
            return (int) $user['id'];
        }

        $username = $this->session->userdata('username');
        if ($username) {
            $mapped = $this->stockopname->get_user_by_username($username);
            if ($mapped) {
                return (int) $mapped->id;
            }
        }

        return null;
    }

    private function json($status, $message, $data = array(), $http_code = 200)
    {
        return stockopname_json($this, $status, $message, $data, $http_code);
    }
}
