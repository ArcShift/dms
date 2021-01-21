<?php
$company = $this->db->get('company')->result_array();
?>
<div class="main-card mb-3 card">   
    <div class="card-body">
        <div class="row">
            <div class="col-sm-6"></div>
            <div class="col-sm-3">
                <select class="form-control" id="selectCompany">
                    <option>~ Pilih Perusahaan ~</option>
                    <?php foreach ($company as $k => $c) { ?>
                        <option value="<?= $c['id'] ?>"><?= $c['name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm-3">
                <select class="form-control" id="selectStandar">
                    <option>~ Pilih Standar ~</option>
                </select>
            </div>
        </div>
        <table class="table">
            <tr>
                <th>Pasal Induk</th>
                <th>Harapan</th>
                <th>Aksi</th>
            </tr>
        </table>
    </div>
</div>
<script>
    
</script>