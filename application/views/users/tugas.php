<!--TABLE-->
<div class="main-card card">   
    <div class="card-body"> 
        <table class="table">
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
                        <label>Tugas</label>
                        <input class="form-control input-tugas" disabled="">
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input class="form-control input-field input-jadwal" name="tanggal" disabled="">
                    </div>
                    <div class="form-group">
                        <label>Dokumen</label>
                        <div id="tdUpload">
                            <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="FILE" required="">
                            <label>File</label>
                            <input class="radio-type-dokumen" type="radio" name="type_dokumen" value="URL">
                            <label>Url</label>
                            <input class="form-control input-path input-file" type="file" name="dokumen" required="">
                            <input class="form-control input-path input-url" type="url" name="url" required="">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
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
            Pasal: '-',
            'Judul Pasal': '-',
            'Deskripsi Pasal': '-',
            'Judul Dokumen': d.dokumen.judul,
            'Tugas': d.tugas,
            'Form Terkait': '-',
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
    }
</script>