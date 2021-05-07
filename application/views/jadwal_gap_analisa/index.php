<div class="card">
    <div class="card-body">
        <a class="btn btn-outline-primary float-right" href="<?= site_url($module . '/create') ?>">Tambah</a>
    </div>
    <div class="card-body">
        <form method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>Judul</th>
                        <th>Ruang Lingkup</th>
                        <th>Pelaksana</th>
                        <th>Tim Pelaksana</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $k => $v) { ?>
                        <tr>
                            <td><?= $v['judul'] ?></td>
                            <td><?= $v['ruang_lingkup'] ?></td>
                            <td><?= $v['pelaksana'] ?></td>
                            <td>
                                <?php foreach ($v['tim_pelaksana'] as $k2 => $v2) { ?>
                                    <div>- <?= $v2['fullname'] ?></div>
                                <?php } ?>
                            </td>
                            <td><?= $v['tanggal'] ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-primary fa fa-search" onclick="detail(<?= $v['id'] ?>)"></button>
                                <button class="btn btn-sm btn-outline-primary fa fa-edit" name="initEdit" value="<?= $v['id'] ?>"></button>
                                <?php if (empty($v['pertanyaan']) & empty($v['pl'])) { ?>
                                    <button class="btn btn-sm btn-outline-danger fa fa-trash" name="delete" value="<?= $v['id'] ?>"></button>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </form>
    </div>
</div>
<script>
    function () {

    }
</script>