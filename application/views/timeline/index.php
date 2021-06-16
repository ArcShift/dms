<?php
$n = 1;
//print_r($standard);
?>
<style>
    .col-cust{
        width: 20%;
    }
</style>
<div class="card">
    <div class="card-body">
        <b>Progress Kesiapan Sertifikasi <?= $this->session->activeStandard['name'] ?></b>
        <div class="row">
            <div class="col-sm-11">
                <div class="progress mt-1">
                    <div id="progress20" class="progress-bar bg-danger" style="width: 20%">Tidak Siap Sama Sekali</div>
                    <div id="progress40" class="progress-bar bg-warning" style="width: 20%">Belum Siap</div>
                    <div id="progress60" class="progress-bar text-primary" style="width: 20%; background-color: yellow">Setengah Siap</div>
                    <div id="progress80" class="progress-bar bg-primary" style="width: 20%">Sudah Siap</div>
                    <div id="progress100" class="progress-bar bg-success" style="width: 20%">Sudah Siap Sekali</div>
                </div>
            </div> 
            <div class="col-sm-1">
                <b><span id="titleProgress" class="text-primary"></span></b>
            </div> 
        </div>
        <br>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Timeline</th>
                    <th>Paramater</th>
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
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initGap()"></button>
                    </td>
                    <td id="statusGap"></td>
                    <td><?= $standard['desc_gap_analisa'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Training</td>
                    <td>Training Awareness</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('training_awareness', 'Training Awareness')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('training_awareness', 'Training Awareness')"></button>
                    </td>
                    <td id="statusTrainingAwareness"></td>
                    <td><?= $standard['desc_training_awareness'] ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Training Audit Internal</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('training_internal', 'Training Internal')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('training_internal', 'Training Internal')"></button>
                    </td>
                    <td id="statusTrainingInternal"></td>
                    <td><?= $standard['desc_training_audit_internal'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Analisa Resiko</td>
                    <td><?= isset($standard['pasal_name_analisa_resiko']) ? $standard['pasal_name_analisa_resiko'] : '' ?></td>
                    <td></td>
                    <td id="statusPasalAnalisaResiko"></span></td>
                    <td><?= $standard['desc_analisa_resiko'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Pengembangan Dokumen</td>
                    <td></td>
                    <td></td>
                    <td id="statusDoc"></td>
                    <td><?= $standard['desc_pengembangan_dokumen'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Distribusi Dokumen</td>
                    <td></td>
                    <td></td>
                    <td id="statusDistribusi"></td>
                    <td><?= $standard['desc_distribusi_dokumen'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Implementasi Dokumen</td>
                    <td></td>
                    <td></td>
                    <td id="statusImp"></td>
                    <td><?= $standard['desc_implementasi_dokumen'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Penetration Testing</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('pentest', 'Penetration Testing', true)"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('pentest', 'Penetration Testing')"></button>
                    </td>
                    <td id="statusPentest"></td>
                    <td><?= $standard['desc_pentest'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Business Continuity Planning</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('bcp', 'Business Continuity Planning')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('bcp', 'Business Continuity Planning')"></button>
                    </td>
                    <td id="statusBcp"></td>
                    <td><?= $standard['desc_bcp'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Audit Internal Sistem</td>
                    <td><?= isset($standard['pasal_name_audit_internal']) ? $standard['pasal_name_audit_internal'] : '' ?></td>
                    <td></td>
                    <td id="statusPasalAuditInternal"></td>
                    <td><?= $standard['desc_audit_internal'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Tinjauan Manajemen</td>
                    <td><?= isset($standard['pasal_name_tinjauan_manajemen']) ? $standard['pasal_name_tinjauan_manajemen'] : '' ?></td>
                    <td></td>
                    <td id="statusPasalTinjauanManajemen"></td>
                    <td><?= $standard['desc_tinjauan_manajemen'] ?></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Submit Dokumen</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('submit_dokumen', 'Submit Dokumen')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('submit_dokumen', 'Submit Dokumen')"></button>
                    </td>
                    <td id="statusSubmitDokumen"></td>
                    <td><?= $standard['desc_submit_dokumen'] ?></td>
                </tr>
                <tr id="group_jadwal_audit">
                    <td><?= $n++ ?></td>
                    <td>Audit Eksternal Stage 1</td>
                    <td>Jadwal Audit External Stage 1</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('jadwal_audit', 'Jadwal Audit Eksternal Stage 1')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('jadwal_audit', 'Jadwal Audit Eksternal Stage 1')"></button>
                    </td>
                    <td id="statusStage1"></td>
                    <td><?= $standard['desc_jadwal_audit'] ?></td>
                </tr>
                <tr id="group_audit_plan">
                    <td></td>
                    <td></td>
                    <td>Audit Plan</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('audit_plan', 'Audit Plan Stage 1')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('audit_plan', 'Audit Plan Stage 1')"></button>
                    </td>
                    <td><?= $standard['desc_audit_plan'] ?></td>
                </tr>
                <tr id="group_foto_audit">
                    <td></td>
                    <td></td>
                    <td>Foto Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('foto_audit', 'Foto Audit Stage 1')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('foto_audit', 'Foto Audit Stage 1')"></button>
                    </td>
                    <td></td>
                </tr>
                <tr id="group_temuan_audit">
                    <td></td>
                    <td></td>
                    <td>Temuan Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('temuan_audit', 'Temuan Audit Stage 1')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('temuan_audit', 'Temuan Audit Stage 1')"></button>
                    </td>
                    <td><?= $standard['desc_temuan_audit'] ?></td>
                </tr>
                <tr id="group_hasil_perbaikan_audit">
                    <td></td>
                    <td></td>
                    <td>Hasil Perbaikan Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('hasil_perbaikan_audit', 'Hasil Perbaikan Audit Stage 1')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('hasil_perbaikan_audit', 'Hasil Perbaikan Audit Stage 1')"></button>
                    </td>
                    <td><?= $standard['desc_hasil_perbaikan_audit'] ?></td>
                </tr>
                <tr id="group_gap_analisa_audit">
                    <td><?= $n++ ?></td>
                    <td>Audit Eksternal Stage 2</td>
                    <td>Gap Analisa 2021</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('gap_analisa_audit', 'Gap Analisa Audit')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('gap_analisa_audit', 'Gap Analisa Audit')"></button>
                    </td>
                    <td id="statusStage2"></td>
                    <td><?= $standard['desc_gap_analisa_audit'] ?></td>
                </tr>
                <tr id="group_jadwal_audit2">
                    <td></td>
                    <td></td>
                    <td>Jadwal Audit External Stage 2</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('jadwal_audit2', 'Jadwal Audit External Stage 2')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('jadwal_audit2', 'Jadwal Audit External Stage 2')"></button>
                    </td>
                    <td><?= $standard['desc_jadwal_audit2'] ?></td>
                </tr>
                <tr id="group_audit_plan2">
                    <td></td>
                    <td></td>
                    <td>Audit Plan</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('audit_plan2', 'Audit Plan Stage 2')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('audit_plan2', 'Audit Plan Stage 2')"></button>
                    </td>
                    <td><?= $standard['desc_audit_plan2'] ?></td>
                </tr>
                <tr id="group_foto_audit2">
                    <td></td>
                    <td></td>
                    <td>Foto Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('foto_audit2', 'Foto Audit Stage 2')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('foto_audit2', 'Foto Audit Stage 2')"></button>
                    </td>
                    <td><?= $standard['desc_foto_audit2'] ?></td>
                </tr>
                <tr id="group_temuan_audit2">
                    <td></td>
                    <td></td>
                    <td>Temuan Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('temuan_audit2', 'Temuan Audit Stage 2')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('temuan_audit2', 'Temuan Audit Stage 2')"></button>
                    </td>   
                    <td><?= $standard['desc_temuan_audit2'] ?></td>
                </tr>
                <tr id="group_hasil_perbaikan_audit2">
                    <td></td>
                    <td></td>
                    <td>Hasil Perbaikan Audit</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload1('hasil_perbaikan_audit2', 'Hasil Perbaikan Audit Stage 2')"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="preview('hasil_perbaikan_audit2', 'Hasil Perbaikan Audit Stage 2')"></button>
                    </td>
                    <td><?= $standard['desc_hasil_perbaikan_audit2'] ?></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Pemenuhan Total</td>
                    <td></td>
                    <td><b><span id="countPemenuhan"></span>/<?= --$n ?></b></td>
                    <td id="pemenuhanTotal"></td>
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
                        <div class="custom-control custom-radio custom-control-inline radio-group-foto">
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
<!--MODAL PREVIEW-->
<div class="modal fade" id="modalPreview">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="previewMessage"><b>File belum diupload</b></div>
                <div class="form-group">
                    <label><b>Type</b></label>
                    <div class="card-body bg-light p-2" id="previewType"></div>
                </div>
                <div class="form-group">
                    <label><b>File</b></label>
                    <div class="card-body bg-light p-2" id="previewFile"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" id="btnSubmit" name="tambah" value="ok">Simpan</button>
            </div>
        </div>
    </div>
</div>
<script>
    var standard = <?= json_encode($standard) ?>;
    function afterReady() {
        $('#statusPasalAnalisaResiko').html(badgeColor(standard['status_pasal_analisa_resiko']));
        $('#statusPasalAuditInternal').html(badgeColor(standard['status_pasal_audit_internal']));
        $('#statusPasalTinjauanManajemen').html(badgeColor(standard['status_pasal_audit_internal']));
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
    var listProgress;
    var stage1 = ['jadwal_audit', 'audit_plan', 'foto_audit', 'temuan_audit', 'hasil_perbaikan_audit'];
    var stage2 = ['gap_analisa_audit', 'jadwal_audit2', 'audit_plan2', 'foto_audit2', 'temuan_audit2', 'hasil_perbaikan_audit2'];
    var stage3 = stage1.concat(stage2);
    var timeline;
    function getTimeline() {
        $.getJSON('<?= $module . '/get_timeline' ?>', null, function (data) {
            timeline = data;
            $('#judulGap').html(data.gap_analisa);
            $('#statusGap').html(badgeColor(data.statusGap));
            $('#statusDistribusi').html(badgeColor(data.statusDistribusi));
            stage(stage2, 'Stage2');
            updateTable();
        });
    }
    function status(header, status) {
        var s = 0;
        if (timeline[header + '_type'] != null & timeline[header + '_path'] != null) {
            s = 100;
        }
        $('#status' + status).html(badgeColor(s));
        return s;
    }
    function stage(stage, status) {
        var count = 0
        var sum = 0
        for (var st of stage) {
            if (timeline[st + '_type'] != null & timeline[st + '_path'] != null) {
                count++;
            }
        }
        sum = Math.round(count / stage.length * 100);
        $('#status' + status).html(badgeColor(sum));
        return sum;
    }
    function updateTable() {
        for (var s of stage3) {
            $('#group_' + s + ' td .fa-check').remove();
            if (timeline[s + '_type'] != null & timeline[s + '_path'] != null) {
                $('#group_' + s + ' td').eq(2).append(' <span class="text-success fa fa-check"></span>');
            }
        }
        $.getJSON('<?= 'dashboard/get_pemenuhan' ?>', null, function (data) {
            var doc = [];
            var imp = [];
            for (var i = 0; i < data.length; i++) {
                var p = data[i];
                doc.push(p.pemenuhanDoc);
                imp.push(p.pemenuhanImp);
            }
            $('#statusDoc').html(badgeColor(average(doc)));
            $('#statusImp').html(badgeColor(average(imp)));
            listProgress = {
                gap: timeline.statusGap,
                training: Math.round((status('training_awareness', 'TrainingAwareness') + status('training_internal', 'TrainingInternal')) / 2),
                analisaResiko: standard['status_pasal_analisa_resiko'],
                pengembanganDokumen: average(doc),
                distribusiDokumen: timeline.statusDistribusi,
                implementasiDokumen: average(imp),
                pentest: status('pentest', 'Pentest'),
                bcp: status('bcp', 'Bcp'),
                auditInternal: standard['status_pasal_audit_internal'],
                tinjauanManajemen: standard['status_pasal_audit_internal'],
                submitDokumen: status('submit_dokumen', 'SubmitDokumen'),
                auditStage1: stage(stage1, 'Stage1'),
                auditStage2: stage(stage2, 'Stage2'),
            }
            var sum = 0;
            var length = 0;
            var cComplete = 0;
            for (var item in listProgress) {
                sum += parseInt(listProgress[item]);
                    length++;
                if (parseInt(listProgress[item]) == 100) {
                    cComplete++;//TODO: count total pemenuhan
                }
            }
            aveProgress = Math.round(sum / length);
            for (var i = 1; i <= 5; i++) {
                var n = i * 20;
                if (aveProgress >= n) {
                    $('#progress' + n).width('20%');
                } else if (aveProgress <= n - 20) {
                    $('#progress' + n).width('0%');
                } else {
                    $('#progress' + n).width((aveProgress - (n - 20)) + '%');
                }
            }
            $('#titleProgress').html(aveProgress + '%');
            $('#pemenuhanTotal').html(badgeColor(aveProgress));
            $('#countPemenuhan').html(cComplete);
        });
    }
    function badgeColor(val) {
        val = parseInt(val);
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
    function initUpload1(header, title, nofoto = false) {
        var m = $('#modalUpload1');
        m.modal('show');
        blah.src = '';
        $('.input-bukti').hide();
        m.find('#inputHeader').val(header);
        m.find('.modal-title').html('Upload ' + title);
        m.find('.radio-upload').prop('checked', false);
        m.find('.form-control').val('');
        if (nofoto) {
            m.find('.radio-group-foto').hide();
        } else {
            m.find('.radio-group-foto').show();
    }
    }
    $('#modalUpload1').on('hidden.bs.modal', function () {
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
        post(this, 'upload1');
    });
    function preview(header, title) {
        var m = $('#modalPreview');
        m.find('.card-body').empty();
        m.modal('show');
        m.find('.modal-title').html('Preview ' + title);
        var type = timeline[header + '_type'];
        var path = timeline[header + '_path'];
        $('#previewType').html('<div class="badge badge-secondary">' + type + '</div>');
        var prev = '';
        m.find('.form-group').show();
        $('#previewMessage').hide();
        switch (type) {
            case 'FILE':
                prev = '<a href="<?= base_url('upload/') ?>' + header + '/' + path + '">' + path + '</a>';
                break;
            case 'URL':
                prev = '<a href="' + path + '">' + path + '</a>';
                break;
            case 'FOTO':
                prev = '<img src="<?= base_url('upload/') ?>' + header + '/' + path + '" height="200"></img>';
                break;
            case null:
                m.find('.form-group').hide();
                $('#previewMessage').show();
                break;
        }
        $('#previewFile').html(prev);
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