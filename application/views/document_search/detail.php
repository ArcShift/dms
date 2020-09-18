<?php ?>
<div class="main-card card">
    <div class="card-header">
        <?= $data['judul'] ?>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Nomor</label>
                    <span class="form-control"><?= $data['nomor'] ?></span>
                </div>
                <div class="form-group">
                    <label>Jenis</label>
                    <span class="form-control">LEVEL <?= $data['jenis'] ?></span>
                </div>
                <div class="form-group">
                    <label>Deskripsi</label>
                    <textarea class="form-control"><?= $data['deskripsi'] ?></textarea>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label>Pembuat</label>
                    <span class="form-control"><?= $data['pembuat'] ?></span>
                </div>
                <div class="form-group">
                    <label>Klasifikasi</label>
                    <span class="form-control"><?= $data['klasifikasi'] ?></span>
                </div>
                <div class="form-group">
                    <label>Versi</label>
                    <span class="form-control"><?= $data['versi'] ?></span>
                </div>
                <div class="form-group">
                    <label>Dokumen Terkait</label>
                    <span class="form-control">
                        <?php if (!empty($data['contoh'])) { ?>
                            <a class="btn btn-primary fa fa-eye" href="<?= site_url('document_search/detail/' . $data['contoh']) ?>"></a>
                            <?= $data['dokumen_terkait'] ?> 
                        <?php }else{ ?>
                            Tidak Ada
                        <?php } ?>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer pull-right">
        <button class="btn btn-primary mr-3 fa" onclick="window.history.back()">Kembali</button>
        <a class="btn btn-primary fa fa-download" href=""> Download</a>
    </div>
</div>