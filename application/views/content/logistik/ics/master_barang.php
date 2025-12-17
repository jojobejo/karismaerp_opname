<style>
    .small-chart {
        width: 50% !important;
        height: auto;
        margin: auto;
        display: block;
    }
</style>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo base_url('assets/images/Karisma.png') ?>" alt="AdminLTELogo" height="150" width="300">
        </div>

        <?php $this->load->view('partial/main/navbar') ?>
        <?php $this->load->view('partial/main/sidebar') ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content-header">
                <section class="content">

                    <div class="row">
                        <div class="col-auto">
                            <a href="<?= base_url('trackingtim/1') ?>" class="btn btn-md btn-primary w-100 mb-3"><i class="fas fa-tasks"></i> Tracking Stock TIM 1</a>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('trackingtim/2') ?>" class="btn btn-md btn-primary w-100 mb-3"><i class="fas fa-tasks"></i> Tracking Stock TIM 2</a>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('stockopname') ?>" class="btn btn-md btn-primary w-100 mb-3"><i class="fas fa-tasks"></i> Stock Opname</a>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('master_barang') ?>" class="btn btn-md btn-secondary w-100 mb-3"><i class="fas fa-book-open"></i> Master Barang</a>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('compare_opname') ?>" class="btn btn-md btn-primary w-100 mb-3"><i class="fas fa-book-open"></i> Stock Opname Compare</a>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('opname_datapending') ?>" class="btn btn-md btn-primary w-100 mb-3"><i class="fas fa-tasks"></i> Data Pending</a>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('request_opname_admin') ?>" class="btn btn-md btn-primary w-100 mb-3"><i class="fas fa-notes-medical"></i> Request Input</a>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('final_result') ?>" class="btn btn-md btn-success w-100 mb-3"><i class="fa-solid fa-trophy"></i> Final Result</a>
                        </div>
                    </div>

                </section>
                <div class="content-body">
                    <section class="content">

                        <div class="card">

                            <div class="card-body">
                                <table id="tbmasterbarang" class="table table-bordered table-striped">
                                    <thead style="background-color: #212529; color:white;">
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th>Expired Date</th>
                                            <th>Nama Gudang</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                        </div>

                    </section>
                </div>
            </div>
        </div>

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 <a href="https://kiu.co.id">PT.KARISMA INDOARGO UNIVERSAL</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 1.0
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->