<table class="table table-hover mt-5" id="handovers_table">
    <thead>
        <th>No</th>
        <th>Handover No</th>
        <th>Administrator</th>
        <th>Employee</th>
        <th>Category</th>
        <th>Status</th>
        <th>Action</th>
    </thead>
    <tbody id="handovers_table_body">
        <?php
        foreach ($handovers as $index => $handover) {
        ?>
            <tr>
                <td class="align-middle"></td>
                <td class="align-middle">HO/<?= date("Y", $handover['created_at']) . '/' . date("m", $handover['created_at']) . '/' . date("d", $handover['created_at']) ?>/<?= $handover['category'] == "handover" ? "H" : "R" ?>/<?= $handover['id'] ?></td>
                <td class="align-middle"><?= $handover['admin'] ?></td>
                <td class="align-middle"><?= $handover['employee'] ?></td>
                <td class="align-middle"><?= $handover['category'] ?></td>
                <td class="align-middle"><?= $handover['status'] == 'pending' ? '<i class="fa-regular fa-clock text-danger"></i>&nbsp; Pending' : '<i class="fa-solid fa-circle-check text-primary"></i>&nbsp; Issued' ?> </td>
                <td class="align-middle"><a href="<?= base_url('admin/handovers/detail') ?>?i=<?= $handover['id'] ?>" class="btn btn-primary rounded-0 btn-sm"><i class="fa-solid fa-up-right-from-square"></i>&nbsp; Detail</a></td>
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