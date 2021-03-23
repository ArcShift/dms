<div class="card">
    <form method="post">
        <div class="card-header">
            <button class="btn btn-outline-primary" name="read_all" value="ok">Tandai semua telah dibaca</button>
        </div>
        <div class="card-body">
            <?php foreach ($notif3 as $k => $n) { ?>
                <div class="alert alert-<?= $n['status'] == 'UNREAD' ? 'info' : 'secondary' ?>">
                    <?= $n['pesan'] ?>
                    <div class="row">
                        <div class="col-sm-6">
                            <button style="border: none; background: none; padding-left: 0" name="switch" value="<?= $n['id'] ?>">
                                <small><?= $n['status'] == 'READ' ? 'Sudah dibaca' : 'Belum dibaca' ?></small>
                            </button>
                        </div>
                        <div class="col-sm-6 text-right">
                            <small class="text-right"><?= $n['ago'] ?></small>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </form>
</div>