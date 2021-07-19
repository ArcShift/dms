<?php
//print_r($usulan);
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
<!--TABLE-->
<div class="main-card card">
    <div class="card-body">
        <div class="row div-filter">
            <div class="col-sm-6">
                <button class="btn btn-sm btn-outline-primary" id="btnCreate"><i class="fa fa-plus"></i> Buat usulan</button>
            </div>
            <div class="col-sm-2 col-search-box">
            </div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm" id='filterStatus'>
                    <option value="">Semua usulan</option>
                    <option value="1">Usulan selesai</option>
                    <option value="0">Usulan ditolak</option>
                    <option value="-">Menunggu</option>
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
                    <th>Usulan</th>
                    <th>Status Usulan</th>
                    <th>Tanggal Usulan</th>
                    <th>Umpan Balik</th>
                    <th>Aksi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usulan as $k => $u) { ?>
                    <tr>
                        <td class="details-control"></td>
                        <td><?= $u->nama ?></td>
                        <td>
                            <?php if (!empty($u->pic_approve)) { ?>
                                <span class="badge badge-success">Ketua Disetujui</span>
                                <br/>
                                <span class="badge badge-success">PIC disetujui</span>
                            <?php } else { ?>
                                <div class="btn-group">
                                    <span class="badge badge-info" data-toggle="dropdown">Menunggu <i class="fa fa-info-circle"></i></span>
                                    <div class="dropdown-menu">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="text-nowrap">Tim Terkait</th>
                                                    <th class="text-nowrap">Status Usulan</th>
                                                    <th class="text-nowrap">Tanggal Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Ketua</td>
                                                    <td>
                                                        <?php if ($u->ketua_approve == 1) { ?>
                                                            Disetujui
                                                        <?php } elseif ($u->ketua_approve == 0) { ?>
                                                            Ditolak
                                                        <?php } else { ?>
                                                            Menunggu
                                                        <?php } ?>
                                                    </td>
                                                    <td><?= $u->ketua_tgl_approve ?></td>
                                                </tr>
                                                <tr>
                                                    <td>PIC</td>
                                                    <td>Menunggu</td>
                                                    <td>-</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <?php } ?>
                        </td>
                        <td><?= $u->created_at ?></td>
                        <td>
                            Ketua :<?= $u->ketua_feedback ?>
                            <br>
                            PIC :<?= $u->pic_feedback ?>
                        </td>
                        <td>
                            <?php if (empty($u->ketua_approve)) { ?>
                                <button class="btn btn-sm btn-outline-primary fa fa-edit"></button>
                                <button class="btn btn-sm btn-outline-danger fa fa-trash" onclick="initDelete(<?= $k ?>)"></button>
                            <?php } ?>
                        </td>
                        <td><?= $u->pic_approve==null?'-':$u->pic_approve ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--FORM CREATE-->
<div class="modal fade" id="modalCreate">
    <div class="modal-dialog">
        <form id="formCreate" method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <input class="input-id" name="id" hidden=""/>
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Buat usulan sebagai <i class="text-danger">*</i></b></label>
                        <select class="form-control" name="jabatan" required="">
                            <?php foreach ($unit_kerja as $k => $uk) { ?>
                                <option value="<?= $uk->id ?>"><?= $uk->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>Usulan <i class="text-danger">*</i></b></label>
                        <textarea class="form-control" name="usulan" required=""></textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Standar</b></label>
                        <select class="form-control" name="standar" id="selectStandar">
                            <option value="">~ Standard ~</option>
                            <?php foreach ($standard as $k => $s) { ?>
                                <option value="<?= $s->id ?>"><?= $s->name ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group standard-child">
                        <label><b>Dokumen</b></label>
                        <select class="form-control" name="dokumen" id="selectDokumen">
                            <option></option>
                        </select>
                    </div>
                    <div class="form-group standard-child">
                        <label><b>Form</b></label>
                        <select class="form-control" name="form" id="selectForm">
                            <option></option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-outline-primary" id="btnSubmit" value="ok">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!--MODAL DELETE-->
<div class="modal fade" id="modalDelete">
    <div class="modal-dialog">
        <form method="post">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Hapus Usulan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id" name="id" hidden=""/>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    data = <?= json_encode($usulan) ?>;
    console.log(data);
    $(document).ready(function () {
        tbMain = $('#tbMain').DataTable({
            "bLengthChange": false,
            "order": [],
            "columnDefs": [
                {"targets": [6], "visible": false}
            ]
        });
        $('.dataTables_filter .form-control').attr('placeholder', 'Cari');
        $('.div-filter .col-search-box').eq(0).append($('.dataTables_filter .form-control'));
        $('.dataTables_filter').hide();
    });
    $('#filterPeriode').change(function () {
        tbMain.columns(3).search($(this).val()).draw();
    });
    $('#filterStatus').change(function () {
        tbMain.columns(6).search($(this).val()).draw();
    });
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
    function format(idx) {
        var d = data[idx];
        return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<td>Standar</td>' +
                '<td>' + d.standar + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td>Dokumen</td>' +
                '<td>' + d.dokumen + '</td>' +
                '</tr>' +
                '<tr>' +
                '<tr>' +
                '<td>Form</td>' +
                '<td>' + d.form + '</td>' +
                '</tr>' +
                '<tr>' +
                '</table>';
    }
    $('#btnCreate').click(function () {
        var m = $('#modalCreate');
        m.modal('show');
        m.find('.modal-title').text('Buat Usulan');
        $('#btnSubmit').attr('name', 'create');
        $('.standard-child').hide();
    });
    $('#selectStandar').change(function () {
        $('#selectDokumen').empty();
        $('#selectForm').empty();
        $('#selectDokumen').append('<option value="">~ Dokumen ~</option>');
        $('#selectForm').append('<option value="">~ Form ~</option>');
        if ($(this).val() == '') {
            $('.standard-child').hide();
        } else {
            $('.standard-child').show();
            $.getJSON('<?= site_url('users/usulan/get_dokumen') ?>', {standard: $(this).val()}, function (data) {
                var dokumen = data['dokumen'];
                var formTerkait = data['form_terkait'];
                for (var i = 0; i < dokumen.length; i++) {
                    $('#selectDokumen').append('<option value="' + dokumen[i].id + '">' + dokumen[i].judul + '</option>');
                }
                for (var i = 0; i < formTerkait.length; i++) {
                    $('#selectForm').append('<option value="' + formTerkait[i].id + '">' + formTerkait[i].judul + '</option>');
                }
            });
        }
    });
    function initDelete(idx) {
        var m = $('#modalDelete');
        m.modal('show');
    }
</script>

