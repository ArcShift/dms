<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a data-toggle="tab" href="#tab-proyek" class="nav-link">Proyek</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#tab-tugas" class="nav-link">Tugas</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane" id="tab-proyek" role="tabpanel">
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
            <div class="tab-pane active" id="tab-tugas" role="tabpanel">
                <button class="btn btn-sm btn-outline-primary" id="btnTugasBaru">Buat Tugas Baru</button>
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
<script>
    getProject();
    getTugas();
    $(document).ready(function () {
        $('#tableTugas_filter .form-control').attr('placeholder', 'Search');
        $('.div-filter .col-sm-2').eq(0).append($('#tableTugas_filter .form-control'));
        $('#tableTugas_filter').hide();
    });
    function afterReady() {
    }
    tbPro = $('#tableProject').DataTable();
    function getProject() {
        $.getJSON('project_tugas/get_project', null, function (data) {
            tbPro.clear();
            for (var i = 0; i < data.length; i++) {
                var d = data[i];
                tbPro.row.add([
                    d.nama,
                    d.deskripsi,
                    '<span class="badge badge-' + (d.tugas == 0 ? 'danger' : 'primary') + '">' + d.tugas + '</span>',
                    '<button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="initEditProject(' + i + ')"></button>'
                            + (d.tugas == 0 ? '<button class="btn btn-sm btn-outline-danger fa fa-trash ml-1" onclick="initHapusProject(' + i + ')"></button>' : ''),
                ]);
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
                tbTugas.row.add([
                    d.tanggal,
                    d.project,
                    d.tugas,
                    'loop penerima',
                    'file',
                    d.deadline,
                    '<button class="btn btn-sm btn-outline-primary fa fa-edit" onclick="initEditProject(' + i + ')"></button>'
                            + (d.tugas == 0 ? '<button class="btn btn-sm btn-outline-danger fa fa-trash ml-1" onclick="initHapusProject(' + i + ')"></button>' : ''),
                ]);
            }
            tbTugas.draw();
            tugas = data;
            console.log(tugas);
        });
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
                        getProject();
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