<div class="card">
    <div class="card-header">
        <div class="col-sm-10">
            Pasal <?= $pasal['fullname'] ?>
        </div>
        <div class="col-sm-2">
            <a class="pull-right btn btn-sm btn-outline-primary" href="<?= site_url($module) ?>">Kembali</a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Judul</label>
                    <br>
                    <b><?= $pasal['sort_desc'] ?></b>
                </div>
            </div>
                <div class="col-sm-6">
                <div class="form-group">
                    <label>Pasal induk</label>
                    <br>
                    <b>
                        <?php if (empty($pasal['parent'])) { ?>
                            ---
                        <?php } else { ?>
                            <a ><?= $pasal['parent_fullname'] ?></a>
                        <?php } ?>
                    </b>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea class="form-control" rows="3" readonly=""><?= $pasal['long_desc'] ?></textarea>
        </div>
        <div class="form-group">
            <label>Penjelasan</label>
            <textarea class="form-control" rows="3" readonly=""><?= $pasal['penjelasan'] ?></textarea>
        </div>
        <div class="form-group">
            <label>Bukti Pasal</label>
            <textarea class="form-control" rows="3" readonly=""><?= $pasal['bukti'] ?></textarea>
        </div>
    </div>
</div>