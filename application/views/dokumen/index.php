<div class="card">
    <div class="card-body">
        <ul class="nav nav-tabs">
            <li class="nav-item"><a data-toggle="tab" href="#tabPasal" class="nav-link active">Pasal</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#tabDokumen" class="nav-link">Dokumen</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#taDistribusi" class="nav-link">Distribusi</a></li>
        </ul>
    </div>
    <div class="tab-content p-3">
        <div class="tab-pane" id="tabPasal">
            <table class="table">
                <thead>
                    <tr>
                        <th>Pasal</th>
                        <th>Judul</th>
                        <th>Deskripsi</th>
                        <th>Judul Dokumen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pasal as $k => $v) { ?>
                        <tr>
                            <td><?= $v['name'] ?></td>
                            <td><?= $v['sort_desc'] ?></td>
                            <td><?= $v['long_desc'] ?></td>
                            <td>
                                <ul>
                                    <?php foreach ($v['document'] as $k2 => $v2) { ?>
                                        <li><?= $v2['judul'] ?></li>
                                    <?php } ?>
                                </ul>
                            </td>
                            <td>
                                <button class="btn text-primary fa fa-info-circle"></button>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="tab-pane active" id="tabDokumen">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nomor</th>
                        <th>Judul</th>
                        <th>Pasal</th>
                        <th>Revisi</th>
                        <th>Level</th>
                        <th>Klasifikasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="tbodyDokumen"></tbody>
            </table>
        </div>
        <div class="tab-pane" id="tabDistribusi">
            Distribusi
        </div>
    </div>
</div>
<script>
    getDokumen();
    function getDokumen() {
        $.getJSON('<?= site_url($module . '/get') ?>', null, function (data) {
            if (Array.isArray(data)) {
                for (var i = 0; i < data.length; i++) {
                    d = data[i];
                    $('#tbodyDokumen').append('<tr>'
                            + '<td>' + d.nomor + '</td>'
                            + '<td>' + d.judul + '</td>'
                            + '<td>' + 'pasal' + '</td>'
                            + '<td>' + d.versi + '</td>'
                            + '<td>' + d.jenis + '</td>'
                            + '<td>' + d.klasifikasi + '</td>'
                            + '</tr>');
                }
            }
            console.log(data);
        });
    }
</script>