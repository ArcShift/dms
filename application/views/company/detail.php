<?php print_r($data) ?>
<div class="card">
    <div class="card-body">
        <div>
            <a class="btn btn-outline-primary pull-right" href="<?= site_url($module) ?>">Kembali</a>
            <h3><?= $data['name'] ?></h3>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <label>Kota</label>
                <label><b>Kota</b></label>
            </div>
            <div class="col-sm-6"></div>
        </div>
        <div>
            <span class="badge badge-secondary">Unit Kerja: n</span>
            <span class="badge badge-secondary">Personil: n</span>
            <span class="badge badge-secondary">Standard digunakan: n</span>
            <span class="badge badge-secondary">Unit Kerja: n</span>
            <span class="badge badge-secondary">Dokumen: n</span>
        </div>
    </div>
</div>