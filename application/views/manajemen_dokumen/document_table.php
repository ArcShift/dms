<?php
$this->db->select('d.*');
$this->db->join('pasal p', 'p.id = d.id_pasal');
$this->db->join('document_pasal dp', 'p.id = d.id_pasal');
$this->db->where('p.id_standard = ' . $this->session->userdata('md_standard'));
$result = $this->db->get('document d')->result_array();
foreach ($result as $k => $r) {
    $this->db->where('id_document', $id);
//    $result = $this->db->get('document_pasal')->result_array();
    foreach ($r as $k2 => $r2) {
        
    }
    $result[$k]['pasal_fullname']= '---';
}
//function getPasal($id) {
//    $this->db->where('id_document', $id);
//    $result = $this->db->get('document_pasal')->result_array();
//    $txt='';
//    foreach ($result as $k => $r) {
//    }
//    return $txt; 
//}
?>
<div class="row">
    <div class="col-sm-2">
    </div>
    <div class="col-sm-2">
    </div>
    <div class="col-sm-2">
    </div>
    <div class="col-sm-2">
        <input class="form-control" placeholder="Nomor">
    </div>
    <div class="col-sm-2">
        <input class="form-control" placeholder="Judul">
    </div>
    <div class="col-sm-1">
        <button class="form-control btn btn-outline-primary btn-sm fa fa-search" title="Cari"></button>
    </div>
</div>
<br>
<table class="table table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Pasal</th>
            <th>Versi</th>
            <th class="text-center">Level</th>
            <th>Klasifikasi</th>
            <th class="col-aksi">Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($result as $k=>$r) { ?>
            <tr>
                <td><?= $r['nomor'] ?></td>
                <td><?= $r['judul'] ?></td>
                <td><?= $r['pasal_fullname'] ?></td>
                <td><?= $r['versi'] ?></td>
                <td class="text-center"><?= empty($r['jenis']) ? '-' : 'Level ' . $r['jenis'] ?></td>
                <td><?= $r['klasifikasi'] ?></td>
                <td>
                    <span class="text-primary fa fa-info-circle" onclick="detailDocument(<?= $k ?>)" title="Detail"></span>
                    <span class="text-primary fa fa-edit" onclick="editDokumen(<?= $k ?>)"></span>
                    <span class="text-danger fa fa-trash" onclick="initHapusDokumen(<?= $k ?>)"></span>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
