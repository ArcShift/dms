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
                    <td><?= empty($d->form_terkait)?'-':$d->form_terkait->judul ?></td>
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
<script>
    var data = <?= json_encode($data) ?>;
    function detail(idx) {
        var d = data[idx];
        console.log(d);
        var txtPasal = '';
        var txtPelaksana = '';
        var data2 = {
            Pasal: '-',
            'Judul Pasal': '-',
            'Deskripsi Pasal': '-',
            'Judul Dokumen': '-',
            'Tugas': '-',
            'Form Terkait': '-',
            Sifat: '-',
            'PIC Pelaksana': '-',
            Periode: '-',
            Jadwal: '-',
            Status: d.deadline,
//            Pasal: txtPasal,
//            'Judul Dokumen': d.document.judul,
//            Tugas: d.tugas,
//            'Form Terkait': d.form_terkait,
//            Sifat: d.sifat,
//            'PIC Pelaksana': txtPelaksana,
//            Periode: (d.periode!=null?d.periode + 'AN':'-'),
//            Jadwal: d.tanggal,
//            Status: d.deadline.toUpperCase(),
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
</script>
<?php
//print_r($data);
