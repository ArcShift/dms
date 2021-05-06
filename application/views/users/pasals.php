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
            'Penjelasan Pasal': (d.penjelasan!=null?d.penjelasan:'-'),
            'Bukti Pasal': (d.bukti!=null?d.bukti:'-'),
//            'Judul Pasal': d.sort_desc==null?'-':d.sort_desc,
//            'Judul Dokumen': d.dokumen.length == 0 ? '-' : d.dokumen[0].judul,
//            'Letak Pasal pada Dokumen': d.dokumen.length == 0 ? '-' : d.dokumen[0].deskripsi,
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