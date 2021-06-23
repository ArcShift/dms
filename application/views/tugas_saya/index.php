<?php
//print_r($this->session->user);
?>
<style>
    td.details-control {
        background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center center;
        cursor: pointer;
        width: 30px;
    }
    tr.shown td.details-control {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center center;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-sm-4">
                <button class="btn btn-sm btn-outline-primary fa fa-plus"> Tambah Tugas</button>
            </div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2 div-filter-cari"></div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" id="filterStatus">
                    <option value="">~ Status ~</option>
                    <option value="selesai">Selesai</option>
                    <option value="menunggu">Menunggu</option>
                    <option value="terlambat">Terlambat</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" id="filterPeriode">
                    <option value="">~ Periode ~</option>
                    <option value="<?= date('Y-m-d') ?>">Hari ini</option>
                    <option value="<?= date('Y-m') ?>">Bulan ini</option>
                    <option value="<?= date('Y') ?>">Tahun ini</option>
                </select>
            </div>
        </div>
        <table class="table" id="tableMain">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tugas</th>
                    <th>Pelaksana</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    $(document).ready(function () {
        tbMain = $('#tableMain').DataTable({
            "bLengthChange": false,
            "order": [],
            "columnDefs": [
                {className: "details-control", "targets": [0]}
            ]
        });
        $('#filterStatus').change(function () {
            tbMain.columns(4).search($(this).val()).draw();
        });
        $('#filterPeriode').change(function () {
            console.log('filter status');
            tbMain.columns(3).search($(this).val()).draw();
        });
        getTugas();
        $('.select2').select2();
        $('.dataTables_filter .form-control').attr('placeholder', 'Cari');
        $('.div-filter-cari').append($('.dataTables_filter .form-control'));
        $('.dataTables_filter').hide();
        // Add event listener for opening and closing details
        $('#tableMain tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = tbMain.row(tr);
            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.index())).show();
                tr.addClass('shown');
            }
        });
    });
    function afterReady() {}
    function getTugas() {
        $.getJSON('<?= site_url($module . '/get') ?>', null, function (data) {
            console.log(data);
            tbMain.clear();
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                var pelaksana = '';
                for (var j = 0; j < d.pelaksana.length; j++) {
                    var pel = d.pelaksana[j];
                    pelaksana += '<img class="rounded-circle" style="object-fit: cover" src="' + (pel.photo == null ? '<?= base_url('assets/images/default_user.jpg') ?>' : '<?= base_url('upload/profile_photo/') ?>' + pel.photo) + '" width="30" height="30" title="' + pel.fullname + '">';
                }
                tbMain.row.add([
                    '',
                    d.tugas,
                    pelaksana,
                    d.tanggal,
                    d.deadline,
                ]);
            }
            tugas = data;
            tbMain.draw();
        });
    }
    function format(idx) {
        var d = tugas[idx];
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Proyek:</td>' +
                '<td>' + (d.project == null ? '-' : d.project) + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Aksi:</td>' +
                '<td>' +
                '<div class="dropdown">' +
                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                '</button>' +
                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
//                '<a class="dropdown-item" href="#">Detail</a>' +
                '<a class="dropdown-item" href="#">Ubah</a>' +
                '<a class="dropdown-item" href="#">Hapus</a>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '</tr>' +
                '</table>';
    }
</script>