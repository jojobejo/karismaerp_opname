<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_Stockopname extends CI_Model
{
    private $column_cache = array();

    public function column_exists($table, $column)
    {
        $key = $table . '.' . $column;
        if (!array_key_exists($key, $this->column_cache)) {
            $this->column_cache[$key] = $this->db->field_exists($column, $table);
        }
        return $this->column_cache[$key];
    }

    public function row_exists($table, $id)
    {
        return $this->db->where('id', (int) $id)->count_all_results($table) > 0;
    }

    public function exists_except($table, $field, $value, $except_id = 0)
    {
        $this->db->where($field, $value);
        if ((int) $except_id > 0) {
            $this->db->where('id !=', (int) $except_id);
        }
        return $this->db->count_all_results($table) > 0;
    }

    public function get_user_by_username($username)
    {
        return $this->db
            ->select('u.*, r.role_name')
            ->from('tbopname_user u')
            ->join('tbopname_role r', 'r.id = u.role_id', 'left')
            ->where('u.username', $username)
            ->where('u.is_active', 1)
            ->get()
            ->row();
    }

    public function get_legacy_user_by_username($username)
    {
        if (!$this->db->table_exists('tb_karyawan')) {
            return null;
        }

        return $this->db
            ->where('username', $username)
            ->get('tb_karyawan')
            ->row();
    }

    public function dashboard_stats()
    {
        $warehouse_active = $this->column_exists('tbopname_warehouse', 'is_active')
            ? $this->db->where('is_active', 1)->count_all_results('tbopname_warehouse')
            : $this->db->count_all('tbopname_warehouse');

        return array(
            'items' => (int) $this->db->count_all('tbopname_item'),
            'items_active' => (int) $this->db->where('is_active', 1)->count_all_results('tbopname_item'),
            'warehouses' => (int) $this->db->count_all('tbopname_warehouse'),
            'warehouses_active' => (int) $warehouse_active,
            'locations' => (int) $this->db->count_all('tbopname_location'),
            'locations_active' => (int) $this->db->where('is_active', 1)->count_all_results('tbopname_location'),
            'sessions_open' => (int) $this->db->where_in('status', array('OPEN', 'PROGRESS', 'RECHECK'))->count_all_results('tbopname_session'),
            'assignments_pending' => (int) $this->db->where_in('status', array('PENDING', 'PROCESS', 'RECHECK'))->count_all_results('tbopname_assignment'),
            'compare_recheck' => (int) $this->db->where('need_recheck', 1)->count_all_results('tbopname_compare')
        );
    }

    public function dashboard_chart()
    {
        return array(
            'match' => (int) $this->db->where('is_match', 1)->count_all_results('tbopname_compare'),
            'discrepancy' => (int) $this->db->where('is_match', 0)->count_all_results('tbopname_compare'),
            'recheck' => (int) $this->db->where('need_recheck', 1)->count_all_results('tbopname_compare'),
            'approved' => (int) $this->db->where('approved_by IS NOT NULL', null, false)->count_all_results('tbopname_compare')
        );
    }

    public function datatable_items($request)
    {
        $columns = array('i.item_code', 'i.item_name', 'i.barcode', 's.supplier_name', 'i.unit', 'i.minimum_stock', 'i.is_active');
        $builder = function () {
            $this->db
                ->select('i.*, s.supplier_name')
                ->from('tbopname_item i')
                ->join('tbopname_supplier s', 's.id = i.supplier_id', 'left');
        };
        $search = array('i.item_code', 'i.item_name', 'i.barcode', 'i.qrcode', 'i.unit', 's.supplier_name');

        return $this->datatable($request, $columns, $builder, $search, function ($row) {
            return array(
                html_escape($row->item_code),
                '<div class="font-weight-600">' . html_escape($row->item_name) . '</div><small class="text-muted">QR: ' . html_escape($row->qrcode ?: '-') . '</small>',
                html_escape($row->barcode ?: '-'),
                html_escape($row->supplier_name ?: '-'),
                html_escape($row->unit),
                number_format((float) $row->minimum_stock, 0, ',', '.'),
                stockopname_badge($row->is_active),
                $this->row_actions($row->id, 'barang')
            );
        });
    }

    public function get_item($id)
    {
        return $this->db
            ->select('i.*, s.supplier_name')
            ->from('tbopname_item i')
            ->join('tbopname_supplier s', 's.id = i.supplier_id', 'left')
            ->where('i.id', (int) $id)
            ->get()
            ->row();
    }

    public function save_item($data, $id = 0, $user_id = null)
    {
        $this->db->trans_begin();
        if ((int) $id > 0) {
            $this->db->where('id', (int) $id)->update('tbopname_item', $data);
            $message = 'Barang berhasil diperbarui.';
            $activity = 'UPDATE';
        } else {
            $this->db->insert('tbopname_item', $data);
            $id = $this->db->insert_id();
            $message = 'Barang berhasil ditambahkan.';
            $activity = 'CREATE';
        }

        $this->log_activity($user_id, 'MASTER_BARANG', $activity, 'tbopname_item', $id, $message);
        return $this->complete_transaction($message, array('id' => (int) $id));
    }

    public function delete_item($id, $user_id = null)
    {
        $this->db->trans_begin();
        if ($this->count_item_references($id) > 0) {
            $this->db->where('id', (int) $id)->update('tbopname_item', array('is_active' => 0));
            $this->log_activity($user_id, 'MASTER_BARANG', 'DEACTIVATE', 'tbopname_item', $id, 'Barang dinonaktifkan karena masih dipakai transaksi.');
            return $this->complete_transaction('Barang masih dipakai transaksi, status diubah menjadi nonaktif.');
        }

        $this->db->where('id', (int) $id)->delete('tbopname_item');
        $this->log_activity($user_id, 'MASTER_BARANG', 'DELETE', 'tbopname_item', $id, 'Barang dihapus.');
        return $this->complete_transaction('Barang berhasil dihapus.');
    }

    public function import_items($file, $user_id = null)
    {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, array('csv', 'txt'), true)) {
            return array('status' => false, 'message' => 'Import Excel membutuhkan reader PhpSpreadsheet. Gunakan CSV untuk import cepat di instalasi ini.');
        }

        $handle = fopen($file['tmp_name'], 'r');
        if (!$handle) {
            return array('status' => false, 'message' => 'File import tidak dapat dibaca.');
        }

        $inserted = 0;
        $updated = 0;
        $skipped = 0;
        $headers = array();
        $line = 0;

        $this->db->trans_begin();
        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $line++;
            if ($line === 1) {
                $headers = $this->normalize_import_headers($row);
                if (in_array('item_code', $headers, true)) {
                    continue;
                }
                $headers = array('item_code', 'item_name', 'unit', 'barcode', 'qrcode', 'minimum_stock', 'supplier_code');
            }

            $mapped = $this->map_import_row($headers, $row);
            if (empty($mapped['item_code']) || empty($mapped['item_name']) || empty($mapped['unit'])) {
                $skipped++;
                continue;
            }

            $supplier_id = null;
            if (!empty($mapped['supplier_code'])) {
                $supplier_id = $this->supplier_id_by_code($mapped['supplier_code']);
            }

            $payload = array(
                'supplier_id' => $supplier_id,
                'item_code' => $mapped['item_code'],
                'barcode' => !empty($mapped['barcode']) ? $mapped['barcode'] : null,
                'qrcode' => !empty($mapped['qrcode']) ? $mapped['qrcode'] : null,
                'item_name' => $mapped['item_name'],
                'unit' => $mapped['unit'],
                'minimum_stock' => isset($mapped['minimum_stock']) ? (int) $mapped['minimum_stock'] : 0,
                'is_active' => 1
            );

            $existing = $this->db->select('id')->where('item_code', $payload['item_code'])->get('tbopname_item')->row();
            if ($existing) {
                $this->db->where('id', $existing->id)->update('tbopname_item', $payload);
                $updated++;
            } else {
                $this->db->insert('tbopname_item', $payload);
                $inserted++;
            }
        }
        fclose($handle);

        $message = 'Import selesai. Tambah: ' . $inserted . ', update: ' . $updated . ', dilewati: ' . $skipped . '.';
        $this->log_activity($user_id, 'MASTER_BARANG', 'IMPORT', 'tbopname_item', null, $message);
        $result = $this->complete_transaction($message, compact('inserted', 'updated', 'skipped'));
        return $result;
    }

    public function import_initial_stock($file, $user_id = null)
    {
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, array('csv', 'txt'), true)) {
            return array('status' => false, 'message' => 'Import saldo awal saat ini menggunakan CSV.');
        }

        $handle = fopen($file['tmp_name'], 'r');
        if (!$handle) {
            return array('status' => false, 'message' => 'File saldo awal tidak dapat dibaca.');
        }

        $headers = array();
        $line = 0;
        $inserted = 0;
        $updated = 0;
        $skipped = 0;
        $this->db->trans_begin();

        while (($row = fgetcsv($handle, 0, ',')) !== false) {
            $line++;
            if ($line === 1) {
                $headers = $this->normalize_import_headers($row);
                if (in_array('item_code', $headers, true)) {
                    continue;
                }
                $headers = array('item_code', 'warehouse_code', 'location_code', 'lot_number', 'expired_date', 'qty_system', 'qty_available');
            }

            $mapped = $this->map_import_row($headers, $row);
            $item = $this->find_id_by_code('tbopname_item', 'item_code', isset($mapped['item_code']) ? $mapped['item_code'] : '');
            $warehouse = $this->find_id_by_code('tbopname_warehouse', 'warehouse_code', isset($mapped['warehouse_code']) ? $mapped['warehouse_code'] : '');
            $location = $this->find_id_by_code('tbopname_location', 'location_code', isset($mapped['location_code']) ? $mapped['location_code'] : '');
            if (!$item || !$warehouse || !$location || empty($mapped['lot_number']) || empty($mapped['expired_date'])) {
                $skipped++;
                continue;
            }

            $payload = array(
                'item_id' => $item,
                'warehouse_id' => $warehouse,
                'location_id' => $location,
                'lot_number' => $mapped['lot_number'],
                'expired_date' => $mapped['expired_date'],
                'qty_system' => isset($mapped['qty_system']) ? (float) str_replace(',', '.', $mapped['qty_system']) : 0,
                'qty_available' => isset($mapped['qty_available']) && $mapped['qty_available'] !== '' ? (float) str_replace(',', '.', $mapped['qty_available']) : (isset($mapped['qty_system']) ? (float) str_replace(',', '.', $mapped['qty_system']) : 0)
            );

            $existing = $this->db
                ->select('id')
                ->where('item_id', $item)
                ->where('location_id', $location)
                ->where('lot_number', $payload['lot_number'])
                ->where('expired_date', $payload['expired_date'])
                ->get('tbopname_stock')
                ->row();
            if ($existing) {
                $this->db->where('id', $existing->id)->update('tbopname_stock', $payload);
                $updated++;
            } else {
                $this->db->insert('tbopname_stock', $payload);
                $inserted++;
            }
        }
        fclose($handle);

        $message = 'Import saldo awal selesai. Tambah: ' . $inserted . ', update: ' . $updated . ', dilewati: ' . $skipped . '.';
        $this->log_activity($user_id, 'SALDO_AWAL', 'IMPORT', 'tbopname_stock', null, $message);
        return $this->complete_transaction($message, compact('inserted', 'updated', 'skipped'));
    }

    public function datatable_sessions($request)
    {
        $columns = array('s.session_code', 's.session_name', 's.start_date', 's.status', 'u.full_name');
        $builder = function () {
            $this->db
                ->select('s.*, u.full_name AS creator_name')
                ->from('tbopname_session s')
                ->join('tbopname_user u', 'u.id = s.created_by', 'left');
        };

        return $this->datatable($request, $columns, $builder, array('s.session_code', 's.session_name', 's.status', 'u.full_name'), function ($row) {
            return array(
                html_escape($row->session_code),
                html_escape($row->session_name),
                html_escape(date('d/m/Y H:i', strtotime($row->start_date))),
                html_escape($row->end_date ? date('d/m/Y H:i', strtotime($row->end_date)) : '-'),
                $this->status_badge($row->status),
                html_escape($row->creator_name ?: '-'),
                '<div class="btn-group btn-group-sm"><button class="btn btn-outline-primary js-edit-session" data-id="' . (int) $row->id . '"><i class="fas fa-pen"></i></button><button class="btn btn-outline-dark js-close-session" data-id="' . (int) $row->id . '"><i class="fas fa-lock"></i></button></div>'
            );
        });
    }

    public function get_session($id)
    {
        return $this->db->where('id', (int) $id)->get('tbopname_session')->row();
    }

    public function save_session($data, $id = 0, $user_id = null)
    {
        $this->db->trans_begin();
        if ((int) $id > 0) {
            unset($data['created_by']);
            $this->db->where('id', (int) $id)->update('tbopname_session', $data);
            $message = 'Sesi opname berhasil diperbarui.';
            $activity = 'UPDATE';
        } else {
            $this->db->insert('tbopname_session', $data);
            $id = $this->db->insert_id();
            $message = 'Sesi opname berhasil dibuat.';
            $activity = 'CREATE';
        }
        $this->log_activity($user_id, 'SESSION_OPNAME', $activity, 'tbopname_session', $id, $message);
        return $this->complete_transaction($message, array('id' => (int) $id));
    }

    public function close_session($id, $user_id = null)
    {
        $this->db->trans_begin();
        $this->db->where('id', (int) $id)->update('tbopname_session', array('status' => 'CLOSED', 'end_date' => date('Y-m-d H:i:s')));
        $this->log_activity($user_id, 'SESSION_OPNAME', 'CLOSE', 'tbopname_session', $id, 'Sesi opname ditutup.');
        return $this->complete_transaction('Sesi opname berhasil ditutup.');
    }

    public function search_sessions($term)
    {
        $this->db->select('id, session_code, session_name, status')->from('tbopname_session')->where_in('status', array('OPEN', 'PROGRESS', 'RECHECK'));
        if ($term !== '') {
            $this->db->group_start()->like('session_code', $term)->or_like('session_name', $term)->group_end();
        }
        return $this->db->limit(20)->order_by('start_date', 'DESC')->get()->result();
    }

    public function datatable_assignments($request)
    {
        $columns = array('s.session_code', 'l.location_code', 'c1.full_name', 'c2.full_name', 'a.status');
        $builder = function () {
            $this->db
                ->select('a.*, s.session_code, s.session_name, l.location_code, l.location_name, w.warehouse_name, c1.full_name AS checker_1, c2.full_name AS checker_2')
                ->from('tbopname_assignment a')
                ->join('tbopname_session s', 's.id = a.session_id', 'inner')
                ->join('tbopname_location l', 'l.id = a.location_id', 'inner')
                ->join('tbopname_warehouse w', 'w.id = l.warehouse_id', 'inner')
                ->join('tbopname_user c1', 'c1.id = a.user_checker_1', 'inner')
                ->join('tbopname_user c2', 'c2.id = a.user_checker_2', 'inner');
        };
        return $this->datatable($request, $columns, $builder, array('s.session_code', 's.session_name', 'l.location_code', 'l.location_name', 'c1.full_name', 'c2.full_name'), function ($row) {
            return array(
                html_escape($row->session_code),
                html_escape($row->warehouse_name . ' / ' . $row->location_code),
                html_escape($row->checker_1),
                html_escape($row->checker_2),
                $this->status_badge($row->status),
                '<button class="btn btn-sm btn-outline-danger js-delete-assignment" data-id="' . (int) $row->id . '"><i class="fas fa-trash"></i></button>'
            );
        });
    }

    public function save_assignment($data, $user_id = null)
    {
        $this->db->trans_begin();
        $exists = $this->db->select('id')->where('session_id', $data['session_id'])->where('location_id', $data['location_id'])->get('tbopname_assignment')->row();
        if ($exists) {
            $this->db->where('id', $exists->id)->update('tbopname_assignment', $data);
            $id = $exists->id;
            $message = 'Assignment checker berhasil diperbarui.';
            $activity = 'UPDATE';
        } else {
            $data['status'] = 'PENDING';
            $this->db->insert('tbopname_assignment', $data);
            $id = $this->db->insert_id();
            $message = 'Assignment checker berhasil dibuat.';
            $activity = 'CREATE';
        }
        $this->log_activity($user_id, 'ASSIGNMENT', $activity, 'tbopname_assignment', $id, $message);
        return $this->complete_transaction($message, array('id' => (int) $id));
    }

    public function delete_assignment($id, $user_id = null)
    {
        if ($this->db->where('assignment_id', (int) $id)->count_all_results('tbopname_input') > 0) {
            return array('status' => false, 'message' => 'Assignment sudah memiliki input opname.');
        }
        $this->db->trans_begin();
        $this->db->where('id', (int) $id)->delete('tbopname_assignment');
        $this->log_activity($user_id, 'ASSIGNMENT', 'DELETE', 'tbopname_assignment', $id, 'Assignment dihapus.');
        return $this->complete_transaction('Assignment berhasil dihapus.');
    }

    public function get_user_assignments($user_id)
    {
        return $this->db
            ->select('a.id, a.status, s.session_code, s.session_name, l.location_code, l.location_name, w.warehouse_name')
            ->from('tbopname_assignment a')
            ->join('tbopname_session s', 's.id = a.session_id', 'inner')
            ->join('tbopname_location l', 'l.id = a.location_id', 'inner')
            ->join('tbopname_warehouse w', 'w.id = l.warehouse_id', 'inner')
            ->where_in('s.status', array('OPEN', 'PROGRESS', 'RECHECK'))
            ->group_start()
            ->where('a.user_checker_1', (int) $user_id)
            ->or_where('a.user_checker_2', (int) $user_id)
            ->group_end()
            ->order_by('s.start_date', 'DESC')
            ->get()
            ->result();
    }

    public function lookup_stock_for_input($assignment_id, $term)
    {
        $assignment = $this->get_assignment($assignment_id);
        if (!$assignment) {
            return array();
        }
        $this->db
            ->select('st.id, i.item_code, i.item_name, i.barcode, i.qrcode, st.lot_number, st.expired_date, st.qty_system, st.qty_available, l.location_code')
            ->from('tbopname_stock st')
            ->join('tbopname_item i', 'i.id = st.item_id', 'inner')
            ->join('tbopname_location l', 'l.id = st.location_id', 'inner')
            ->where('st.location_id', (int) $assignment->location_id);
        if ($term !== '') {
            $this->db->group_start()
                ->like('i.item_code', $term)
                ->or_like('i.item_name', $term)
                ->or_like('i.barcode', $term)
                ->or_like('i.qrcode', $term)
                ->or_like('st.lot_number', $term)
                ->group_end();
        }
        return $this->db->limit(30)->order_by('i.item_name', 'ASC')->get()->result();
    }

    public function save_opname_input($payload, $user_id)
    {
        $assignment = $this->get_assignment($payload['assignment_id']);
        $stock = $this->db->where('id', $payload['stock_id'])->get('tbopname_stock')->row();
        if (!$assignment || !$stock) {
            return array('status' => false, 'message' => 'Assignment atau stock tidak valid.');
        }
        if ((int) $assignment->user_checker_1 !== (int) $user_id && (int) $assignment->user_checker_2 !== (int) $user_id) {
            return array('status' => false, 'message' => 'User login bukan checker pada assignment ini.');
        }

        $data = array(
            'session_id' => (int) $assignment->session_id,
            'assignment_id' => (int) $assignment->id,
            'user_id' => (int) $user_id,
            'item_id' => (int) $stock->item_id,
            'warehouse_id' => (int) $stock->warehouse_id,
            'location_id' => (int) $stock->location_id,
            'lot_number' => $stock->lot_number,
            'expired_date' => $stock->expired_date,
            'qty_input' => (float) $payload['qty_input'],
            'scan_code' => $payload['scan_code'],
            'input_type' => in_array($payload['input_type'], array('SCAN', 'SEARCH', 'MANUAL'), true) ? $payload['input_type'] : 'SEARCH',
            'device_id' => $payload['device_id']
        );

        $this->db->trans_begin();
        $existing = $this->db
            ->select('id')
            ->where('assignment_id', $data['assignment_id'])
            ->where('user_id', $data['user_id'])
            ->where('item_id', $data['item_id'])
            ->where('location_id', $data['location_id'])
            ->where('lot_number', $data['lot_number'])
            ->where('expired_date', $data['expired_date'])
            ->get('tbopname_input')
            ->row();
        if ($existing) {
            $this->db->where('id', $existing->id)->update('tbopname_input', $data);
            $id = $existing->id;
        } else {
            $this->db->insert('tbopname_input', $data);
            $id = $this->db->insert_id();
        }
        $this->db->where('id', $assignment->id)->update('tbopname_assignment', array('status' => 'PROCESS'));
        $this->log_activity($user_id, 'INPUT_OPNAME', 'AUTOSAVE', 'tbopname_input', $id, 'Autosave qty opname.');
        return $this->complete_transaction('Qty opname tersimpan otomatis.', array('id' => (int) $id));
    }

    public function datatable_compare($request)
    {
        $session_id = isset($request['session_id']) ? (int) $request['session_id'] : 0;
        $columns = array('s.session_code', 'i.item_code', 'l.location_code', 'c.lot_number', 'c.expired_date', 'c.qty_system', 'c.qty_user_1', 'c.qty_user_2', 'c.is_match');
        $builder = function () use ($session_id) {
            $this->db
                ->select('c.*, s.session_code, i.item_code, i.item_name, w.warehouse_name, l.location_code')
                ->from('tbopname_compare c')
                ->join('tbopname_session s', 's.id = c.session_id', 'inner')
                ->join('tbopname_item i', 'i.id = c.item_id', 'inner')
                ->join('tbopname_warehouse w', 'w.id = c.warehouse_id', 'inner')
                ->join('tbopname_location l', 'l.id = c.location_id', 'inner');
            if ($session_id > 0) {
                $this->db->where('c.session_id', $session_id);
            }
        };
        return $this->datatable($request, $columns, $builder, array('s.session_code', 'i.item_code', 'i.item_name', 'l.location_code', 'c.lot_number'), function ($row) {
            $final = $row->qty_final === null ? max((float) $row->qty_user_1, (float) $row->qty_user_2) : (float) $row->qty_final;
            return array(
                html_escape($row->session_code),
                html_escape($row->item_code . ' - ' . $row->item_name),
                html_escape($row->warehouse_name . ' / ' . $row->location_code),
                html_escape($row->lot_number),
                html_escape($row->expired_date),
                number_format((float) $row->qty_system, 2, ',', '.'),
                number_format((float) $row->qty_user_1, 2, ',', '.'),
                number_format((float) $row->qty_user_2, 2, ',', '.'),
                $row->is_match ? '<span class="badge badge-success">Match</span>' : '<span class="badge badge-danger">Selisih</span>',
                '<div class="input-group input-group-sm"><input type="number" step="0.01" class="form-control js-final-qty" value="' . html_escape($final) . '"><div class="input-group-append"><button class="btn btn-outline-success js-approve-compare" data-id="' . (int) $row->id . '"><i class="fas fa-check"></i></button><button class="btn btn-outline-warning js-recheck-compare" data-id="' . (int) $row->id . '"><i class="fas fa-redo"></i></button></div></div>'
            );
        });
    }

    public function generate_compare($session_id, $user_id = null)
    {
        if (!$this->row_exists('tbopname_session', $session_id)) {
            return array('status' => false, 'message' => 'Sesi opname tidak valid.');
        }

        $stocks = $this->db
            ->select('st.*')
            ->from('tbopname_stock st')
            ->join('tbopname_assignment a', 'a.location_id = st.location_id', 'inner')
            ->where('a.session_id', (int) $session_id)
            ->group_by('st.item_id, st.warehouse_id, st.location_id, st.lot_number, st.expired_date')
            ->get()
            ->result();

        $this->db->trans_begin();
        $this->db->where('session_id', (int) $session_id)->delete('tbopname_compare');
        $count = 0;
        foreach ($stocks as $stock) {
            $assignment = $this->db->where('session_id', (int) $session_id)->where('location_id', (int) $stock->location_id)->get('tbopname_assignment')->row();
            if (!$assignment) {
                continue;
            }
            $qty1 = $this->sum_input($session_id, $assignment->user_checker_1, $stock);
            $qty2 = $this->sum_input($session_id, $assignment->user_checker_2, $stock);
            $match = ((float) $qty1 === (float) $qty2) && ((float) $qty1 === (float) $stock->qty_system);
            $this->db->insert('tbopname_compare', array(
                'session_id' => (int) $session_id,
                'item_id' => (int) $stock->item_id,
                'warehouse_id' => (int) $stock->warehouse_id,
                'location_id' => (int) $stock->location_id,
                'lot_number' => $stock->lot_number,
                'expired_date' => $stock->expired_date,
                'qty_system' => (float) $stock->qty_system,
                'qty_user_1' => (float) $qty1,
                'qty_user_2' => (float) $qty2,
                'qty_final' => $match ? (float) $qty1 : null,
                'is_match' => $match ? 1 : 0,
                'need_recheck' => $match ? 0 : 1
            ));
            $count++;
        }
        $this->log_activity($user_id, 'COMPARE', 'GENERATE', 'tbopname_compare', $session_id, 'Generate compare ' . $count . ' row.');
        return $this->complete_transaction('Compare checker berhasil dibuat: ' . $count . ' baris.', array('count' => $count));
    }

    public function mark_compare_recheck($id, $user_id = null)
    {
        $compare = $this->db->where('id', (int) $id)->get('tbopname_compare')->row();
        if (!$compare) {
            return array('status' => false, 'message' => 'Data compare tidak ditemukan.');
        }
        $this->db->trans_begin();
        $this->db->where('id', (int) $id)->update('tbopname_compare', array('need_recheck' => 1, 'is_match' => 0));
        $this->db->where('session_id', (int) $compare->session_id)->where('location_id', (int) $compare->location_id)->update('tbopname_assignment', array('status' => 'RECHECK'));
        $this->db->where('id', (int) $compare->session_id)->update('tbopname_session', array('status' => 'RECHECK'));
        $this->log_activity($user_id, 'COMPARE', 'RECHECK', 'tbopname_compare', $id, 'Data compare ditandai recheck.');
        return $this->complete_transaction('Data ditandai untuk recheck.');
    }

    public function approve_compare($id, $qty_final, $user_id = null)
    {
        $this->db->trans_begin();
        $this->db->where('id', (int) $id)->update('tbopname_compare', array(
            'qty_final' => (float) $qty_final,
            'approved_by' => $user_id ? (int) $user_id : null,
            'approved_at' => date('Y-m-d H:i:s'),
            'need_recheck' => 0
        ));
        $this->log_activity($user_id, 'COMPARE', 'APPROVE', 'tbopname_compare', $id, 'Supervisor approve compare.');
        return $this->complete_transaction('Compare berhasil di-approve.');
    }

    public function datatable_audit($request)
    {
        $columns = array('l.created_at', 'u.full_name', 'l.module_name', 'l.activity_type');
        $builder = function () {
            $this->db
                ->select('l.*, u.full_name')
                ->from('tbopname_log l')
                ->join('tbopname_user u', 'u.id = l.user_id', 'left');
        };
        return $this->datatable($request, $columns, $builder, array('u.full_name', 'l.module_name', 'l.activity_type', 'l.description'), function ($row) {
            return array(
                html_escape(date('d/m/Y H:i', strtotime($row->created_at))),
                html_escape($row->full_name ?: '-'),
                html_escape($row->module_name),
                html_escape($row->activity_type),
                html_escape($row->description ?: '-')
            );
        });
    }

    public function export_compare_rows($session_id = 0)
    {
        $this->db
            ->select('c.*, s.session_code, i.item_code, i.item_name, w.warehouse_name, l.location_code')
            ->from('tbopname_compare c')
            ->join('tbopname_session s', 's.id = c.session_id', 'inner')
            ->join('tbopname_item i', 'i.id = c.item_id', 'inner')
            ->join('tbopname_warehouse w', 'w.id = c.warehouse_id', 'inner')
            ->join('tbopname_location l', 'l.id = c.location_id', 'inner');
        if ((int) $session_id > 0) {
            $this->db->where('c.session_id', (int) $session_id);
        }
        return $this->db->order_by('s.session_code ASC, i.item_code ASC')->get()->result();
    }

    public function datatable_warehouses($request)
    {
        $has_active = $this->column_exists('tbopname_warehouse', 'is_active');
        $columns = array('warehouse_code', 'warehouse_name', 'created_at');
        $builder = function () use ($has_active) {
            $select = $has_active ? '*, is_active' : '*, 1 AS is_active';
            $this->db->select($select)->from('tbopname_warehouse');
        };

        return $this->datatable($request, $columns, $builder, array('warehouse_code', 'warehouse_name'), function ($row) {
            return array(
                html_escape($row->warehouse_code),
                html_escape($row->warehouse_name),
                stockopname_badge($row->is_active),
                html_escape(date('d/m/Y H:i', strtotime($row->created_at))),
                $this->row_actions($row->id, 'gudang')
            );
        });
    }

    public function get_warehouse($id)
    {
        $select = $this->column_exists('tbopname_warehouse', 'is_active') ? '*, is_active' : '*, 1 AS is_active';
        return $this->db->select($select)->where('id', (int) $id)->get('tbopname_warehouse')->row();
    }

    public function save_warehouse($data, $id = 0, $user_id = null)
    {
        $this->db->trans_begin();
        if ((int) $id > 0) {
            $this->db->where('id', (int) $id)->update('tbopname_warehouse', $data);
            $message = 'Gudang berhasil diperbarui.';
            $activity = 'UPDATE';
        } else {
            $this->db->insert('tbopname_warehouse', $data);
            $id = $this->db->insert_id();
            $message = 'Gudang berhasil ditambahkan.';
            $activity = 'CREATE';
        }
        $this->log_activity($user_id, 'MASTER_GUDANG', $activity, 'tbopname_warehouse', $id, $message);
        return $this->complete_transaction($message, array('id' => (int) $id));
    }

    public function delete_warehouse($id, $user_id = null)
    {
        if ($this->column_exists('tbopname_warehouse', 'is_active')) {
            $this->db->trans_begin();
            $this->db->where('id', (int) $id)->update('tbopname_warehouse', array('is_active' => 0));
            $this->log_activity($user_id, 'MASTER_GUDANG', 'DEACTIVATE', 'tbopname_warehouse', $id, 'Gudang dinonaktifkan.');
            return $this->complete_transaction('Gudang berhasil dinonaktifkan.');
        }

        if ($this->count_warehouse_references($id) > 0) {
            return array('status' => false, 'message' => 'Gudang masih dipakai transaksi. Jalankan db/stockopname_support.sql agar gudang bisa dinonaktifkan.');
        }

        $this->db->trans_begin();
        $this->db->where('id', (int) $id)->delete('tbopname_warehouse');
        $this->log_activity($user_id, 'MASTER_GUDANG', 'DELETE', 'tbopname_warehouse', $id, 'Gudang dihapus.');
        return $this->complete_transaction('Gudang berhasil dihapus.');
    }

    public function datatable_locations($request)
    {
        $warehouse_id = isset($request['warehouse_id']) ? (int) $request['warehouse_id'] : 0;
        $columns = array('l.location_code', 'l.location_name', 'w.warehouse_name', 'l.is_active');
        $builder = function () use ($warehouse_id) {
            $this->db
                ->select('l.*, w.warehouse_code, w.warehouse_name')
                ->from('tbopname_location l')
                ->join('tbopname_warehouse w', 'w.id = l.warehouse_id', 'inner');
            if ($warehouse_id > 0) {
                $this->db->where('l.warehouse_id', $warehouse_id);
            }
        };

        return $this->datatable($request, $columns, $builder, array('l.location_code', 'l.location_name', 'w.warehouse_code', 'w.warehouse_name'), function ($row) {
            $qr = $row->qr_location ?: $row->location_code;
            return array(
                html_escape($row->location_code),
                '<div class="font-weight-600">' . html_escape($row->location_name) . '</div><small class="text-muted">QR: ' . html_escape($qr) . '</small>',
                html_escape($row->warehouse_name),
                stockopname_badge($row->is_active),
                $this->row_actions($row->id, 'lokasi', true, $qr)
            );
        });
    }

    public function get_location($id)
    {
        return $this->db
            ->select('l.*, w.warehouse_name')
            ->from('tbopname_location l')
            ->join('tbopname_warehouse w', 'w.id = l.warehouse_id', 'left')
            ->where('l.id', (int) $id)
            ->get()
            ->row();
    }

    public function save_location($data, $id = 0, $user_id = null)
    {
        if (!$data['qr_location']) {
            $data['qr_location'] = $data['location_code'];
        }

        $this->db->trans_begin();
        if ((int) $id > 0) {
            $this->db->where('id', (int) $id)->update('tbopname_location', $data);
            $message = 'Lokasi berhasil diperbarui.';
            $activity = 'UPDATE';
        } else {
            $this->db->insert('tbopname_location', $data);
            $id = $this->db->insert_id();
            $message = 'Lokasi berhasil ditambahkan.';
            $activity = 'CREATE';
        }
        $this->log_activity($user_id, 'MASTER_LOKASI', $activity, 'tbopname_location', $id, $message);
        return $this->complete_transaction($message, array('id' => (int) $id));
    }

    public function delete_location($id, $user_id = null)
    {
        $this->db->trans_begin();
        $this->db->where('id', (int) $id)->update('tbopname_location', array('is_active' => 0));
        $this->log_activity($user_id, 'MASTER_LOKASI', 'DEACTIVATE', 'tbopname_location', $id, 'Lokasi dinonaktifkan.');
        return $this->complete_transaction('Lokasi berhasil dinonaktifkan.');
    }

    public function search_items($term)
    {
        $this->db->select('id, item_code, item_name, barcode, qrcode, unit')->from('tbopname_item')->where('is_active', 1);
        if ($term !== '') {
            $this->db->group_start()
                ->like('item_code', $term)
                ->or_like('item_name', $term)
                ->or_like('barcode', $term)
                ->or_like('qrcode', $term)
                ->group_end();
        }
        return $this->db->limit(20)->order_by('item_name', 'ASC')->get()->result();
    }

    public function search_suppliers($term)
    {
        $this->db->select('id, supplier_code, supplier_name')->from('tbopname_supplier');
        if ($term !== '') {
            $this->db->group_start()->like('supplier_code', $term)->or_like('supplier_name', $term)->group_end();
        }
        return $this->db->limit(20)->order_by('supplier_name', 'ASC')->get()->result();
    }

    public function search_warehouses($term, $active_only = false)
    {
        $this->db->select('id, warehouse_code, warehouse_name')->from('tbopname_warehouse');
        if ($active_only && $this->column_exists('tbopname_warehouse', 'is_active')) {
            $this->db->where('is_active', 1);
        }
        if ($term !== '') {
            $this->db->group_start()->like('warehouse_code', $term)->or_like('warehouse_name', $term)->group_end();
        }
        return $this->db->limit(20)->order_by('warehouse_name', 'ASC')->get()->result();
    }

    public function search_locations($term, $warehouse_id = 0)
    {
        $this->db
            ->select('l.id, l.location_code, l.location_name, l.qr_location, w.warehouse_name')
            ->from('tbopname_location l')
            ->join('tbopname_warehouse w', 'w.id = l.warehouse_id', 'inner')
            ->where('l.is_active', 1);
        if ((int) $warehouse_id > 0) {
            $this->db->where('l.warehouse_id', (int) $warehouse_id);
        }
        if ($term !== '') {
            $this->db->group_start()
                ->like('l.location_code', $term)
                ->or_like('l.location_name', $term)
                ->or_like('l.qr_location', $term)
                ->group_end();
        }
        return $this->db->limit(20)->order_by('l.location_name', 'ASC')->get()->result();
    }

    public function search_checkers($term)
    {
        $this->db
            ->select('u.id, u.nik, u.full_name, u.username, r.role_name')
            ->from('tbopname_user u')
            ->join('tbopname_role r', 'r.id = u.role_id', 'left')
            ->where('u.is_active', 1);
        if ($term !== '') {
            $this->db->group_start()
                ->like('u.nik', $term)
                ->or_like('u.full_name', $term)
                ->or_like('u.username', $term)
                ->or_like('r.role_name', $term)
                ->group_end();
        }
        return $this->db->limit(20)->order_by('u.full_name', 'ASC')->get()->result();
    }

    public function log_activity($user_id, $module, $type, $table = null, $reference_id = null, $description = null)
    {
        if (!$user_id || !$this->row_exists('tbopname_user', $user_id)) {
            return;
        }

        $CI = &get_instance();
        $this->db->insert('tbopname_log', array(
            'user_id' => (int) $user_id,
            'module_name' => $module,
            'activity_type' => $type,
            'table_name' => $table,
            'reference_id' => $reference_id,
            'description' => $description,
            'ip_address' => $CI->input->ip_address(),
            'device_info' => substr((string) $CI->input->user_agent(), 0, 1000)
        ));
    }

    private function datatable($request, $columns, $builder, $search_columns, $formatter)
    {
        $draw = isset($request['draw']) ? (int) $request['draw'] : 1;
        $start = isset($request['start']) ? (int) $request['start'] : 0;
        $length = isset($request['length']) ? (int) $request['length'] : 10;
        $search = isset($request['search']['value']) ? trim($request['search']['value']) : '';

        $builder();
        $records_total = $this->db->count_all_results('', false);
        $this->db->reset_query();

        $builder();
        if ($search !== '') {
            $this->db->group_start();
            foreach ($search_columns as $idx => $column) {
                $idx === 0 ? $this->db->like($column, $search) : $this->db->or_like($column, $search);
            }
            $this->db->group_end();
        }
        $records_filtered = $this->db->count_all_results('', false);
        $this->db->reset_query();

        $builder();
        if ($search !== '') {
            $this->db->group_start();
            foreach ($search_columns as $idx => $column) {
                $idx === 0 ? $this->db->like($column, $search) : $this->db->or_like($column, $search);
            }
            $this->db->group_end();
        }

        if (isset($request['order'][0]['column'])) {
            $column_index = (int) $request['order'][0]['column'];
            $dir = strtolower($request['order'][0]['dir']) === 'desc' ? 'DESC' : 'ASC';
            if (isset($columns[$column_index])) {
                $this->db->order_by($columns[$column_index], $dir);
            }
        } elseif (!empty($columns[0])) {
            $this->db->order_by($columns[0], 'ASC');
        }

        if ($length > 0) {
            $this->db->limit($length, $start);
        }

        $rows = $this->db->get()->result();
        $data = array();
        foreach ($rows as $row) {
            $data[] = $formatter($row);
        }

        return array(
            'draw' => $draw,
            'recordsTotal' => (int) $records_total,
            'recordsFiltered' => (int) $records_filtered,
            'data' => $data
        );
    }

    private function row_actions($id, $module, $qr = false, $qr_value = '')
    {
        $buttons = '<div class="btn-group btn-group-sm" role="group">';
        if ($qr) {
            $buttons .= '<button type="button" class="btn btn-outline-info js-qr" data-value="' . html_escape($qr_value) . '" title="QR Lokasi"><i class="fas fa-qrcode"></i></button>';
        }
        $buttons .= '<button type="button" class="btn btn-outline-primary js-edit" data-module="' . $module . '" data-id="' . (int) $id . '" title="Edit"><i class="fas fa-pen"></i></button>';
        $buttons .= '<button type="button" class="btn btn-outline-danger js-delete" data-module="' . $module . '" data-id="' . (int) $id . '" title="Hapus"><i class="fas fa-trash"></i></button>';
        $buttons .= '</div>';
        return $buttons;
    }

    private function status_badge($status)
    {
        $class = array(
            'OPEN' => 'badge-info',
            'PROGRESS' => 'badge-primary',
            'RECHECK' => 'badge-warning',
            'DONE' => 'badge-success',
            'CLOSED' => 'badge-dark',
            'PENDING' => 'badge-secondary',
            'PROCESS' => 'badge-primary',
            'FINISH' => 'badge-success'
        );
        $badge = isset($class[$status]) ? $class[$status] : 'badge-secondary';
        return '<span class="badge ' . $badge . '">' . html_escape($status) . '</span>';
    }

    private function count_item_references($id)
    {
        $id = (int) $id;
        return (int) $this->db->where('item_id', $id)->count_all_results('tbopname_stock')
            + (int) $this->db->where('item_id', $id)->count_all_results('tbopname_input')
            + (int) $this->db->where('item_id', $id)->count_all_results('tbopname_compare');
    }

    private function count_warehouse_references($id)
    {
        $id = (int) $id;
        return (int) $this->db->where('warehouse_id', $id)->count_all_results('tbopname_location')
            + (int) $this->db->where('warehouse_id', $id)->count_all_results('tbopname_stock')
            + (int) $this->db->where('warehouse_id', $id)->count_all_results('tbopname_input')
            + (int) $this->db->where('warehouse_id', $id)->count_all_results('tbopname_compare');
    }

    private function get_assignment($id)
    {
        return $this->db->where('id', (int) $id)->get('tbopname_assignment')->row();
    }

    private function find_id_by_code($table, $field, $code)
    {
        if ($code === '') {
            return null;
        }
        $row = $this->db->select('id')->where($field, $code)->get($table)->row();
        return $row ? (int) $row->id : null;
    }

    private function sum_input($session_id, $user_id, $stock)
    {
        $row = $this->db
            ->select_sum('qty_input', 'qty')
            ->where('session_id', (int) $session_id)
            ->where('user_id', (int) $user_id)
            ->where('item_id', (int) $stock->item_id)
            ->where('location_id', (int) $stock->location_id)
            ->where('lot_number', $stock->lot_number)
            ->where('expired_date', $stock->expired_date)
            ->get('tbopname_input')
            ->row();
        return $row && $row->qty !== null ? (float) $row->qty : 0;
    }

    private function complete_transaction($success_message, $data = array())
    {
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return array('status' => false, 'message' => 'Proses database gagal. Silakan coba lagi.');
        }

        $this->db->trans_commit();
        return array('status' => true, 'message' => $success_message, 'data' => $data);
    }

    private function supplier_id_by_code($code)
    {
        $row = $this->db->select('id')->where('supplier_code', $code)->get('tbopname_supplier')->row();
        return $row ? (int) $row->id : null;
    }

    private function normalize_import_headers($row)
    {
        $headers = array();
        foreach ($row as $value) {
            $value = strtolower(trim((string) $value));
            $value = str_replace(array(' ', '-', '.', '/'), '_', $value);
            $map = array(
                'kode_barang' => 'item_code',
                'nama_barang' => 'item_name',
                'satuan' => 'unit',
                'stok_minimum' => 'minimum_stock',
                'minimum_stok' => 'minimum_stock',
                'kode_supplier' => 'supplier_code'
            );
            $headers[] = isset($map[$value]) ? $map[$value] : $value;
        }
        return $headers;
    }

    private function map_import_row($headers, $row)
    {
        $mapped = array();
        foreach ($headers as $idx => $header) {
            $mapped[$header] = isset($row[$idx]) ? trim((string) $row[$idx]) : null;
        }
        return $mapped;
    }
}
