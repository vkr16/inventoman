<table class="table table-hover mt-5" id="assets_table">
    <thead>
        <th>No</th>
        <th>Invoice Number</th>
        <th>Serial Number</th>
        <th>Item Name</th>
        <th>Value</th>
        <th>Holder</th>
        <th>Delete</th>
        <th>Edit</th>
        <th>Detail</th>
    </thead>
    <tbody id="assets_table_body">
        <?php
        foreach ($assets as $index => $asset) {
        ?>
            <tr>
                <td class="align-middle"></td>

                <td class="align-middle"><a href="<?= base_url('admin/invoices/detail') ?>?i=<?= $asset['invoice_id'] ?>"><?= $asset['invoice_no'] ?></a></td>

                <td class="align-middle"><?= $asset['serial_number'] ?></td>

                <td class="align-middle"><?= $asset['item_name'] ?></td>

                <td class="align-middle">Rp <?= number_format($asset['value'], 0, ',', '.') ?></td>

                <td class="align-middle"><?= $asset['holder'] == NULL ? '<span style="color:#b3b3b3"><i class="fa-solid fa-boxes-packing"></i>&nbsp; Inventory</span>' : $asset['holder'] ?></td>

                <td class="align-middle"><button class="btn btn-danger btn-sm rounded-0" onclick="deleteItem(<?= $asset['id'] ?>,'<?= $asset['serial_number'] ?>')"><i class="fa-solid fa-trash-can"></i>&nbsp; Delete</button></td>

                <td class="align-middle"><button class="btn btn-primary btn-sm rounded-0" onclick="openUpdateItemModal(<?= $asset['id'] ?>,'<?= $asset['serial_number'] ?>','<?= $asset['item_name'] ?>','<?= $asset['value'] ?>','<?= $asset['description'] ?>',<?= $asset['invoice_id'] ?>)"><i class="fa-regular fa-pen-to-square"></i>&nbsp; Edit</button></td>

                <td class="align-middle"><button class="btn btn-success btn-sm rounded-0" onclick="openItemDetailModal(<?= $asset['id'] ?>)"><i class="fa-solid fa-clipboard"></i>&nbsp; Detail</button></td>

            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    var t = $('#assets_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [2, 'asc']
        ]
    });

    t.on('order.dt search.dt', function() {
        let i = 1;
        t.cells(null, 0, {
            search: 'applied',
            order: 'applied'
        }).every(function(cell) {
            this.data(i++);
        });
    }).draw();
</script>