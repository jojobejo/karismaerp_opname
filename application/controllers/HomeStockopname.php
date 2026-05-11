<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HomeStockopname extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
    }

    public function index()
    {
        $legacy_jobdesk = strtoupper((string) $this->session->userdata('jobdesk'));
        $is_legacy_authenticated = $this->session->userdata('logged_in')
            && in_array($legacy_jobdesk, array('STOCKOPNAME', 'SUPERVISI', 'ADMINICS'), true);

        if ($this->session->userdata('stockopname_logged_in') || $is_legacy_authenticated) {
            redirect('stockopname');
            return;
        }

        redirect('stockopname/login');
    }
}
