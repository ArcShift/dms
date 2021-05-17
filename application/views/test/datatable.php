<?php
$this->db->select('j.*, t.nama AS tugas, d.judul AS dokumen');
$this->db->join('tugas t', 't.id = j.id_tugas');
$this->db->join('document d', 'd.id = t.id_document');
$data = $this->db->get('jadwal j')->result_array();
?>
<table>
    <thead>
        <tr>
            <th>Unit Kerja</th>
            <th>Judul Dokumen</th>
            <th>Tugas</th>
            <th>Judul Dokumen</th>
            <th>Tugas</th>
            <th>Form Terkait</th>
            <th>Periode</th>
            <th class="col-tgl">Jadwal</th>
            <th>PIC Pelaksana</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $k => $d) { ?>
        <tr>
            <td>-</td>
            <td><?= $d['dokumen'] ?></td>
            <td><?= $d['tugas'] ?></td>
            <td></td>
            <td></td>
            <td>-</td>
            <td><?= $d['periode'] ?></td>
            <td><?= $d['tanggal'] ?></td>
            <td>-</td>
            <td>-</td>
        </tr>
        <?php } ?>
    </tbody>
</table>