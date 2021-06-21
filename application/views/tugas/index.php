<?php
//print_r($this->session->user);
?>
<style>
    /*    table{
            margin: 0 auto;
            width: 100%;
            clear: both;
            border-collapse: collapse;
            table-layout: fixed; // ***********add this
            word-wrap:break-word; // ***********and this
        }*/
/*    th{
        max-width: 10px!important;
        overflow-x: hidden;
    }
    td{
        max-width: 30px!important;
        overflow-x: hidden;
    }*/
</style>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!--TABLE-->
<div class="main-card card">
    <div class="card-body">
        <button class="btn btn-sm btn-outline-primary float-right" id="btnTugasBaru">Buat Tugas Baru</button>
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
            <table class="table" id="tbMain">
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
                <tbody style="z">
                    <?php foreach ($data as $k => $d) { ?>
                        <tr>
                            <td><?= $d->tanggal ?></td>
                            <td style="max-width: 200px"><?= $d->project ?></td>
                            <td style="max-width: 200px"><?= $d->tugas ?></td>
                            <td>
                                <?php foreach ($d->pelaksana as $k2 => $p) { ?>
                                    <div><span class="badge badge-secondary"><?= $p->fullname ?></span></div>
                                <?php } ?>
                            </td>
                            <td>
                                <a href="<?= $d->doc_type == 'FILE' ? base_url('upload/implementasi/' . $d->path) : $d->path ?>"><?= $d->path ?></a>
                            </td>
                            <td><?= $d->deadline ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload(<?= $k ?>)"></button>
                                <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="detail(<?= $k ?>)"></button>
                                <button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="initEdit(<?= $k ?>)"></button>
                                <button class="btn btn-sm btn-outline-danger fa fa-trash" onclick="initDelete(<?= $k ?>)"></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
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
                    <input class="input-id-tugas" name="id_tugas" hidden="">
                    <input class="input-id-jadwal" name="id_jadwal" hidden=""/>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label><b>Proyek</b></label>
                                <select class="form-control select-proyek" name="proyek">
                                    <option value="">~ Proyek ~</option>
                                    <?php foreach ($project as $k => $p) { ?>
                                        <option value="<?= $p->id ?>"><?= $p->nama ?></option>
                                    <?php } ?>
                                </select>
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
        <form method="post">
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
    var data = <?= json_encode($data) ?>;
    $(document).ready(function () {
        tbMain = $('#tbMain').DataTable({
            "bLengthChange": false,
            "order": [],
//            responsive: true,
            "columnDefs": [
                {
                    "targets": [0, 4],
                    "visible": false,
//                    "searchable": false
                },
                {"max-width":'1%', 'target':1}
            ],
            
        });
        $('#minDate, #maxDate').on('change', function () {
            tbMain.draw();
        });
        $('.dataTables_filter .form-control').attr('placeholder', 'Search');
        $('.div-filter .col-sm-2').eq(0).append($('.dataTables_filter .form-control'));
        $('.dataTables_filter').hide();

    });
    function afterReady() {
        $('.select2').select2();
    }
    function detail(idx) {
        var d = data[idx];
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
            'Pemberi Tugas': (d.pembuat != null ? $('.select-pembuat option[value=' + d.pembuat + ']').html() : '-'),
            'Pelaksana Tugas': txtPelaksana,
            Sifat: d.sifat,
            Jadwal: d.tanggal,
        };
        showDetail('Detail Tugas', data2, 4);
    }
    function initUpload(idx) {
        $('#formUploadImplementasi').trigger('reset');
        var d = data[idx];
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
    $('#btnTugasBaru').click(function () {
        var m = $('#modalTugasBaru');
        m.modal('show');
        m.find('.modal-title').html('Buat Tugas Baru');
        $('#formTugas').trigger('reset');
        $('#submitButton').attr('name', 'newTugas');
        m.find('.select-personil').val('').trigger('change');
    });
    function initEdit(idx) {
        var m = $('#modalTugasBaru');
        m.modal('show');
        var d = data[idx];
        m.find('.modal-title').html('Edit Tugas');
        $('#submitButton').attr('name', 'editTugas');
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
        m.find('.select-pembuat').val(d.pembuat);
        m.find('.select-personil').val(pel).trigger('change');
        m.find('.input-tanggal').val(d.tanggal);
    }
    function initDelete(idx) {
        var d = data[idx];
        var m = $('#modalDelete');
        m.modal('show');
        m.find('.input-tugas').html(d.tugas);
        m.find('.input-id-tugas').val(d.id_tugas);
    }
    $('#filterPersonil').change(function () {
        tbMain.columns(5).search($(this).val()).draw();
    });
    $('#filterPeriode').change(function () {
        console.log('filter status');
        tbMain.columns(0).search($(this).val()).draw();
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