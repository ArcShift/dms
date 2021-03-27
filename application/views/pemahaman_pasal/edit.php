<div class="card">
    <form method="post">
        <div class="card-header">
            <div class="col-sm-10">
                <?= $pasal['fullname'] ?>
            </div>
            <div class="col-sm-2">
            </div>
        </div>
        <div class="card-body">
            <div class="form-group">
                <label>Judul</label>
                <input class="form-control" value="<?= $pasal['sort_desc'] ?>" disabled="">
            </div>
            <div class="form-group">
                <label>Deskipsi</label>
                <textarea rows="3" class="form-control" name="desc"><?= $pasal['long_desc'] ?></textarea>
            </div>
            <div class="form-group">
                <label>Penjelasan</label>
                <textarea rows="3" class="form-control" name="penjelasan"><?= $pasal['penjelasan'] ?></textarea>
            </div>
            <div class="form-group">
                <label>Bukti</label>
                <textarea rows="3" class="form-control" name="bukti"><?= $pasal['bukti'] ?></textarea>
            </div>
        </div>
        <div class="d-block card-footer text-right">
            <button class="btn btn-outline-secondary" onclick="history.back()">Kembali</button>  
            <button class="btn btn-outline-primary" name="edit" value="ok">Simpan</button>
        </div>
    </form>
</div>