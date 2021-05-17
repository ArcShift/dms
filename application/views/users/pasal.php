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
                            <button class="btn btn-sm btn-outline-primary fa fa-info-circle" onclick="detail(<?= $k ?>)"></button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
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
            'Judul Pasal': d.sort_desc==null?'-':d.sort_desc,
            'Judul Dokumen': d.dokumen.length == 0 ? '-' : d.dokumen[0].judul,
            'Letak Pasal pada Dokumen': d.dokumen.length == 0 ? '-' : d.dokumen[0].deskripsi,
        };
        showDetail('Detail Pasal', data, 2);
    }
</script>