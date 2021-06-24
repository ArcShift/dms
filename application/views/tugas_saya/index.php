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
                <button class="btn btn-sm btn-outline-primary fa fa-plus" id="btnTugasBaru"> Tambah Tugas</button>
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
<!--MODAL TUGAS BARU & EDIT TUGAS-->
<div class="modal fade" id="modalTugasBaru">
    <div class="modal-dialog modal-lg" role="document">
        <form method="post" enctype="multipart/form-data" id="formTugas">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-mode" name="mode" required="" hidden="">
                    <input class="input-id-tugas" name="id_tugas" hidden="">
                    <input class="input-id-jadwal" name="id_jadwal" hidden=""/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><b>Tugas</b></label>
                                <input class="form-control input-tugas" name="nama" required="">
                            </div>
                            <div class="form-group">
                                <label><b>SOP Terkait</b></label>
                                <select class="form-control select-dokumen" name="dokumen" required="">
                                    <option value="">~ Dokumen ~</option>
                                    <?php foreach ($dokumen as $k => $d) { ?>
                                        <option value="<?= $d->id ?>"><?= $d->judul ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><b>Form Terkait</b></label>
                                <select class="form-control select-form" name="form_terkait">
                                    <option value="">~ Form Terkait ~</option>
                                    <?php foreach ($form_terkait as $k => $d) { ?>
                                        <option value="<?= $d->id ?>"><?= $d->judul ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><b>Unit Kerja</b></label>
                                <select class="form-control" required="" name="jabatan[]">
                                    <?php foreach ($unit_kerja as $k => $uk) { ?>
                                        <option value="<?= $uk->jabatan ?>"><?= $uk->name ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><b>Sifat</b></label>
                                <select class="form-control select-sifat" required="" name="sifat">
                                    <option value="">~ Sifat ~</option>
                                    <option value="WAJIB">Wajib</option>
                                    <option value="SITUASIONAL">Situasional</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><b>Jadwal</b></label>
                                <input class="form-control input-tanggal" type="date" name="jadwal" required="" value="<?= date('Y-m-d') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="submitButton" name="newTugas" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL DELETE TUGAS-->
<div class="modal fade" id="modalDelete">
    <div class="modal-dialog" role="document">
        <form method="post" id="formDelete">
            <input class="input-mode" name="mode" value="delete" hidden="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input class="input-id-tugas" name="id" required="" hidden="">
                        <label>Nama Tugas</label>
                        <div class="input-tugas card-body bg-light p-2 box-detail"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                    <button class="btn btn-outline-danger" name="delete" value="ok">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL UPLOAD IMPLEMENTASI-->
<div class="modal fade" id="modalUploadImplementasi">
    <div class="modal-dialog" role="document">
        <form id="formUploadImplementasi" method="post" enctype="multipart/form-data">
            <input class="input-mode" name="mode" value="upload" hidden="">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input class="input-id" name="id" hidden=""/>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Tugas</b></label>
                        <input class="form-control input-tugas" disabled="">
                    </div>
                    <div class="form-group">
                        <label><b>Tanggal</b></label>
                        <input class="form-control input-field input-jadwal" name="tanggal" disabled="">
                    </div>
                    <label><b>Bukti Implementasi</b></label>
                    <div class="form-group group-link">
                        <div class="input-group">
                            <input class="form-control input-path" readonly="">
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-danger fa fa-trash link-bukti" onclick="initUpload2()"></button>
                            </div>
                        </div>
                    </div>
                    <div class="group-upload">
                        <div class="form-group">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio1" name="type_dokumen" value="file" class="custom-control-input radio-bukti">
                                <label class="custom-control-label" for="customRadio1">File</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio2" name="type_dokumen" value="url" class="custom-control-input radio-bukti">
                                <label class="custom-control-label" for="customRadio2">Url</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="form-control input-file" type="file" name="dokumen">
                            <input class="form-control input-url" type="url" name="url">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-simpan" name="upload" value="ok">Simpan</button>
                </div>
            </div>
        </form>
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
    $('#btnTugasBaru').click(function () {
        var m = $('#modalTugasBaru');
        m.modal('show');
        m.find('.modal-title').html('Buat Tugas Baru');
        $('#formTugas').trigger('reset');
        $('#submitButton').attr('name', 'newTugas');
        m.find('.select-personil').val('').trigger('change');
        m.find('.input-mode').val('create');
    });
    $('#formTugas').submit(function (e) {
        e.preventDefault();
        post(this, 'set');
    });
    function initEdit(idx) {
        var m = $('#modalTugasBaru');
        m.modal('show');
        var d = tugas[idx];
        console.log(d);
        m.find('.modal-title').html('Edit Tugas');
        $('#submitButton').attr('name', 'edit');
        m.find('.input-id-tugas').prop('required', true);
        m.find('.input-id-tugas').val(d.id_tugas);
        m.find('.select-dokumen').val(d.id_document);
        m.find('.input-tugas').val(d.tugas);
        m.find('.input-id-jadwal').val(d.id);
        m.find('.select-form').val(d.form_terkait);
        m.find('.select-sifat').val(d.sifat);
        m.find('.input-tanggal').val(d.tanggal);
        m.find('.input-mode').val('edit');
    }
    function initDelete(idx) {
        var d = tugas[idx];
        var m = $('#modalDelete');
        m.modal('show');
        m.find('.input-tugas').html(d.tugas);
        m.find('.input-id-tugas').val(d.id_tugas);
    }
    $('#formDelete').submit(function (e) {
        e.preventDefault();
        post(this, 'set');
    });
    function initUpload(idx) {
        $('#formUploadImplementasi').trigger('reset');
        var d = tugas[idx];
        var m = $('#modalUploadImplementasi');
        m.modal('show');
        m.find('.input-id').val(d.id);
        m.find('.input-tugas').val(d.tugas);
        m.find('.input-jadwal').val(d.tanggal);
        m.find('.input-url, .input-file').hide();
        console.log(d);
        if (d.path == null) {
            initUpload2();
        } else {
            $('.group-link').show();
            $('.group-upload').hide();
            $('.btn-simpan').hide();
            m.find('.input-path').val(d.path);
        }
        $('.input-file,.input-url').hide();
        $('.radio-bukti').prop('checked', false);
        $('.input-file,.input-url').prop('required', false);
    }
    function initUpload2() {
        $('.group-link').hide();
        $('.group-upload').show();
    }
    $('.radio-bukti').change(function () {
        var type = $(this).val();
        var m = $('#modalUploadImplementasi');
        m.find('.btn-simpan').show();
        if (type == 'file') {
            m.find('.input-file').show();
            m.find('.input-file').prop('required', true);
            m.find('.input-url').hide();
            m.find('.input-url').prop('required', false);
        } else if (type == 'url') {
            m.find('.input-file').hide();
            m.find('.input-file').prop('required', false);
            m.find('.input-url').show();
            m.find('.input-url').prop('required', true);
        }
    });
    $('#formUploadImplementasi').submit(function (e) {
        e.preventDefault();
        post(this, 'set');
    });
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
                '<a class="dropdown-item" onclick="initUpload(' + idx + ')">Upload</a>' +
                '<a class="dropdown-item" onclick="initEdit(' + idx + ')">Ubah</a>' +
                '<a class="dropdown-item" onclick="initDelete(' + idx + ')">Hapus</a>' +
                '</div>' +
                '</div>' +
                '</td>' +
                '</tr>' +
                '</table>';
    }
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
                        getTugas();
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
</script>