<script>
    $(function() {
        $("#tb_dash_fefo").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#compare_expired_date").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#compare_allbarang").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_dash_allbarang").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#dt_pending").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_dash_allbarang1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_dash_allbarang2").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_timby_expdate").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_timby_allbarang").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_stock_tracking").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_opname_fefo_user").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_opname_allbarang_user").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_opname_fefo_adm").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_opname_allbarang_adm").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_tracking_user_allbarang").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tb_tracking_user_opname").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#list_tb_opname").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#dtrequest_opname").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        $("#tbopnametodo").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#tbdetailwilyah").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#finalist").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#finalqtyexp").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#trackingwil_1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        $("#trackingwil_2").DataTable({
            "responsive": true,
            "lengthChange": false,
            "aaSorting": [],
            "autoWidth": false,
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');


    });
</script>

<script>
    let invalidOnly = {};

    $('.toggle-invalid').on('click', function() {
        const tableId = $(this).data('target');
        const table = $('#' + tableId).DataTable();

        invalidOnly[tableId] = !invalidOnly[tableId];

        if (invalidOnly[tableId]) {
            // Filter hanya CEK ULANG
            table.column(-1).search('CEK ULANG').draw();
            $(this).text('Tampilkan Semua Data')
                .removeClass('btn-warning')
                .addClass('btn-secondary');
        } else {
            // Reset filter
            table.column(-1).search('').draw();
            $(this).text('Tampilkan Tidak Valid')
                .removeClass('btn-secondary')
                .addClass('btn-warning');
        }
    });
</script>