<?php
$n = 1;
?>
<style>
    .col-cust{
        width: 20%;
    }
</style>
<div class="card">
    <div class="card-body">
        <b>Progress Kesiapan Sertifikasi <?= $this->session->activeStandard['name'] ?></b>
        <div class="progress">
            <div class="progress-bar bg-danger" style="width: 20%">Tidak Siap Sama Sekali</div>
            <div class="progress-bar bg-warning" style="width: 20%">Belum Siap</div>
            <div class="progress-bar" style="width: 20%; background-color: yellow">Setengah Siap</div>
            <div class="progress-bar bg-primary" style="width: 20%">Sudah Siap</div>
            <div class="progress-bar bg-success" style="width: 20%">Sudah Siap Sekali</div>
        </div>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Timeline</th>
                    <th>Judul Dokumen</th>
                    <th>Aksi</th>
                    <th>Status</th>
                    <th>Asal Data</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Gap Analisa</td>
                    <td id="judulGap"></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="initGap()"></button>
                    </td>
                    <td id="statusGap"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Training</td>
                    <td>Training Awareness</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('training_awareness', 'Training Awareness')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td id="statusTrainingAwareness"></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Training Internal</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('training_internal', 'Training Internal')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td id="statusTrainingInternal"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Analisa Resiko</td>
                    <td>[doc pasal 6]</td>
                    <td></td>
                    <td><span class="badge badge-danger">n%</span></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Pengembangan Dokumen</td>
                    <td></td>
                    <td></td>
                    <td id="statusDoc"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Distribusi Dokumen</td>
                    <td></td>
                    <td></td>
                    <td id="statusDistribusi"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Implementasi Dokumen</td>
                    <td></td>
                    <td></td>
                    <td id="statusImp"></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Audit Internal Sistem</td>
                    <td></td>
                    <td></td>
                    <td><span class="badge badge-danger">n%</span></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Tinjauan Manajemen</td>
                    <td></td>
                    <td></td>
                    <td><span class="badge badge-danger">n%</span></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Submit Dokumen</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('submit_dokumen', 'Submit Dokumen')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td id="statusSubmitDokumen"></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Audit Eksternal Stage 1</td>
                    <td>Jadwal Audit External Stage 1</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td><span class="badge badge-danger">n%</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Audit Plan</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Foto Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Temuan Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Hasil Perbaikan Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Audit Eksternal Stage 2</td>
                    <td>Gap Analisa 2021</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td><span class="badge badge-danger">n%</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Jadwal Audit External Stage 2</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Audit Plan</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Foto Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Temuan Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Hasil Perbaikan Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pemenuhan Total</td>
                    <td></td>
                    <td>9/9</td>
                    <td><span class="badge badge-success">n%</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL GAP-->
<div class="modal fade" id="modalGap">
    <div class="modal-dialog">
        <form id="formGap" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Modal Gap</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select class="form-control" name="gap">
                            <option value="">~ Pilih Gap ~</option>
                            <?php foreach ($gapAnalisa as $g) { ?>
                                <option value="<?= $g->id ?>"><?= $g->judul ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" id="btnSubmit" name="tambah" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL UPLOAD FOTO-->
<div class="modal fade" id="modalUpload1">
    <div class="modal-dialog">
        <form method="post" id="formUpload1" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Upload</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input name="header" hidden="" id="inputHeader">
                    <div class="form-group group-upload">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio1" name="type" value="file" class="custom-control-input radio-upload" required="">
                            <label class="custom-control-label" for="customRadio1">File</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio2" name="type" value="url" class="custom-control-input radio-upload">
                            <label class="custom-control-label" for="customRadio2">Url</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio3" name="type" value="foto" class="custom-control-input radio-upload">
                            <label class="custom-control-label" for="customRadio3">Foto</label>
                        </div>
                    </div>
                    <div class="form-group group-upload">
                        <input class="form-control input-bukti input-file" type="file" name="file">
                        <input class="form-control input-bukti input-url" type="url" name="url">
                        <input class="form-control input-bukti input-foto" type="file" name="foto" id="inputFoto" accept="image/*">
                    </div>
                    <img class="text-center" id="imgUpload" src="#" alt="" width="200"/>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" id="btnSubmit" name="tambah" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL UPLOAD-->
<div class="modal fade" id="modalUpload">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group group-upload">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio1" name="type" value="file" class="custom-control-input radio-bukti">
                            <label class="custom-control-label" for="customRadio1">File</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio2" name="type" value="url" class="custom-control-input radio-bukti">
                            <label class="custom-control-label" for="customRadio2">Url</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="customRadio3" name="type" value="doc" class="custom-control-input radio-bukti">
                            <label class="custom-control-label" for="customRadio3">Pilih dari Menu Dokumen</label>
                        </div>
                    </div>
                    <div class="form-group group-upload">
                        <input class="form-control input-bukti input-file" type="file" name="userfile">
                        <input class="form-control input-bukti input-url" type="url" name="url">
                        <select class="form-control input-bukti select-doc" name="doc">
                            <option value="">~ Pilih Dokumen ~</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                    <button class="btn btn-primary" id="btnSubmit" name="tambah" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('.fa-upload2').click(function () {
        var m = $('#modalUpload');
        m.modal('show');
        m.find('#btnSubmit').attr('name', 'tambah');
        m.find('#btnSubmit').html('Upload');
        m.find('.modal-title').html('Upload');
        $('.input-bukti').hide();
        $('.radio-bukti').prop('checked', false);
        $('.input-bukti').prop('required', false);
        $('.input-bukti').val('');
    });
    $('.radio-bukti').change(function () {
        var type = $(this).val();
        var m = $('#modalUpload');
        if (type == 'file') {
            m.find('.input-bukti').prop('required', false);
            m.find('.input-bukti').hide();
            m.find('.input-file').prop('required', true);
            m.find('.input-file').show();
        } else if (type == 'url') {
            m.find('.input-bukti').hide();
            m.find('.input-bukti').prop('required', false);
            m.find('.input-url').show();
            m.find('.input-url').prop('required', true);
        } else if (type == 'doc') {
            m.find('.input-bukti').hide();
            m.find('.input-bukti').prop('required', false);
            m.find('.select-doc').show();
            m.find('.select-doc').prop('required', true);
        }
    });
    function getGap() {

    }
    function initGap() {
        var m = $('#modalGap');
        m.modal('show');
    }
    $('#formGap').submit(function (e) {
        e.preventDefault();
        $('#modalGap').modal('hide');
        $.post('<?= $module . '/set_gap' ?>', $(this).serialize(), function (data) {
            getTimeline();
        });
    });
    getTimeline();
    function getTimeline() {
        $.getJSON('<?= $module . '/get_timeline' ?>', null, function (data) {
//            console.log(data);
            $('#judulGap').html(data.gap_analisa);
            $('#statusGap').html(badgeColor(data.statusGap));
            if (data.training_awareness_path != null & data.training_awareness_type != null) {
                $('#statusTrainingAwareness').html(badgeColor(100));
            } else {
                $('#statusTrainingAwareness').html(badgeColor(0));
            }
            if (data.training_internal_path != null & data.training_internal_type != null) {
                $('#statusTrainingInternal').html(badgeColor(100));
            } else {
                $('#statusTrainingInternal').html(badgeColor(0));
            }
            $('#statusDistribusi').html(badgeColor(data.statusDistribusi));
            if (data.submit_dokumen_path != null & data.submit_dokumen_type != null) {
                $('#statusSubmitDokumen').html(badgeColor(100));
            } else {
                $('#statusSubmitDokumen').html(badgeColor(0));
            }
        });
        $.getJSON('<?= 'dashboard/get_pemenuhan' ?>', null, function (data) {
            console.log(data);
            var doc = [];
            var imp = [];
            for (var i = 0; i < data.length; i++) {
                var p = data[i];
                doc.push(p.pemenuhanDoc);
                imp.push(p.pemenuhanImp);
            }
            $('#statusDoc').html(badgeColor(average(doc)));
            $('#statusImp').html(badgeColor(average(imp)));
        });
    }
    function badgeColor(val) {
        var badge = '';
        switch (val) {
            case 0:
                badge = 'danger';
                break;
            case 100:
                badge = 'success';
                break;
            default:
                badge = 'warning';
                break;
        }
        return '<span class="badge badge-' + badge + '">' + val + '%</span>';
    }
    function average(arr) {
        var sum = 0;
        for (var i = 0; i < arr.length; i++) {
            sum += parseInt(arr[i], 10);
        }
        return Math.round(sum / arr.length);
    }
    function initUpload1(header, title) {
        var m = $('#modalUpload1');
        m.modal('show');
        $('.input-bukti').hide();
        m.find('#inputHeader').val(header);
        m.find('.modal-title').html('Upload ' + title);
        m.find('.radio-upload').prop('checked', false);
    }
    $('#modalUpload1').on('hidden.bs.modal', function () {
        console.log('close');
        document.getElementById('imgUpload').scr = '';//TODO: reset image not work
    });
    var imgInp = document.getElementById('inputFoto');
    var blah = document.getElementById('imgUpload');
    imgInp.onchange = evt => {
        const [file] = imgInp.files
        if (file) {
            blah.src = URL.createObjectURL(file);
        }
    }
    $('.radio-upload').change(function () {
        var type = $(this).val();
        var m = $('#modalUpload1');
        if (type == 'file') {
            m.find('.input-bukti').prop('required', false);
            m.find('.input-bukti').hide();
            m.find('.input-file').prop('required', true);
            m.find('.input-file').show();
        } else if (type == 'url') {
            m.find('.input-bukti').hide();
            m.find('.input-bukti').prop('required', false);
            m.find('.input-url').show();
            m.find('.input-url').prop('required', true);
        } else if (type == 'foto') {
            m.find('.input-bukti').hide();
            m.find('.input-bukti').prop('required', false);
            m.find('.input-foto').show();
            m.find('.input-foto').prop('required', true);
        }
    });
    $('#formUpload1').submit(function (e) {
        e.preventDefault();
        $('#modalUpload1').modal('hide');
        console.log($(this).serialize());
        post(this, 'upload1');
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
                        getTimeline();
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