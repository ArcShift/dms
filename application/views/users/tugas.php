<!--TABLE-->
<div class="main-card card">   
    <div class="card-body"> 
        <table class="table data-table">
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
                        <td><?= $d->tanggal ?></td>
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
<!--MODAL DETAIL-->
<div class="modal fade" id="modalDetail">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button class="btn btn-primary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!--MODAL UPLOAD IMPLEMENTASI-->
<div class="modal fade" id="modalUploadImplementasi">
    <div class="modal-dialog" role="document">
        <form id="formUploadImplementasi">
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
                                <input type="radio" id="customRadio1" name="type" value="file" class="custom-control-input radio-bukti">
                                <label class="custom-control-label" for="customRadio1">File</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input type="radio" id="customRadio2" name="type" value="url" class="custom-control-input radio-bukti">
                                <label class="custom-control-label" for="customRadio2">Url</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <input class="form-control input-file" type="file" name="userfile">
                            <input class="form-control input-url" type="url" name="url">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-simpan">Simpan</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var data = <?= json_encode($data) ?>;
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
            'PIC Pelaksana': txtPelaksana,
            Periode: (d.periode != null ? d.periode + 'AN' : '-'),
            Jadwal: d.tanggal,
            Status: d.deadline,
        };
        showDetail('Detail Tugas', data2);
    }
    function showDetail(title, data) {
        var m = $('#modalDetail');
        m.modal('show');
        m.find('.modal-title').text(title);
        m.find('.modal-body').empty();
        for (var key in data) {
            m.find('.modal-body').append('<div class="row"><div class="col-sm-4"><label>' + key + '</label></div><div class="col-sm-8">' + data[key] + '</div></div>');
        }
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
    $('#formUploadImplementasi').submit(function (e) {
        e.preventDefault();
        post(this, 'upload_bukti');
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
                        getPasal();
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