<?php
$data = [
    'perusahaan' => [
        'detail' => 'Menampilkan detail data perusahaan dan jumlah data terkait pada perusahaan anda. untuk mengubah data perusahaan. klik tombol edit',
        'edit' => 'Mengubah data perusahaan',
    ],
    'unit kerja' => [
        'list' => 'Menampilkan data unit kerja pada perusahaan anda. Untuk membuat unit kerja baru klik tombol tambah. Untuk mengubah data klik tombol edit. untuk menghapus data, pastikan unit kerja sudah tidak terkait dengan personil manapun',
        'tambah' => 'Menambahkan data unit kerja',
        'edit' => 'Pada tabel tugas unit anda dapat menambahkan keterangan tugas pada unit kerja tersebut',
    ],
    'personil' => [
        'list' => 'Menampilkan data personil pada perusahaan anda',
        'tambah' => 'Tiap personil dapat memiliki lebih dari 1 unit kerja. Jika personil belum memiliki unit kerja maka tidak akan muncul pada menu dokumen dan impplementasi',
        'edit' => 'Pada tabel unit kerja, anda dapat menambahkan / menghapus unit kerja yg terkait dengan personil tersebut',
    ],
    'akun' => [
        'list' => 'Menampilkan data akun pada perusahaan anda. akun digunakan agar personil dapat login ke aplikasi',
        'tambah' => 'Username pada setiap akun harus berbeda',
    ],
    'deskripsi pasal' => [],
    'pemahaman pasal' => [],
    'bukti pasal' => [],
    'pemberlakuan pasal' => [
        '' => 'Untuk mengaktifkan / menonaktifkan pasal yang digunakan, anda dapat mengaturnya di menu ini',
    ],
    'harapan manajemen' => [
        '' => 'Untuk mengatur batas minimal yang diharapkan pada grafik pemenuhan & implementasi',
    ],
    'Dokumen' => [],
    'Implementasi' => [],
    'Pencarian dokumen' => [],
    'Pemenuhan' => [
        ''=> 'menampilkan statistik dokumen & implementasi yang telah diupload',
    ],
    'Gap Analisa' => [],
    'Aktifitas Pengguna' => [
        '' => 'Menampilkan riwayat aktifitas anda',
    ],
    'Akun' => [
        '' => 'Pengaturan Akun Anda',
    ],
    'Notifikasi Email' => [
        '' => 'Untuk mengatur apakah notifikasi dari aplikasi akan dikirim ke email atau tidak',
    ],
];
?>
<div class="card">
    <div class="card-body">
        <?php foreach ($data as $k => $v) { ?>
            <div class="m-b-5">
                <h5 class="text-primary"><?= ucwords($k) ?></h5>
                <?php foreach ($v as $k2 => $v2) { ?>
                    <h6><?= ucwords($k2) ?></h6>
                    <p><?= $v2 ?></p>
                <?php } ?>
                <hr>
            </div>
        <?php } ?>
    </div>
</div>