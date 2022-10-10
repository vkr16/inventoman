<table class="table table-hover mt-5" id="employees_table">
    <thead>
        <th>No</th>
        <th>Employee Number</th>
        <th>Name</th>
        <th>Position</th>
        <th>Division</th>
    </thead>
    <tbody id="employees_table_body">
        <?php
        foreach ($employees as $index => $employee) {
        ?>
            <tr>
                <td></td>
                <td><?= $employee['employee_number'] ?></td>
                <td><?= $employee['name'] ?></td>
                <td><?= $employee['position'] ?></td>
                <td><?= $employee['division'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    var t = $('#employees_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [0, 'asc']
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