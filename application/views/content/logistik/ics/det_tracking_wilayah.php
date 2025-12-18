<style>
    .small-chart {
        width: 50% !important;
        height: auto;
        margin: auto;
        display: block;
    }

    .small-box {
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .small-box:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }
</style>

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

$wilayah_id   = $wilayah_id ?? 0;
$nama_wilayah = $wilayah_opname[$wilayah_id] ?? 'Wilayah Tidak Diketahui';
?>


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
                            <a href="<?= base_url('tracking_wilayah') ?>" class="btn btn-md btn-primary w-100 mb-3"><i class="fas fa-warehouse"></i> Wilayah</a>
                        </div>
                    </div>

                </section>
                <div class="content-body">
                    <section class="content">

                        <div class="card">
                            <div class="card-body">

                                <?php
                                function status_btn($status)
                                {
                                    return $status === 'MATCH'
                                        ? '<span class="btn btn-success btn-sm">MATCH</span>'
                                        : '<span class="btn btn-danger btn-sm">NOT MATCH</span>';
                                }

                                function ket_btn($ket)
                                {
                                    return $ket === 'VALID'
                                        ? '<span class="btn btn-success btn-sm">VALID</span>'
                                        : '<span class="btn btn-warning btn-sm">CEK ULANG</span>';
                                }
                                ?>

                                <div class="mb-3">
                                    <h4 class="fw-bold">
                                        <i class="fas fa-warehouse"></i>
                                        Wilayah <?= $wilayah_id ?> - <?= $nama_wilayah ?>
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-body">
                                <div class="mb-1">
                                    <h4 class="fw-bold">
                                        <i class="fas fa-boxes"></i>
                                        Input Opname By All Barang
                                    </h4>
                                </div>

                                <div class="mb-2">
                                    <button class="btn btn-md btn-warning toggle-invalid" data-target="trackingwil_1">
                                        Tampilkan Tidak Valid
                                    </button>
                                </div>

                                <table id="trackingwil_1" class="table table-bordered table-striped mb-4">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th class="text-center">Qty TIM 1</th>
                                            <th class="text-center">Qty TIM 2</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($wilayah_all as $w1) : ?>
                                            <tr>
                                                <td><?= $w1->nama_barang ?></td>
                                                <td class="text-center"><?= $w1->qty_fisik_tim1 ?></td>
                                                <td class="text-center"><?= $w1->qty_fisik_tim2 ?></td>
                                                <td class="text-center"><?= status_btn($w1->status_opname) ?></td>
                                                <td class="text-center"><?= ket_btn($w1->keterangan) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="mb-1">
                                    <h4 class="fw-bold">
                                        <i class="fas fa-calendar"></i>
                                        Input Opname By Expired Date Barang
                                    </h4>
                                </div>

                                <div class="mb-2">
                                    <button class="btn btn-md btn-warning toggle-invalid" data-target="trackingwil_2">
                                        Tampilkan Tidak Valid
                                    </button>
                                </div>

                                <table id="trackingwil_2" class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Nama Barang</th>
                                            <th class="text-center">Expired Date</th>
                                            <th class="text-center">Qty TIM 1</th>
                                            <th class="text-center">Qty TIM 2</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($wilayah_fefo as $w2) : ?>
                                            <tr>
                                                <td><?= $w2->nama_barang ?></td>
                                                <td class="text-center"><?= date('d-m-Y', strtotime($w2->exp_date)) ?></td>
                                                <td class="text-center"><?= $w2->qty_fisik_tim1 ?></td>
                                                <td class="text-center"><?= $w2->qty_fisik_tim2 ?></td>
                                                <td class="text-center"><?= status_btn($w2->status_opname) ?></td>
                                                <td class="text-center"><?= ket_btn($w2->keterangan) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
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