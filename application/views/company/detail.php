<?php // print_r($data)                   ?>
<div class="card">
    <div class="card-header">
        <div>
            <h3><?= $data['name'] ?></h3>
        </div>
    </div>
    <div class="card-body">
        <div class="form-group">
            <label><b>Alamat</b></label>
            <div class="bg-light box-detail p-2"><?= $data['alamat']; ?></div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label><b>Kota</b></label>
                    <div class="bg-light box-detail p-2"><?= $data['kota']; ?></div>
                </div>
                <div class="form-group">
                    <label><b>PIC</b></label>
                    <div class="bg-light box-detail p-2"><?= $pic . '/' . $data['max_pic']; ?></div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label><b>Propinsi</b></label>
                    <div class="bg-light box-detail p-2"><?= $data['province']; ?></div>
                </div>
                <div class="form-group">
                    <label><b>Ketua / Anggota</b></label>
                    <div class="bg-light box-detail p-2"><?= $akun . '/' . $data['max_akun']; ?></div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6">
                Unit Kerja
                <ol>
                    <?php foreach ($unit_kerja as $k => $v) { ?>
                        <li><b><?= $v['name'] ?></b></li>
                    <?php } ?>
                </ol>
                <br>
                Standard
                <ol>
                    <?php foreach ($standard as $k => $v) { ?>
                        <li><b><?= $v['name'] ?></b></li>
                    <?php } ?>
                </ol>
            </div>
            <div class="col-sm-6">
                Personil
                <ol>
                    <?php foreach ($personil as $k => $v) { ?>
                        <li><b><?= $v['fullname'] ?></b></li>
                    <?php } ?>
                </ol>
            </div>
            <div class="col-sm-6"></div>
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