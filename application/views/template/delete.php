<div class="main-card mb-3 card">
    <form method="post">
        <div class="card-header">
            <h3>Hapus data ini?</h3>
        </div>
        <div class="card-body">
            <input class="form-control" name="id" readonly="" hidden="" value="<?php echo $this->session->userdata('delete')['id'] ?>">
            <div class="form-group">
                <label>Nama</label>
                <input class="form-control" readonly="" value="<?php echo $this->session->userdata('delete')['name']?>">
            </div>
        </div>
        <div class="d-block text-right card-footer">
            <a class="mr-2 btn btn-outline-primary" href="<?php echo site_url($module) ?>">Kembali</a>
            <button class="btn btn-outline-danger" name="hapus" value="ok">Hapus</button>
        </div>
    </form>
</div>