<!--TABLE-->
<div class="main-card card">
    <div class="card-body">
        <div class="row div-filter">
            <div class="col-sm-3">
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>Pasal</th>
                    <th>Judul Pasal</th>
                    <th>Deskripsi Pasal</th>
                    <th>Dokumen Terkait</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pasal as $k => $p) { ?>
                    <tr>
                        <td><?= $p['name'] ?></td>
                        <td><?= $p['sort_desc'] ?></td>
                        <td style="white-space: pre-wrap"><?= $p['long_desc'] ?></td>
                        <td>
                            <ul>
                                <?php foreach ($p['dokumen'] as $k2 => $d) { ?>
                                    <li><?= $d['judul'] ?></li>
                                <?php } ?>
                            </ul>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="detailPasal(<?= $k ?>)"></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<!--MODAL DETAIL PASAL-->
<div class="modal fade" id="modalDetailPasal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Pasal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body modal-message">
                    <div class="form-group">
                        <label><b>Judul Pasal</b></label>
                        <div class="card-body bg-light p-2 text-judul"></div>
                    </div>
                    <div class="form-group">
                        <label><b>Deskripsi</b></label>
                        <div class="card-body bg-light p-2 text-deskripsi" style="white-space: pre-wrap"></div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Judul Dokumen</th>
                                <th>Pasal Terkait</th>
                                <th style="width: 40%">Letak Pasal pada Dokumen</th>
                                <th style="width: 90px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="files"></tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    var pasal = <?= json_encode($pasal) ?>;
    $('.dataTables_filter .form-control').attr('placeholder', 'Search');
    $('.div-filter .col-sm-3').eq(0).append($('.dataTables_filter .form-control'));
    function detail(idx) {
        var d = pasal[idx];
        console.log(d);
        var txtPasal = '';
        var txtPelaksana = '';
        var data = {
            Pasal: d.name,
            'Judul Pasal': d.sort_desc == null ? '-' : d.sort_desc,
            'Judul Dokumen': d.dokumen.length == 0 ? '-' : d.dokumen[0].judul,
            'Letak Pasal pada Dokumen': d.dokumen.length == 0 ? '-' : d.dokumen[0].deskripsi,
        };
//        var data = {
//            'Judul Pasal': d.sort_desc==null?'-':d.sort_desc,
//            'Deskripsi': d.long_desc==null?'-':d.long_desc,
//        }
        showDetail(d.name, data, null);        
    }
    function detailPasal(index) {
        var m = $('#modalDetailPasal');
        var p = pasal[index];
        m.modal('show');
        m.find('.modal-title').text(p.name);
        m.find('.text-judul').html(p.sort_desc);
        m.find('.text-deskripsi').html(p.long_desc);
        m.find('.files').empty();
        for (var i = 0; i < p.dokumen.length; i++) {
            var d = p.dokumen[i];
            var link;
            if (d.type_doc == 'FILE') {
                link = '<a class="btn btn-primary btn-sm fa fa-download" target="_blank" href="<?= base_url('upload/dokumen') ?>/' + d.file + '"></a>';
            } else {
                link = '<a class="btn btn-primary btn-sm fa fa-search" target="_blank" href="' + d.url + '"></a>';
            }
            var txtPasal = '';
            for (var j = 0; j < d.pasal.length; j++) {
                var pt = d.pasal[j];
                txtPasal += '<div><span class="badge badge-secondary">' + pt.name + '</span></div>';
            }
            m.find('.files').append('<tr>'
                    + '<td>' + (i + 1) + '</td>'
                    + '<td>' + d.judul + '</td>'
                    + '<td><div class="card-body bg-light p-2" style="white-space: pre-wrap; height: 80px; overflow-y: auto">' + txtPasal + '</div></td>'
                    + '<td style="white-space: pre-wrap">' + (d.deskripsi) + '</td>'
                    + '<td>' + link
                    + '</td>'
                    + '</tr>');
        }
    }
</script>