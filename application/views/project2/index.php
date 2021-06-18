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
        <table class="table" id="tableMain" style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th style="width: 300px">Proyek</th>
                    <th style="width: 300px">Deskripsi</th>
                    <th>Jumlah Tugas</th>
                    <th>Status Proyek</th>
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
                '<td>Pelaksana:</td>' +
                '<td>' + d.pelaksana + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Aksi:</td>' +
                '<td>' +
                '<div class="dropdown">' +
                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
         
                '</button>' +
                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
                '<a class="dropdown-item" href="#">Action</a>' +
                '<a class="dropdown-item" href="#">Another action</a>' +
                '<a class="dropdown-item" href="#">Something else here</a>' +
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
        proyek: 'Membuat aplikasi marketing',
        deskripsi: 'aplikasi yang dapat membantu marketing dalam melakukan pencatatan hasil kegiatan marketing sehari-hari',
        jumlah_tugas: '18',
        status_proyek: '70%',
        pelaksana: imgTest,
        aksi: '',
    }

    var data2 = [];
    for (var i = 0; i < 10; i++) {
        data2.push(dt);
    }
    var data = [
        {
            "id": "1",
            "name": "Tiger Nixon",
            "position": "System Architect",
            "salary": "$320,800",
            "start_date": "2011/04/25",
            "office": "Edinburgh",
            "extn": "5421"
        },
        {
            "id": "2",
            "name": "Garrett Winters",
            "position": "Accountant",
            "salary": "$170,750",
            "start_date": "2011/07/25",
            "office": "Tokyo",
            "extn": "8422"
        },
    ];
    $(document).ready(function () {
        var table = $('#tableMain').DataTable({
            data: data2,
            "columns": [
                {
                    "className": 'details-control',
                    "orderable": false,
                    "data": data,
                    "defaultContent": ''
                },
                {"data": "proyek"},
                {"data": "deskripsi"},
                {"data": "jumlah_tugas"},
                {"data": "status_proyek"}
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