<table class="table table-hover mt-5" id="handover_history_table">
    <thead>
        <th>No</th>
        <th>Handover No</th>
        <th>Administrator</th>
        <th>Employee</th>
        <th>Date</th>
        <th>Category</th>
    </thead>
    <tbody id="handover_history_table_body">
        <?php
        foreach ($ho_history as $index => $ho) {
        ?>
            <tr>
                <td class="align-middle"></td>
                <td class="align-middle">
                    <?php
                    $type = $ho['category'] == "handover" ? "H" : "R";
                    ?>
                    <a href="<?= base_url('admin/handovers/detail') ?>?i=<?= $ho['id'] ?>"> <?= "HO/" . date("dm", $ho['created_at']) . '/' . date("y", $ho['created_at']) . '/' . $type . '/' . date("is", $ho['created_at']); ?></a>
                </td>

                <td class="align-middle"><?= '[' . $ho['admin_emp_number'] . '] - ' . $ho['admin'] ?></td>
                <td class="align-middle"><?= '[' . $ho['employee_number'] . '] - ' . $ho['employee'] ?></td>
                <td class="align-middle"><?= date("d M y H:i", $ho['updated_at']) ?></td>
                <td class="align-middle"><?= $ho['category'] == "handover" ? ' <i class="fa-solid fa-boxes-packing"></i>&nbsp;<i class="fa-solid fa-arrow-right-long text-danger"></i>&nbsp;<i class="fa-solid fa-user"></i>&nbsp; Handover' : ' <i class="fa-solid fa-boxes-packing"></i>&nbsp;<i class="fa-solid fa-arrow-left-long text-success"></i>&nbsp;<i class="fa-solid fa-user"></i>&nbsp; Return' ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    var t = $('#handover_history_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        ordering: false,
        sorting: false,
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