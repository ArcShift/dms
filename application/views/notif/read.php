<div class="card">
    <div class="card-body">
        <?php foreach ($notif2 as $k => $n) { ?>
            <div class="alert alert-primary" role="alert">
                <?= $n['message'] ?>
                <div class="text-right"><small><?= $n['ago'] ?></small></div>
            </div>
        <?php } ?>
    </div>
</div>