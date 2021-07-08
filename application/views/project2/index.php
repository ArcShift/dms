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
        <button class="btn btn-sm btn-outline-primary mb-2" id="createProject">Buat Proyek Baru</button>
        <form method="post">
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
        </form>
    </div>
</div>
<!--MODAL CREATE-->
<div class="modal fade" id="modalCreate">
    <div class="modal-dialog" role="document">
        <form method="post" id="formCreate">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-mode" name="mode" required="" hidden="">
                    <input class="input-id" name="id" hidden="">
                    <div class="form-group">
                        <label><b>Nama</b></label>
                        <input class="form-control input-nama" name="name" required="">
                    </div>
                    <div class="form-group">
                        <label><b>Deskripsi</b></label>
                        <textarea class="form-control input-desc" name="desc"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-primary btn-save" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL DELETE-->
<div class="modal fade" id="modalHapus">
    <div class="modal-dialog" role="document">
        <form method="post" id="formDelete">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Proyek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Nama</b></label>
                        <input class="form-control" name="mode" hidden="" value="hapus">
                        <input class="form-control input-nama" disabled="">
                        <input class="form-control input-id" name="id" required="" hidden="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-danger" name="hapus" value="ok">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(document).ready(function () {
        tbMain = $('#tableMain').DataTable({
            "columnDefs": [
                {className: "details-control", "targets": [0]}
            ]
        });
        getProject();
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
    function format(idx) {
        var d = project[idx];
        // `d` is the original data object for the row
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Pelaksana:</td>' +
                '<td>' + d.pelaksanaImg + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Aksi:</td>' +
                '<td>' +
                '<div class="dropdown">' +
                '<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">' +
                '</button>' +
                '<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">' +
//                '<a class="dropdown-item" href="#">Detail</a>' +
                '<a class="dropdown-item" onclick="initEdit(' + idx + ')"><i class="text-primary fa fa-edit"></i>&nbsp&nbspUbah Proyek</a>' +
                '<button class="dropdown-item" name="idData" value="' + d.id + '"><i class="text-primary fa fa-list"></i>&nbsp&nbspTugas</button>' +
                (d.tugas == 0 ? '<a class="dropdown-item" onclick="initDelete(' + idx + ')"><i class="text-danger fa fa-trash"></i>&nbsp&nbspHapus</a>' : '') +
                '</div>' +
                '</div>' +
                '</td>' +
                '</tr>' +
                '</table>';
    }
    function getProject() {
        $.getJSON('<?= site_url($module . '/get') ?>', null, function (data) {
            console.log(data);
            tbMain.clear();
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                data[i].pelaksanaImg = '';
//                data[i].pelaksana = '<img src="<?= base_url('assets/images/default_user.jpg') ?>" width="30" title="Toimul Setyo Andri - IT">';
//                data[i].pelaksana = '-';
                for (var j = 0; j < d.pelaksana.length; j++) {
                    var pel = d.pelaksana[j];
                    data[i].pelaksanaImg += '<img class="rounded-circle" style="object-fit: cover" src="' + (pel.photo == null ? '<?= base_url('assets/images/default_user.jpg') ?>' : '<?= base_url('upload/profile_photo/') ?>' + pel.photo) + '" width="30" height="30" title="' + pel.personil + '">';
                }
                data[i].status = 'n%';
                tbMain.row.add([
                    '',
                    d.nama,
                    d.deskripsi,
                    d.tugas,
                    (d.jadwal == 0 ? '0' : Math.round(d.selesai / d.jadwal * 100)) + '%',
                ]);
            }
            project = data;
            tbMain.draw();
        });
    }
    $('#createProject').click(function () {
        var m = $('#modalCreate');
        m.modal('show');
        m.find('.modal-title').html('Buat Proyek Baru');
        m.find('form').trigger('reset');
        m.find('.btn-save').attr('name', 'create');
        m.find('.input-mode').val('create');
    });
    $('#formCreate').submit(function (e) {
        e.preventDefault();
        post(this, 'set');
    });
    function post(form, url) {
        $('.modal').modal('hide');
        $('#modalNotif .modal-title').text('Menyimpan data');
        $('#modalNotif .modal-message').html('loading....');
        $('#modalNotif').modal('show');
        $.ajax({
            url: '<?php echo site_url($module . '/') ?>' + url,
            type: "post",
            data: new FormData(form),
            processData: false,
            contentType: false,
            cache: false,
            async: false,
            success: function (data) {
                try {
                    data = JSON.parse(data);
                    if (data.status == 'success') {
                        getProject();
                        if (data.idData != null) {
                            window.location.replace('<?php echo site_url($module . '/tugas') ?>');
                        }
                        if (data.message) {
                            $('#modalNotif .modal-message').html(data.message);
                        } else {
                            $('#modalNotif .modal-message').html('Data Berhasil Disimpan');
                        }
                        $('#modalNotif .modal-title').text('Success');
                    } else if (data.status === 'error') {
                        $('#modalNotif .modal-title').text('Error');
                        $('#modalNotif .modal-message').html(data.message);
                    }
                } catch (e) {
                    $('#modalNotif .modal-message').html(data);
                }
            },
            error: function (data) {
                $('#modalNotif .modal-title').text('Error');
                $('#modalNotif .modal-message').text('Error 500');
            },
        });
    }
    function initEdit(idx) {
        var m = $('#modalCreate');
        var d = project[idx];
        m.modal('show');
        m.find('.modal-title').html('Edit Proyek');
        m.find('.input-nama').val(d.nama);
        m.find('.input-id').val(d.id);
        m.find('.input-desc').val(d.deskripsi);
        m.find('.input-mode').val('edit');
        m.find('.btn-save').attr('name', 'edit');
    }
    function initDelete(idx) {
        var d = project[idx];
        var m = $('#modalHapus');
        m.modal('show');
        m.find('.input-nama').val(d.nama);
        m.find('.input-id').val(d.id);
    }
    $('#formDelete').submit(function (e) {
        e.preventDefault();
        post(this, 'set');
    });
</script>