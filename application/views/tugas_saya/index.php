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
            <div class="col-sm-2"></div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm">
                    <option value="">~ Status ~</option>
                    <option value="">Selesai</option>
                    <option value="">Menunggu</option>
                    <option value="">Terlambat</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm">
                    <option value="">~ Periode ~</option>
                    <option value="">Hari Ini</option>
                    <option value="">Minggu Ini</option>
                    <option value="">Bulan Ini</option>
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
    function afterReady() {

    }
    function format(d) {
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Proyek:</td>' +
                '<td>' + d.proyek + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Aksi:</td>' +
                '<td>' +
                '<div class="dropdown">' +
                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                '</button>' +
                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                '<a class="dropdown-item" href="#">Detail</a>' +
                '<a class="dropdown-item" href="#">Ubah</a>' +
                '<a class="dropdown-item" href="<?= site_url('project2/tugas') ?>">Tugas</a>' +
                '<a class="dropdown-item" href="#">Hapus</a>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '</tr>' +
                '</table>';
    }
    imgTest = "";
    for (var i = 0; i < 5; i++) {
        imgTest += '<img src="<?= base_url('assets/images/default_user.jpg') ?>" width="30" title="Toimul Setyo Andri - IT">';

    }
    dt = {
        tugas: 'Membuat database',
        pelaksana: imgTest,
        jadwal: '2021-01-01',
        status: '<span class="badge badge-success">selesai</span>',
        proyek: 'Membuat Aplikasi Marketing',
        aksi: '',
    }

    var data2 = [];
    for (var i = 0; i < 10; i++) {
        data2.push(dt);
    }
    $(document).ready(function () {
        var table = $('#tableMain').DataTable({
            data: data2,
            "columns": [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "defaultContent": ''
                },
                {"data": "tugas"},
                {"data": "pelaksana"},
                {"data": "jadwal"},
                {"data": "status"}
            ],
            "order": [[1, 'asc']]
        });

        // Add event listener for opening and closing details
        $('#tableMain tbody').on('click', 'td.details-control', function () {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    });
</script>