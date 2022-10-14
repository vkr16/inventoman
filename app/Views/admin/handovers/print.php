<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Serah Terima - Inventory Manager | Daytech Tetra Sindo</title>
    <?= $this->include('admin/components/links') ?>
</head>

<body onmouseover="closeme()">
    <?php
    $type = $handover[0]['category'] == "handover" ? "H" : "R";
    ?>
    <div class="px-5 mx-auto font-nunito-sans">
        <p class="h3 text-center mt-3 fw-semibold">BERITA ACARA SERAH TERIMA BARANG</p>
        <p class="h6 text-center fw-semibold">No : <?= "HO/" . date("dm", $handover[0]['created_at'])  . '/' . date("y", $handover[0]['created_at']) . '/' . $type . '/' . date("is", $handover[0]['created_at'])  ?></p>

        <p class="lh-sm">Kami yang bertanda tangan dibawah ini. Pada hari ini <?= $hari ?> Tanggal <?= date("d", $handover[0]['updated_at']) ?> Bulan <?= $bulan ?> Tahun <?= date("Y", $handover[0]['updated_at']) ?></p>

        <table>
            <tr>
                <td>Nomor Pegawai</td>
                <td>&emsp;:&emsp;</td>
                <td><?= $firstparty['employee_number'] ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>&emsp;:&emsp;</td>
                <td><?= $firstparty['name'] ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>&emsp;:&emsp;</td>
                <td><?= $firstparty['position'] ?></td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td>&emsp;:&emsp;</td>
                <td><?= $firstparty['division'] ?></td>
            </tr>
        </table>
        <p class="mt-1">Selanjutnya disebut <span class="fw-semibold">PIHAK PERTAMA</span></p>

        <table>
            <tr>
                <td>Nomor Pegawai</td>
                <td>&emsp;:&emsp;</td>
                <td><?= $secondparty['employee_number'] ?></td>
            </tr>
            <tr>
                <td>Nama</td>
                <td>&emsp;:&emsp;</td>
                <td><?= $secondparty['name'] ?></td>
            </tr>
            <tr>
                <td>Jabatan</td>
                <td>&emsp;:&emsp;</td>
                <td><?= $secondparty['position'] ?></td>
            </tr>
            <tr>
                <td>Divisi</td>
                <td>&emsp;:&emsp;</td>
                <td><?= $secondparty['division'] ?></td>
            </tr>
        </table>
        <p class="mt-1">Selanjutnya disebut <span class="fw-semibold">PIHAK KEDUA</span></p>
        <p style="text-align: justify" class="lh-sm">PIHAK PERTAMA menyerahkan barang kepada PIHAK KEDUA, dan PIHAK KEDUA menyatakan telah menerima barang dari PIHAK PERTAMA sesuai daftar berikut.</p>

        <table class="table table-sm table-bordered">
            <tr>
                <td class="align-middle text-center fw-semibold">No</td>
                <td class="align-middle text-center fw-semibold">Nama Barang</td>
                <td class="align-middle text-center fw-semibold">Nomor Seri (SN)</td>
                <td class="align-middle text-center fw-semibold">Jumlah</td>
            </tr>
            <?php
            foreach ($items as $key => $item) {
            ?>
                <tr>
                    <td class="align-middle text-center"><?= $key + 1 ?></td>
                    <td class="align-middle text-center"><?= $item['item_name'] ?></td>
                    <td class="align-middle text-center"><?= $item['serial_number'] ?></td>
                    <td class="align-middle text-center">1 Unit</td>
                </tr>
            <?php
            }
            ?>
        </table>

        <p style="text-align: justify" class="lh-sm">Demikianlah berita acara serah terima barang ini dibuat oleh kedua belah pihak, adapun keadaan barang-barang tersebut dalam keadaan baik. Sejak penandatanganan berita acara ini maka barang tersebut menjadi tanggung jawab PIHAK KEDUA.</p>

        <div class="w-full d-flex align-items-start row col-12 mx-0" style=" height: 180px;page-break-inside: avoid;">
            <div class="col-6 d-flex align-items-center flex-column" style=" height: 180px;">
                <p class=" text-center mb-auto">PIHAK PERTAMA</p>
                <p class="text-center">
                    <?= $firstparty['name'] ?><br>(<?= $firstparty['employee_number'] ?>)
                </p>
            </div>
            <div class="col-6 d-flex align-items-center flex-column" style=" height: 180px;">
                <p class="text-center mb-auto">PIHAK KEDUA</p>
                <p class="text-center">
                    <?= $secondparty['name'] ?><br>(<?= $secondparty['employee_number'] ?>)
                </p>
            </div>
        </div>

    </div>


    <?= $this->include('admin/components/scripts') ?>

    <script>
        window.print()
        window.onfocus = function() {
            setTimeout(window.close, 0)
        }

        function closeme() {
            window.close, 0
        }
    </script>

</body>

</html>