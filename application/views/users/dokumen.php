<!--TABLE-->
<div class="main-card card">   
    <div class="card-body"> 
        <table class="table" id="mainTable">
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
                            <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="detail(<?= $k ?>)"></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    var docs = <?= json_encode($docs) ?>;
    var tbMain = $('#mainTable').DataTable();
    function detail(idx) {
        var d = docs[idx];
        console.log(d);
        var txtPasal = '';
        var txtPelaksana = '';
        var path = d.type_doc == 'FILE' ? '<?= base_url('upload/dokumen/') ?>' + d.file : d.url;
        var file = d.type_doc == 'FILE' ?  d.file : d.url;
        var pasal = '';
        for (var p of d.pasal) {
            pasal += '<li class="ml-3">' + p.fullname + '</li>';
        }
        var data = {
            'Nomor Dokumen': d.nomor,
            'Judul Dokumen': d.judul,
            'Pasal Terkait': pasal,
            'Letak Pasal pada Dokumen': d.deskripsi,
            'Revisi Dokumen': d.versi,
            'Pembuat Dokumen': d.pembuat,
            'Level Dokumen': d.jenis,
            'Klasifikasi Dokumen': (d.klasifikasi != null ? d.klasifikasi : '-'),
            'Dokumen Terkait': (d.dokumen_terkait != null ? d.dokumen_terkait.judul : '-'),
            'File Dokumen': '<a href="' + path + '" target="_blank">' + (file==null?'':file) + '</a>',
        }
        showDetail('Detail Dokumen', data, 5);
    }
    <?php if($this->input->get('s')){ ?>
        $('input[type="search"]').val('<?=$this->input->get('s')?>').keyup()
    <?php }?>
</script>
