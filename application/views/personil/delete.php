<?php
//print_r($data);
?>
<div class="main-card mb-3 card">
    <form method="post">
        <div class="card-header">
            <h3>Hapus data ini?</h3>
        </div>
        <div class="card-body">
            <input class="form-control" name="id" readonly="" hidden="" value="<?php echo $data['id'] ?>">
            <div class="form-group">
                <label>Nama</label>
                <input class="form-control" readonly="" value="<?php echo $data['fullname'] ?>">
            </div>
            <span class="badge badge-secondary">Pembuat Dokumen: <?= count($data['creator']) ?></span>
            <span class="badge badge-secondary">Distribusi Dokumen: <?= count($data['dist']) ?></span>
            <span class="badge badge-secondary">Pembuat Tugas: <?= count($data['task_creator']) ?></span>
            <span class="badge badge-secondary">Penerima Tugas: <?= count($data['task']) ?></span>
            <br>
            <br>
            <?php if (!empty($data['dist'])|!empty($data['creator'])|!empty($data['task'])){  ?>
            <div class="alert alert-danger" role="alert">
                Personil ini terkait dengan data dokumen. Anda yakin ingin menghapusnya?
            </div>
            <?php } ?>
        </div>
        <div class="d-block text-right card-footer">
            <a class="mr-2 btn btn-outline-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-outline-danger" name="hapus" value="ok">Hapus</button>
        </div>
    </form>
</div>