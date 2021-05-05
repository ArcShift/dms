<!--TABLE-->
<div class="main-card card">   
    <div class="card-body"> 
        <table class="table data-table">
            <thead>
                <tr>
                    <th>No Dokumen</th>
                    <th>Judul Dokumen</th>
                    <th>Revisi</th>
                    <th>Level</th>
                    <th>Klasifikasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($docs as $k => $d) { ?>
                    <tr>
                        <td><?= $d['nomor'] ?></td>
                        <td><a href="<?= $d['type_doc'] == 'FILE' ? base_url('upload/dokumen/' . $d['file']) : $d['url'] ?>" target="_blank"><?= $d['judul'] ?></a></td>
                        <td><?= $d['versi'] ?></td>
                        <td><?= $d['jenis'] ?></td>
                        <td><?= $d['klasifikasi'] ?></td>
                        <td>
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
    var docs = <?= json_encode($docs) ?>;
    function detail(idx) {
        var d = docs[idx];
        console.log(d);
        var txtPasal = '';
        var txtPelaksana = '';
        var path = d.type_doc == 'FILE' ? '<?= base_url('upload/dokumen/') ?>' + d.file : d.url;
        var pasal = '';
        for (var p of d.pasal) {
            pasal += '<li>' + p.fullname + '</li>';
        }
        var data = {
            'Nomor Dokumen': d.nomor,
            'Judul Dokumen': d.judul,
            'Pasal Terkait': pasal,
            'Letak Pasal pada Dokumen': d.deskripsi,
            'Pembuat Dokumen': d.pembuat,
            'Level Dokumen': d.jenis,
            'Klasifikasi Dokumen': (d.klasifikasi != null ? d.klasifikasi : '-'),
            'Dokumen Terkait': (d.dokumen_terkait!= null?d.dokumen_terkait.judul:'-'),
            'File Dokumen': '<a href="' + path + '" target="_blank">' + path + '</a>',
        };
        showDetail('Detail Tugas', data);
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
