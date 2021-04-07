<?php // print_r($data)      ?>
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
        <!--        <div class="row">
                    <div class="col-sm-6">
                        <div class="card widget-content bg-midnight-bloom">
                            <div class="widget-content-wrapper text-white">
                                <div class="widget-content-left">
                                    <div class="widget-heading">Dokumen</div>
                                    <div class="widget-subheading">Pembuatan dokumen</div>
                                </div>
                                <div class="widget-content-right">
                                    <div class="widget-numbers text-white"><span id="averageDoc"></span>%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        
                    </div>
                </div>-->
        <div>
            <span class="badge badge-secondary">Unit Kerja: <?= $data['unit_kerja'] ?></span>
            <span class="badge badge-secondary">Personil: <?= $data['personil'] ?></span>
            <span class="badge badge-secondary">Standard digunakan: <?= $data['standard'] ?></span>
            <span class="badge badge-secondary">Dokumen:  <?= $data['document'] ?></span>
        </div>
    </div>
    <div class="card-footer d-block">
        <a class="btn btn-outline-primary pull-right m-1" href="<?= site_url($module . '\edit') ?>">Edit</a>
        <?php if ($role == 'admin') { ?>
            <a class="btn btn-outline-primary pull-right m-1" href="<?= site_url($module) ?>">Kembali</a>
            <!--<a class="btn btn-outline-danger pull-right m-1">Hapus</a>-->
        <?php } ?>
    </div>
</div>