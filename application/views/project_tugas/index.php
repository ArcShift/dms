<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a data-toggle="tab" href="#tab-proyek" class="nav-link active">Proyek</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#tab-tugas" class="nav-link">Tugas</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab-proyek" role="tabpanel">
                <div>
                    <button class="btn btn-sm btn-outline-primary mb-3" id="createProject">Buat Proyek Baru</button>
                </div>
                <table class="table" id="tableProject">
                    <thead>
                        <tr>
                            <th>Proyek</th>
                            <th>Deskripsi</th>
                            <th>Tugas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
            <div class="tab-pane" id="tab-tugas" role="tabpanel">
                <button class="btn btn-sm btn-outline-primary" id="createTugas">Buat Tugas Baru</button>
                <br/>
                <br/>
                <div class="row div-filter">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-2">
                        <input class="form-control form-control-sm" onfocus="(this.type = 'date')" id="minDate" placeholder="Tanggal Awal">
                    </div>
                    <div class="col-sm-2">
                        <input class="form-control form-control-sm" onfocus="(this.type = 'date')" id="maxDate" placeholder="Tanggal Akhir">
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control form-control-sm" id='filterPersonil'>
                            <option value="">~ Status ~</option>
                            <option value="selesai">Selesai</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="menunggu">Menunggu</option>
                        </select>
                    </div>
                    <div class="col-sm-2">
                        <select class="form-control form-control-sm" id='filterPeriode'>
                            <option value="">~ Periode ~</option>
                            <option value="<?= date('Y-m-d') ?>">Hari ini</option>
                            <option value="<?= date('Y-m') ?>">Bulan ini</option>
                            <option value="<?= date('Y') ?>">Tahun ini</option>
                        </select>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table" id="tableTugas">
                        <thead>
                            <tr>
                                <th>Jadwal</th>
                                <th>Proyek</th>
                                <th>Tugas</th>
                                <th>Pelaksana</th>
                                <th>Bukti</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!--MODAL CREATE PROJECT-->
<div class="modal fade" id="modalCreate">
    <div class="modal-dialog" role="document">
        <form method="post" id="formCreateProject">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id" name="id" hidden="">
                    <input class="input-mode" name="mode" hidden="" required="">
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
<!--MODAL DELETE PROJECT-->
<div class="modal fade" id="modalHapus">
    <div class="modal-dialog" role="document">
        <form method="post" id="formDeleteProject">
            <div class="modal-content">
                <div class="modal-header">
                    <input class="input-mode" name="mode" value="hapus" hidden="" required="">
                    <h5 class="modal-title">Hapus Proyek</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Nama</b></label>
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
                    <input class="input-mode" name="mode" hidden="">
                    <input class="input-id-tugas" name="id_tugas" hidden="">
                    <input class="input-id-jadwal" name="id_jadwal" hidden=""/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><b>Proyek</b></label>
                                <select class="form-control select-proyek" id="selectProject" name="proyek"></select>
                            </div>
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
                                <label><b>Personil</b></label>
                                <select class="form-control select-personil select2" multiple="" required="" name="personil[]" style="width: 100% !important;">
                                    <?php foreach ($personil as $k => $p) { ?>
                                        <option value="<?= $p->id ?>"><?= $p->fullname ?></option>
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
<div class="modal fade" id="modalDeleteTugas">
    <div class="modal-dialog" role="document">
        <form method="post" id="formDeleteTugas">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-mode" name="mode" hidden="">
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
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload Bukti</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input class="input-mode" name="mode" value="upload" hidden="">
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
                                <button type="button" class="btn btn-outline-danger fa fa-trash link-bukti" onclick="switchUpload()"></button>
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
    getProject();
    getTugas();
    $(document).ready(function () {
        $('#tableTugas_filter .form-control').attr('placeholder', 'Search');
        $('.div-filter .col-sm-2').eq(0).append($('#tableTugas_filter .form-control'));
        $('#tableTugas_filter').hide();
        $('.select2').select2();
    });
    function afterReady() {
    }
    tbPro = $('#tableProject').DataTable();
    function getProject() {
        $.getJSON('project_tugas/get_project', null, function (data) {
            tbPro.clear();
            $('#selectProject').empty();
            $('#selectProject').append('<option value="">~ Proyek ~</option>');
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                tbPro.row.add([
                    d.nama,
                    d.deskripsi,
                    '<span class="badge badge-' + (d.tugas == 0 ? 'danger' : 'primary') + '">' + d.tugas + '</span>',
                    '<button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="initEditProject(' + i + ')"></button>'
                            + (d.tugas == 0 ? '<button class="btn btn-sm btn-outline-danger fa fa-trash ml-1" onclick="initHapusProject(' + i + ')"></button>' : ''),
                ]);
                $('#selectProject').append('<option value="' + d.id + '">' + d.nama + '</option>');
            }
            tbPro.draw();
            project = data;
        });
    }
    $('#createProject').click(function () {
        var m = $('#modalCreate');
        m.modal('show');
        m.find('.modal-title').html('Buat Proyek Baru');
        m.find('form').trigger('reset');
        m.find('.btn-save').attr('name', 'create');
        m.find('.input-id').prop('required', false);
        m.find('.input-mode').val('create');
    });
    $('#formCreateProject').submit(function (e) {
        e.preventDefault();
        post(this, 'set_project');
    });
    function initHapusProject(idx) {
        var d = project[idx];
        var m = $('#modalHapus');
        m.modal('show');
        m.find('.input-nama').val(d.nama);
        m.find('.input-id').val(d.id);
    }
    $('#formDeleteProject').submit(function (e) {
        e.preventDefault();
        post(this, 'set_project');
    });
    function initEditProject(idx) {
        var m = $('#modalCreate');
        var d = project[idx];
        m.modal('show');
        m.find('.modal-title').html('Edit Proyek');
        m.find('.input-nama').val(d.nama);
        m.find('.input-id').prop('required', true);
        m.find('.input-id').val(d.id);
        m.find('.input-desc').val(d.deskripsi);
        m.find('.btn-save').attr('name', 'edit');
        m.find('.input-mode').val('edit');
    }
    tbTugas = $('#tableTugas').DataTable({
        "bLengthChange": false,
        "order": [],
        "columnDefs": [
            {
                "targets": [0, 4],
                "visible": false,
            },
            {"max-width": '1%', 'target': 1}
        ],
    });
    function getTugas() {
        $.getJSON('project_tugas/get_tugas', null, function (data) {
            tbTugas.clear();
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                d.txtPelaksana = '';
                for (var p of d.pelaksana) {
                    d.txtPelaksana += '<span class="badge badge-secondary ml-2">' + p.fullname + '</span>';
                }
                tbTugas.row.add([
                    d.tanggal,
                    d.project,
                    d.tugas,
                    d.txtPelaksana,
                    'file',
                    d.deadline,
                    '<button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUploadTugas(' + i + ')"></button>'
                            + '<button class="btn btn-sm btn-outline-primary fa fa-edit ml-1" onclick="initEditTugas(' + i + ')"></button>'
                            + '<button class="btn btn-sm btn-outline-primary fa fa-info-circle ml-1" onclick="detailTugas(' + i + ')"></button>'
                            + '<button class="btn btn-sm btn-outline-danger fa fa-trash ml-1" onclick="initHapusTugas(' + i + ')"></button>'
                            ,
                ]);
            }
            tbTugas.draw();
            data[i] = d;
            tugas = data;
        });
    }
    $('#createTugas').click(function () {
        var m = $('#modalTugasBaru');
        m.modal('show');
        m.find('.modal-title').html('Buat Tugas Baru');
        m.find('form').trigger('reset');
        m.find('.select-personil').trigger('change');
        m.find('.input-mode').val('create');
        m.find('.btn-save').attr('name', 'create');
        m.find('.input-id-tugas').prop('required', false);
    });
    $('#formTugas').submit(function (e) {
        e.preventDefault();
        post(this, 'set_tugas');
    });
    function initEditTugas(idx) {
        var m = $('#modalTugasBaru');
        m.modal('show');
        var d = tugas[idx];
        m.find('.input-id-tugas').prop('required', true);
        m.find('.modal-title').html('Edit Tugas');
        $('#submitButton').attr('name', 'edit');
        m.find('.input-id-tugas').val(d.id_tugas);
        m.find('.input-id-jadwal').val(d.id);
        m.find('.select-dokumen').val(d.id_document);
        m.find('.input-tugas').val(d.tugas);
        m.find('.select-form').val(d.form_terkait);
        m.find('.select-sifat').val(d.sifat);
        m.find('.select-proyek').val(d.id_project);
        var pel = [];
        for (var p of d.pelaksana) {
            pel.push(p.id);
        }
        m.find('.select-personil').val(pel).trigger('change');
        m.find('.input-tanggal').val(d.tanggal);
        m.find('.input-mode').val('edit');
    }
    function initHapusTugas(idx) {
        var d = tugas[idx];
        var m = $('#modalDeleteTugas');
        m.modal('show');
        m.find('.input-tugas').html(d.tugas);
        m.find('.input-id-tugas').val(d.id_tugas);
        m.find('.input-mode').val('delete');
    }
    $('#formDeleteTugas').submit(function (e) {
        e.preventDefault();
        post(this, 'set_tugas');
    });
    function detailTugas(idx) {
        var d = tugas[idx];
        console.log(d);
        var txtPelaksana = '';
        for (var p of d.pelaksana) {
            txtPelaksana += '<span class="badge badge-secondary ml-2">' + p.fullname + '</span>';
        }
        var data2 = {
            Proyek: (d.project != null ? d.project : '-'),
            Tugas: d.tugas,
            'SOP Terkait': $('.select-dokumen option[value=' + d.id_document + ']').html(),
            'Form Terkait': (d.form_terkait != null ? $('.select-form option[value=' + d.form_terkait + ']').html() : '-'),
            'Pemberi Tugas': '-',
            'Pelaksana Tugas': txtPelaksana,
            Sifat: d.sifat,
            Jadwal: d.tanggal,
        };
        showDetail('Detail Tugas', data2, 4);
    }
    function initUploadTugas(idx) {
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
            switchUpload();
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
    function switchUpload() {
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
        post(this, 'set_tugas');
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
    $('#filterPersonil').change(function () {
        tbTugas.columns(5).search($(this).val()).draw();
    });
    $('#filterPeriode').change(function () {
        console.log('filter status');
        tbTugas.columns(0).search($(this).val()).draw();
    });
    var minDate, maxDate;
    minDate = $('#minDate');
    maxDate = $('#maxDate');
    $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var min = new Date(minDate.val());
                var max = new Date(maxDate.val());
                var date = new Date(data[0]);
                if (
                        (isNaN(min) && isNaN(max)) ||
                        (isNaN(min) && date <= max) ||
                        (min <= date && isNaN(max)) ||
                        (min <= date && date <= max)
                        ) {
                    return true;
                }
                return false;
            }
    );
</script>