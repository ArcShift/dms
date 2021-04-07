<?php // print_r($data)             ?>
<div class="card">
    <div class="card-header">
        <div>
            <h3><?= $data['name'] ?></h3>
        </div>
    </div>
    <div class="card-body">
        <label>Alamat</label><br>
        <label><b><?= $data['alamat']; ?></b></label>
        <div class="row">
            <div class="col-sm-6">
                <label>Kota</label><br>
                <label><b><?= $data['kota']; ?></b></label>
            </div>
            <div class="col-sm-6">
                <label>Propinsi</label><br>
                <label><b><?= $data['province']; ?></b></label>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-4">
                Unit Kerja
                <ol>
                    <?php foreach ($unit_kerja as $k => $v) { ?>
                        <li><b><?= $v['name'] ?></b></li>
                    <?php } ?>
                </ol>
            </div>
            <div class="col-sm-4">
                Personil
                <ol>
                    <?php foreach ($personil as $k => $v) { ?>
                        <li><b><?= $v['fullname'] ?></b></li>
                    <?php } ?>
                </ol>
            </div>
            <div class="col-sm-4">
                Standard
                <ol>
                    <?php foreach ($standard as $k => $v) { ?>
                        <li><b><?= $v['name'] ?></b></li>
                    <?php } ?>
                </ol>
            </div>
        </div>
        <span class="badge badge-primary" data-toggle="tab" href="#tabUnitKerja">Unit Kerja: <?= $data['unit_kerja'] ?></span>
        <span class="badge badge-primary" data-toggle="tab" href="#tabPersonil">Personil: <?= $data['personil'] ?></span>
        <span class="badge badge-primary" data-toggle="tab" href="#tabStandard">Standard digunakan: <?= $data['standard'] ?></span>
        <span class="badge badge-primary">Dokumen:  <?= $data['document'] ?></span>
    </div>
    <div class="card-footer d-block">
        <a class="btn btn-outline-primary pull-right m-1" href="<?= site_url($module . '\edit') ?>">Edit</a>
        <?php if ($role == 'admin') { ?>
            <a class="btn btn-outline-primary pull-right m-1" href="<?= site_url($module) ?>">Kembali</a>
            <!--<a class="btn btn-outline-danger pull-right m-1">Hapus</a>-->
        <?php } ?>
    </div>
</div>