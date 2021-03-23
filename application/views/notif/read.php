<div class="card">
    <div class="card-header">
        <form method="post">
            <button class="btn btn-outline-primary" name="read_all" value="ok">Tandai semua telah dibaca</button>
        </form>
    </div>
    <div class="card-body">
        <?php foreach ($notif3 as $k => $n) { ?>
            <div class="alert alert-<?= $n['status'] == 'UNREAD' ? 'info' : 'primary' ?>">
                <?= $n['pesan'] ?>
                <div class="row">
                    <div class="col-sm-6">
                        <small><?= $n['status'] ?></small>
                        <!--<button class="btn btn-sm btn-outline-primary">Tandai sudah dibaca</button>-->
                    </div>
                    <div class="col-sm-6 text-right">
                        <small class="text-right"><?= $n['ago'] ?></small>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>