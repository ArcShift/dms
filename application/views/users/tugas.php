<?php
//print_r($this->session->user);
?>
<style>
    td.details-control {
        background: url('https://datatables.net/examples/resources/details_open.png') no-repeat center;
        cursor: pointer;
        width: 30px;
    }
    tr.shown td.details-control {
        background: url('https://datatables.net/examples/resources/details_close.png') no-repeat center;
    }
</style>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<!--TABLE-->
<div class="main-card card">
    <div class="card-body">
        <div class="row div-filter">
            <div class="col-sm-4">
                <button class="btn btn-sm btn-outline-primary fa fa-plus" id="btnTugasBaru"> Buat Tugas Baru</button>

            </div>
            <!--<div class="col-sm-2">-->
                <!--<input class="form-control form-control-sm" onfocus="(this.type='date')" id="minDate" placeholder="Tanggal Awal">-->
                <!--<input class="form-control form-control-sm" onfocus="(this.type='date')" id="maxDate" placeholder="Tanggal Akhir">-->
            <!--</div>-->
            <div class="col-sm-2 col-search-box">
            </div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" id='filterAsal'>
                    <option value="">~ Semua Tugas ~</option>
                    <option value="PIC">Tugas masuk</option>
                    <option value="MANDIRI">Tugas Saya</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" id='filterStatus'>
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
        <table class="table" id="tbMain">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tugas</th>
                    <!--<th>Pelaksana</th>-->
                    <th>Pemberi Tugas</th>
                    <!--<th>Form Terkait</th>-->
                    <th>Jadwal</th>
                    <!--<th>Bukti</th>-->
                    <th>Status</th>
                    <th>Asal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $k => $d) { ?>
                    <tr>
                        <td class="details-control"></td>
                        <td><?= $d->tugas ?></td>
                        <td>
                            <?= empty($d->pembuat) ? '-' : '<img class="rounded-circle" style="object-fit: cover" src="' . ($d->photo == null ? base_url('assets/images/default_user.jpg') : base_url('upload/profile_photo/') . $d->photo) . '" width="30" height="30" title="' . $d->pembuat . '">' ?>
                        </td>
                        <td><?= $d->tanggal ?></td>
                        <td><?= $d->deadline ?></td>
                        <td><?= $d->asal ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload(<?= $k ?>)"></button>
                            <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="detail(<?= $k ?>)"></button>
                            <?php if ($d->asal == 'MANDIRI') { ?>
                                <button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="initEdit(<?= $k ?>)"></button>
                                <button class="btn btn-sm btn-outline-danger fa fa-trash" onclick="initDelete(<?= $k ?>)"></button>
                            <?php } ?>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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
<!--MODAL TUGAS BARU-->
<div class="modal fade" id="modalTugasBaru">
    <div class="modal-dialog" role="document">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buat Tugas Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id" name="id" hidden=""/>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Judul Tugas <i class="text-danger">*</i></b></label>
                                <div class="col-sm-7">
                                    <input class="form-control input-tugas" name="nama" required="" placeholder="Tulis judul tugas">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Proyek</b></label>
                                <div class="col-sm-7">
                                    <select class="form-control" name="proyek">
                                        <option value="" class="default-select">Tidak terikat proyek</option>
                                        <?php foreach ($proyek as $k => $p) { ?>
                                            <option value="<?= $p->id ?>"><?= $p->nama ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Buat Tugas Sebagai <i class="text-danger">*</i></b></label>
                                <div class="col-sm-7">
                                    <select class="form-control" required="" id="selectJabatan" name="jabatan">
                                        <?php foreach ($unit_kerja as $k => $uk) { ?>
                                            <option value="<?= $uk->jabatan ?>"><?= $uk->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Sifat <i class="text-danger">*</i></b></label>
                                <div class="col-sm-7">
                                    <select class="form-control select-sifat" required="" name="sifat">
                                        <option value="" class="default-select">Pilih Sifat Tugas</option>
                                        <option value="WAJIB">Wajib</option>
                                        <option value="SITUASIONAL">Situasional</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Jadwal <i class="text-danger">*</i></b></label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="date" name="jadwal" required="" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Bukti Implementasi</b></label>
                                <div class="col-sm-7">
                                    <input class="radio-bukti2" type="radio" name="type_dokumen" value="file">
                                    <label>File</label>
                                    <input class="radio-bukti2" type="radio" name="type_dokumen" value="url">
                                    <label>Url</label>
                                    <i class="text-primary fa fa-window-close" id="cancelRadioBukti"></i>
                                    <input class="form-control input-bukti input-file" type="file" name="dokumen">
                                    <input class="form-control input-bukti input-url" type="url" name="url">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="newTugas" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL EDIT TUGAS-->
<div class="modal fade" id="modalEdit">
    <div class="modal-dialog">
        <form method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Tugas</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id" name="id" hidden=""/>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Judul Tugas <i class="text-danger">*</i></b></label>
                                <div class="col-sm-7">
                                    <input class="form-control input-tugas" name="nama" required="" placeholder="Tulis judul tugas">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Proyek</b></label>
                                <div class="col-sm-7">
                                    <select class="form-control select-proyek" name="proyek">
                                        <option value="" class="default-select">Tidak terikat proyek</option>
                                        <?php foreach ($proyek as $k => $p) { ?>
                                            <option value="<?= $p->id ?>"><?= $p->nama ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Buat Tugas Sebagai <i class="text-danger">*</i></b></label>
                                <div class="col-sm-7">
                                    <select class="form-control select-jabatan" required="" name="jabatan">
                                        <?php foreach ($unit_kerja as $k => $uk) { ?>
                                            <option value="<?= $uk->jabatan ?>"><?= $uk->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Sifat <i class="text-danger">*</i></b></label>
                                <div class="col-sm-7">
                                    <select class="form-control select-sifat" required="" name="sifat">
                                        <option value="" class="default-select">Pilih Sifat Tugas</option>
                                        <option value="WAJIB">Wajib</option>
                                        <option value="SITUASIONAL">Situasional</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-form-label col-sm-5"><b>Jadwal <i class="text-danger">*</i></b></label>
                                <div class="col-sm-7">
                                    <input class="form-control" type="date" name="jadwal" required="" value="<?= date('Y-m-d') ?>">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="edit" value="ok">Simpan</button>
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
                        <label>Nama Tugas</label>
                        <input class="input-id-tugas" name="id" required="" hidden="">
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
            "columnDefs": [
                {"targets": [5], "visible": false}
            ]
        });
        $('#minDate, #maxDate').on('change', function () {
            tbMain.draw();
        });
        $('.dataTables_filter .form-control').attr('placeholder', 'Cari');
        $('.div-filter .col-search-box').eq(0).append($('.dataTables_filter .form-control'));
        $('.dataTables_filter').hide();
        $('#tbMain tbody').on('click', 'td.details-control', function () {
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
    function detail(idx) {
        var d = data[idx];
        console.log(d);
        var txtPelaksana = '';
        for (var p of d.pelaksana) {
            txtPelaksana += '<li>' + p.fullname + '</li>';
        }
        var data2 = {
            'Tugas': d.tugas,
            'Form Terkait': d.form_terkait != null ? d.form_terkait.judul : '-',
            Sifat: d.sifat,
            'PIC Pelaksana': '<div class="ml-3">' + txtPelaksana + '<div>',
            Periode: (d.periode != null ? d.periode + 'AN' : '-'),
            Jadwal: d.tanggal,
            Status: d.deadline,
            Asal: d.asal,
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
    $('#btnTugasBaru').click(function () {
        var m = $('#modalTugasBaru');
        m.modal('show');
        m.find('.input-bukti').hide();
        $('.radio-bukti2').prop('checked', false);
        $('#cancelRadioBukti').hide();
    });
    $('.radio-bukti2').change(function () {
        var type = $(this).val();
        var m = $('#modalTugasBaru');
        $('#cancelRadioBukti').show();
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
    $('#cancelRadioBukti').click(function () {
        var m = $('#modalTugasBaru');
        $('.radio-bukti2').prop('checked', false);
        m.find('.input-bukti').hide();
        m.find('.input-bukti').prop('required', false);
        $(this).hide();
    });
    function initEdit(idx) {
        var m = $('#modalEdit');
        var d = data[idx];
        console.log(d);
        m.modal('show');
        m.find('.input-id').val(d.id);
        m.find('.input-tugas').val(d.tugas);
        m.find('.select-proyek').val(d.id_project);
        m.find('.select-sifat').val(d.sifat);
        m.find('.select-jabatan').val(d.jabatan);
        m.find('.input-jd').val(d.tanggal);
    }
    function initDelete(idx) {
        var d = data[idx];
        var m = $('#modalDelete');
        m.modal('show');
        m.find('.input-tugas').html(d.tugas);
        m.find('.input-id-tugas').val(d.id_tugas);
    }
    $('#filterStatus').change(function () {
        tbMain.columns(4).search($(this).val()).draw();
    });
    $('#filterPeriode').change(function () {
        tbMain.columns(3).search($(this).val()).draw();
    });
    $('#filterAsal').change(function () {
        tbMain.columns(5).search($(this).val()).draw();
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
    function format(idx) {
        var d = data[idx];
//        var pembuat = ' - ';
        var editDelete = '';
//        if (d.pembuat != null) {
//            pembuat = '<img class="rounded-circle" style="object-fit: cover" src="' + (d.photo == null ? '<?= base_url('assets/images/default_user.jpg') ?>' : '<?= base_url('upload/profile_photo/') ?>' + d.photo) + '" width="30" height="30" title="' + d.pembuat + '">';
//        }
        if (d.asal == 'MANDIRI') {
            editDelete = '<a class="dropdown-item" onclick="initEdit(' + idx + ')">Ubah</a>'
                    + '<a class="dropdown-item" onclick="initDelete(' + idx + ')">Hapus</a>';
        }
        var pelaksana = '';
        for (var p of d.pelaksana) {
            pelaksana += '<img class="rounded-circle" style="object-fit: cover" src="' + (p.photo == null ? '<?= base_url('assets/images/default_user.jpg') ?>' : '<?= base_url('upload/profile_photo/') ?>' + p.photo) + '" width="30" height="30" title="' + p.fullname + '">';
        }
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Penerima Tugas:</td>' +
                '<td>' + pelaksana + '</td>' +
                '</tr>' +
                '<tr>' +
                '<td>Proyek:</td>' +
                '<td>' + (d.project == null ? '-' : d.project) + '</td>' +
                '</tr>' +
                '</table>';
    }
</script>