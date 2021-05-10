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
            <div class="col-sm-3"></div>
            <div class="col-sm-3">
                <input class="form-control form-control-sm" id="dateSearch" placeholder="Search by date range..">
            </div>
            <div class="col-sm-3">
                <select class="form-control form-control-sm" id='filterPersonil'>
                    <option value="">~ Status ~</option>
                    <option value="selesai">Selesai</option>
                    <option value="terlambat">Terlambat</option>
                    <option value="menunggu">Menunggu</option>
                </select>
            </div>
            <div class="col-sm-3">
                <select class="form-control form-control-sm" id='filterPeriode'>
                    <option value="">~ Periode ~</option>
                    <option value="<?= date('d/m/Y') ?>">Hari ini</option>
                    <option value="<?= date('m/Y') ?>">Bulan ini</option>
                    <option value="<?= date('Y') ?>">Tahun ini</option>
                </select>
            </div>
        </div>
        <table class="table" id="tbMain">
            <thead>
                <tr>
                    <th>Jadwal</th>
                    <th>Tugas</th>
                    <th>Form Terkait</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data as $k => $d) { ?>
                    <tr>
                        <td><?= date_format(date_create($d->tanggal), 'd/m/Y') ?></td>
                        <td><?= $d->tugas ?></td>
                        <td><?= empty($d->form_terkait) ? '-' : $d->form_terkait->judul ?></td>
                        <td><?= $d->path ?></td>
                        <td><?= $d->deadline ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary fa fa-upload" onclick="initUpload(<?= $k ?>)"></button>
                            <button class="btn btn-sm btn-outline-primary fa fa-search" onclick="detail(<?= $k ?>)"></button>
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
                </div>s
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
                    <h5 class="modal-title">Tugas Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input class="input-id" name="id" hidden=""/>
                    <div class="form-group">
                        <label><b>Dokumen</b></label>
                        <select class="form-control">
                            <option value="">~Dokumen~</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label><b>Pilih Dokumen</b></label>
                        <select class="form-control">
                            <option value="">~Dokumen~</option>
                        </select>
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
    var data = <?= json_encode($data) ?>;
    $(document).ready(function () {
        tbMain = $('#tbMain').DataTable({
            "bLengthChange": false,
        });
        $('.dataTables_filter .form-control').attr('placeholder', 'Search');
        $('.div-filter .col-sm-3').eq(0).append($('.dataTables_filter .form-control'));
        $('.dataTables_filter').hide();
        $('#dateSearch').daterangepicker({
            autoUpdateInput: false
        });
        $('#dateSearch').on('apply.daterangepicker', function (ev, picker) {
            $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            start_date = picker.startDate.format('DD/MM/YYYY');
            end_date = picker.endDate.format('DD/MM/YYYY');
            $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
            tbMain.draw();
        });
        $('#dateSearch').on('cancel.daterangepicker', function (ev, picker) {
            $(this).val('');
            start_date = '';
            end_date = '';
            $.fn.dataTable.ext.search.splice($.fn.dataTable.ext.search.indexOf(DateFilterFunction, 1));
            tbMain.draw();
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
            Pasal: d.dokumen.pasal[0].fullname,
            'Judul Pasal': d.dokumen.pasal[0].sort_desc,
            'Deskripsi Pasal': d.dokumen.pasal[0].long_desc,
            'Judul Dokumen': d.dokumen.judul,
            'Tugas': d.tugas,
            'Form Terkait': d.form_terkait != null ? d.form_terkait.judul : '-',
            Sifat: d.sifat,
            'PIC Pelaksana': '<div class="ml-3">' + txtPelaksana + '<div>',
            Periode: (d.periode != null ? d.periode + 'AN' : '-'),
            Jadwal: d.tanggal,
            Status: d.deadline,
        };
        showDetail('Detail Tugas', data2, 5);
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
        $('.btn-simpan').show();
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
    });
    var start_date;
    var end_date;
    var DateFilterFunction = (function (oSettings, aData, iDataIndex) {
        var dateStart = parseDateValue(start_date);
        var dateEnd = parseDateValue(end_date);
        var evalDate = parseDateValue(aData[0]);
        if ((isNaN(dateStart) && isNaN(dateEnd)) ||
                (isNaN(dateStart) && evalDate <= dateEnd) ||
                (dateStart <= evalDate && isNaN(dateEnd)) ||
                (dateStart <= evalDate && evalDate <= dateEnd))
        {
            return true;
        }
        return false;
    });
    function parseDateValue(rawDate) {
        var dateArray = rawDate.split("/");
        var parsedDate = new Date(dateArray[2], parseInt(dateArray[1]) - 1, dateArray[0]);  // -1 because months are from 0 to 11   
        return parsedDate;
    }
    $('#filterPersonil').change(function () {
        tbMain.columns(4).search($(this).val()).draw();
    });
    $('#filterPeriode').change(function () {
        console.log('filter status');
        tbMain.columns(0).search($(this).val()).draw();
    });
</script>