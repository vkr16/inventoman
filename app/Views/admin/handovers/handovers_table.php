<table class="table table-hover mt-5" id="handovers_table">
    <thead>
        <th>No</th>
        <th>Administrator</th>
        <th>Employee</th>
        <th>Category</th>
        <th>Status</th>
    </thead>
    <tbody id="handovers_table_body">
        <?php
        foreach ($handovers as $index => $handover) {
        ?>
            <tr>
                <td></td>
                <td><?= $handover['admin'] ?></td>
                <td><?= $handover['employee'] ?></td>
                <td><?= $handover['category'] ?></td>
                <td><?= $handover['status'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    var t = $('#handovers_table').DataTable({
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