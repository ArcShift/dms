<?php ?>
<div class="card">
    <div class="card-header">
        <?= $project->nama ?>
        &nbsp;
        <sup class="text-primary fa fa-info-circle" title="<?= $project->deskripsi ?>"></sup>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-sm-2">
                <button class="btn btn-sm btn-outline-primary fa fa-plus" id="btnTugasBaru"> Tambah Tugas</button>
            </div>
            <div class="col-sm-2"></div>
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
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tugas</th>
                    <th>Pelaksana</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                    <th>Aksi</th>
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
                            <div class="form-group">
                                <label><b>Sifat</b></label>
                                <select class="form-control select-sifat" required="" name="sifat">
                                    <option value="">~ Sifat ~</option>
                                    <option value="WAJIB">Wajib</option>
                                    <option value="SITUASIONAL">Situasional</option>
                                </select>
                            </div>

                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><b>Pemberi Tugas</b></label>
                                <select class="form-control select-pembuat" name="pembuat" style="width: 100% !important;">
                                    <option value="">~ Personil ~</option>
                                    <?php foreach ($personil as $k => $p) { ?>
                                        <option value="<?= $p->id ?>"><?= $p->fullname ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label><b>Pelaksana Tugas</b></label>
                                <select class="form-control select-personil select2" multiple="" required="" name="personil[]" style="width: 100% !important;">
                                    <?php foreach ($personil as $k => $p) { ?>
                                        <option value="<?= $p->id ?>"><?= $p->fullname ?></option>
                                    <?php } ?>
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
<script>
    $(document).ready(function () {
        $('.select2').select2();
        $('.dataTables_filter .form-control').attr('placeholder', 'Cari');
        $('.div-filter-cari').append($('.dataTables_filter .form-control'));
        $('.dataTables_filter').hide();
    });
    $('#filterStatus').change(function () {
        tbMain.columns(4).search($(this).val()).draw();
    });
    $('#filterPeriode').change(function () {
        console.log('filter status');
        tbMain.columns(3).search($(this).val()).draw();
    });
    function afterReady() {}
    tbMain = $('table').DataTable({
        "bLengthChange": false,
    });
    getTugas();
    function getTugas() {
        $.getJSON('<?= site_url($module . '/get_tugas') ?>', null, function (data) {
            tbMain.clear();
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                var pelaksana = '';
                for (var j = 0; j < d.pelaksana.length; j++) {
                    var pel = d.pelaksana[j];
                    pelaksana += '<img class="rounded-circle" style="object-fit: cover" src="' + (pel.photo == null ? '<?= base_url('assets/images/default_user.jpg') ?>' : '<?= base_url('upload/profile_photo/') ?>' + pel.photo) + '" width="30" height="30" title="' + pel.fullname + '">';
                }
                tbMain.row.add([
                    i + 1,
                    d.tugas,
                    pelaksana,
                    d.tanggal,
                    d.deadline,
                    '<button class="btn btn-sm btn-outline-primary fa fa-edit ml-1" onclick="initEdit(' + i + ')"></button>'
                            + '<button class="btn btn-sm btn-outline-danger fa fa-trash ml-1" onclick="initDelete(' + i + ')"></button>',
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
        post(this, 'set_tugas');
    });
    function initDelete(idx) {
        var d = tugas[idx];
        var m = $('#modalDelete');
        m.modal('show');
        m.find('.input-tugas').html(d.tugas);
        m.find('.input-id-tugas').val(d.id_tugas);
    }
    $('#formDelete').submit(function (e) {
        e.preventDefault();
        post(this, 'set_tugas');
    });
    function initEdit(idx) {
        var m = $('#modalTugasBaru');
        m.modal('show');
        var d = tugas[idx];
        console.log(d);
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
        m.find('.select-pembuat').val(d.pembuat);
        var pel = [];
        for (var p of d.pelaksana) {
            pel.push(p.id);
        }
        m.find('.select-personil').val(pel).trigger('change');
        m.find('.input-tanggal').val(d.tanggal);
        m.find('.input-mode').val('edit');
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