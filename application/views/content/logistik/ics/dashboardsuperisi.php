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
                            <a href="<?= base_url('tracking_wilayah') ?>" class="btn btn-md btn-secondary w-100 mb-3"><i class="fas fa-book-open"></i> Supervisi Monitoring & Tracking</a>
                        </div>
                        <div class="col-auto">
                            <a href="<?= base_url('final_result') ?>" class="btn btn-md btn-success w-100 mb-3"><i class="fas fa-trophy"></i> Final Result</a>
                        </div>
                    </div>
                </section>

                <?php
                $wilayah_session_raw = $this->session->userdata('wilayah');
                $wilayah_session = [];

                if (!empty($wilayah_session_raw)) {
                    $wilayah_session = array_map('intval', explode(';', $wilayah_session_raw));
                }
                ?>

                <?php
                $wilayah_opname = [
                    1  => 'Gudang A 1-2 Atas & Gudang A 9-10 Bawah',
                    2  => 'Gudang A 1-2-3 Bawah',
                    3  => 'Gudang A 4-5-6',
                    4  => 'Gudang A 7-8 & Gudang Benih',
                    5  => 'Gudang A Eceran 1',
                    6  => 'Gudang A Eceran 2',
                    7  => 'Gudang A Eceran 3',
                    8  => 'Gudang B 1-3 Atas, Gudang C (A9)',
                    9  => 'Gudang B 1-2-3',
                    10 => 'Gudang B 4-5-6-7',
                    11 => 'Gudang B 8-9-10',
                    12 => 'Gudang B 11-12-13',
                    13 => 'Gudang C (A7, A8)'
                ];
                ?>

                <section>
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <?php foreach ($wilayah_opname as $id => $nama) : ?>
                                    <?php if (!in_array($id, $wilayah_session)) continue; ?>

                                    <div class="col-md-4 col-sm-6 mb-3">
                                        <a href="<?= base_url('detail_wilayah_opname/' . $id) ?>" class="text-decoration-none text-white">
                                            <div class="small-box bg-info">
                                                <div class="inner">
                                                    <h5><?= $nama ?></h5>
                                                    <p>Wilayah <?= $id ?></p>
                                                </div>
                                                <div class="icon">
                                                    <i class="fas fa-warehouse"></i>
                                                </div>
                                            </div>
                                        </a>
                                    </div>

                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>

        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2025 <a href="https://kiu.co.id">PT. KARISMA INDOARGO UNIVERSAL</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 2.0.1
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->