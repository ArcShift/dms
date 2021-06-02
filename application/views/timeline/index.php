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
        <b>Progress Timeline Sertifikasi <?= $this->session->activeStandard['name'] ?></b>
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
                    <td><span class="badge badge-danger" id="statusGap"></span></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Training</td>
                    <td>Training Awareness</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td><span class="badge badge-danger">0%</span></td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Training Internal</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Analisa Resiko</td>
                    <td>[doc pasal 6]</td>
                    <td></td>
                    <td><span class="badge badge-danger">0%</span></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Pengembangan Dokumen</td>
                    <td></td>
                    <td></td>
                    <td><span class="badge badge-danger">0%</span></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Distribusi Dokumen</td>
                    <td></td>
                    <td></td>
                    <td><span class="badge badge-danger">0%</span></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Implementasi Dokumen</td>
                    <td></td>
                    <td></td>
                    <td><span class="badge badge-danger">0%</span></td>
                    <td></td>
                </tr>
                <tr>
                    <td><?= $n++ ?></td>
                    <td>Audit Internal Sistem</td>
                    <td></td>
                    <td></td>
                    <td><span class="badge badge-danger">0%</span></td>
                </tr>
                <tr>
                    <td>8</td>
                    <td>Tinjauan Manajemen</td>
                    <td></td>
                    <td></td>
                    <td><span class="badge badge-danger">0%</span></td>
                </tr>
                <tr>
                    <td>9</td>
                    <td>Submit Dokumen</td>
                    <td></td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td><span class="badge badge-danger">0%</span></td>
                </tr>
                <tr>
                    <td></td>
                    <td>Audit Eksternal Stage 1</td>
                    <td>Jadwal Audit External Stage 1</td>
                    <td>
                        <button class="btn btn-sm btn-outline-primary fa fa-upload"></button>
                        <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                    </td>
                    <td><span class="badge badge-danger">0%</span></td>
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
                    <td><span class="badge badge-danger">0%</span></td>
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
                    <td><span class="badge badge-success">100%</span></td>
                </tr>
            </tbody>
        </table>
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
                            <?php foreach ($document as $d) { ?>
                                <option value="<?= $d['id'] ?>"><?= $d['judul'] ?></option>
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
<script>
    $('.fa-upload').click(function () {
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
            console.log(data);
            if(data!=null){
                $('#judulGap').html(data.gap_analisa);
                $('#statusGap').html(data.statusGap+'%');
            }
        });
    }
</script>