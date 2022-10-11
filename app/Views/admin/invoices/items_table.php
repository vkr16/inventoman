<table class="table table-sm table-hover mt-5" id="items_table">
    <thead>
        <th>No</th>
        <th>Serial Number</th>
        <th>Item Name</th>
        <th>Value</th>
        <th>Holder</th>
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