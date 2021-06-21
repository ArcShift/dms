<div class="card">
    <div class="card-header">
        Membuat Aplikasi Marketing
        &nbsp;
        <sup class="text-primary fa fa-info-circle" title="aplikasi yang dapat membantu marketing dalam melakukan"></sup>
    </div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-sm-2"></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2"></div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm">
                    <option value="">~ Status ~</option>
                    <option value="">Selesai</option>
                    <option value="">Menunggu</option>
                    <option value="">Terlambat</option>
                </select>
            </div>
            <div class="col-sm-2">
                <select class="form-control form-control-sm">
                    <option value="">~ Periode ~</option>
                    <option value="">Hari Ini</option>
                    <option value="">Minggu Ini</option>
                    <option value="">Bulan Ini</option>
                </select>
            </div>
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tugas</th>
                    <th>Pelaksana</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Membuat Database</td>
                    <td>
                        <img src="<?= base_url('assets/images/default_user.jpg') ?>" width="30" title="Toimul Setyo Andri - IT">
                        <img src="<?= base_url('assets/images/default_user.jpg') ?>" width="30" title="Toimul Setyo Andri - IT">
                        <img src="<?= base_url('assets/images/default_user.jpg') ?>" width="30" title="Toimul Setyo Andri - IT">
                    </td>
                    <td>2021-11-02</td>
                    <td>
                        <span class="badge badge-success">selesai</span>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Membuat Aplikasi Marketing</td>
                    <td>
                        <img src="<?= base_url('assets/images/default_user.jpg') ?>" width="30" title="Toimul Setyo Andri - IT">
                        <img src="<?= base_url('assets/images/default_user.jpg') ?>" width="30" title="Toimul Setyo Andri - IT">
                        <img src="<?= base_url('assets/images/default_user.jpg') ?>" width="30" title="Toimul Setyo Andri - IT">
                    </td>
                    <td>2021-11-02</td>
                    <td>
                        <span class="badge badge-success">selesai</span>
                    </td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<script>
    $('table').DataTable();
</script>