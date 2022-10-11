<table class="table table-hover mt-5" id="items_table">
    <thead>
        <th>No</th>
        <th>Serial Number</th>
        <th>Item Name</th>
        <th>Value</th>
        <th>Holder</th>
        <th>Delete</th>
        <th>Edit</th>
        <th>Duplicate</th>
    </thead>
    <tbody id="items_table_body">
        <?php
        foreach ($items as $index => $item) {
        ?>
            <tr>
                <td class="align-middle"></td>
                <td class="align-middle"><?= $item['serial_number'] ?></td>
                <td class="align-middle"><?= $item['item_name'] ?></td>
                <td class="align-middle">Rp <?= number_format($item['value'], 0, ',', '.') ?></td>
                <td class="align-middle"><?= $item['holder'] ?></td>
                <td class="align-middle"><button class="btn btn-danger btn-sm rounded-0"><i class="fa-solid fa-trash-can"></i>&nbsp; Delete</button></td>
                <td class="align-middle"><button class="btn btn-primary btn-sm rounded-0"><i class="fa-solid fa-trash-can"></i>&nbsp; Edit</button></td>
                <td class="align-middle"><button class="btn btn-dark btn-sm rounded-0" onclick="addDuplicate('<?= $item['serial_number'] ?>','<?= $item['item_name'] ?>','<?= $item['value'] ?>','<?= $item['description'] ?>')"><i class="fa-solid fa-clone"></i>&nbsp; Duplicate</button></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    var t = $('#items_table').DataTable({
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