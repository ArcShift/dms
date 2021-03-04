<div class="card">
    <div class="card-body">
        <?php foreach ($distribution as $k => $d) { ?>
            <div class="alert alert-primary" role="alert">
                Anda ditambahkan pada sebagai daftar distribusi pada dokumen "<?= $d['judul'] ?>"
                <div class="text-right"><small><?= $d['created_at'] ?></small></div>
            </div>
        <?php } ?>
        <?php foreach ($tugas as $k => $t) { ?>
            <div class="alert alert-primary" role="alert">
                Anda ditambahkan pada sebagai penerima tugas pada tugas "<?= $t['nama'] ?>"
                <div class="text-right"><small><?= $t['created_at'] ?></small></div>
            </div>
        <?php } ?>
        <?php foreach ($deadline as $k => $d) { ?>
            <div class="alert alert-primary" role="alert">
                Anda memiliki jadwal untuk besok pada tugas "<?= $d['tugas'] ?>"
                <div class="text-right"><small><?= $d['tanggal'] ?></small></div>
            </div>
        <?php } ?>
<!--        <ul class="nav nav-tabs">
            <li class="nav-item"><a data-toggle="tab" href="#tabDistribusi" class="nav-link active">Distribusi</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#tabDistribusi" class="nav-link">Distribusi</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#tabTugas" class="nav-link">Tugas</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#tab-dokumen" class="nav-link">Jadwal</a></li>
            <li class="nav-item"><a data-toggle="tab" href="#tab-dokumen" class="nav-link">Deadline</a></li>
        </ul>-->
        <div class="tab-content">
            <div class="tab-pane" id="tabDistribusi">

            </div>
            <div class="tab-pane" id="tabDistribusi1">
                <form method="post">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Dokumen</th>
                                <th>Waktu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php foreach ($distribution as $k => $d) { ?>
                                <tr>
                                    <td><?= $d['judul'] ?></td>
                                    <td><?= $d['created_at'] ?></td>
                                    <td class="text-center">
                                        <span class="badge badge-<?= $d['notif'] == 'UNREAD' ? 'primary' : 'secondary' ?>"><?= $d['notif'] ?></span>
                                    </td>
                                    <td>
                                        <?php if ($d['notif'] == 'UNREAD') { ?>
                                            <button class="btn btn-sm btn-outline-primary fa fa-eye" name="read_dist" value="<?= $d['id_distribution'] ?>"></button>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </form>
            </div>
            <div class="tab-pane" id="tabTugas">
                Tugas
            </div>
        </div>
    </div>
</div>
<script>
    $('table').DataTable();
</script>