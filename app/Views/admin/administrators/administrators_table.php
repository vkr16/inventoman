<table class="table table-hover mt-5" id="administrators_table">
    <thead>
        <th>No</th>
        <th>Name</th>
        <th>Administrator Username</th>
        <th>Employee Number</th>
        <th>Position</th>
        <th>Division</th>
        <th>Delete</th>
        <th>Reset Password</th>
    </thead>
    <tbody id="administrators_table_body">
        <?php
        foreach ($administrators as $index => $administrator) {
        ?>
            <tr>
                <td class="align-middle"></td>
                <td class="align-middle"><?= $administrator['name'] ?></td>
                <td class="align-middle"><?= $administrator['username'] ?></td>
                <td class="align-middle"><?= $administrator['employee_number'] ?></td>
                <td class="align-middle"><?= $administrator['position'] ?></td>
                <td class="align-middle"><?= $administrator['division'] ?></td>
                <td class="align-middle">
                    <button class="btn btn-danger btn-sm rounded-0" onclick="deleteAdministrator(<?= $administrator['id'] ?>,'<?= $administrator['name'] ?>')" <?= $administrator['id'] == $_SESSION['inventoman_user_session'] ? 'disabled' : '' ?>><i class="fa-solid fa-trash-alt"></i>&nbsp; Delete</button>
                </td>
                <td>
                    <button class="btn btn-primary btn-sm rounded-0" onclick="resetPasswordModal(<?= $administrator['id'] ?>,'<?= $administrator['name'] ?>','<?= $administrator['employee_number'] ?>')"><i class="fa-solid fa-unlock-keyhole"></i>&nbsp; Reset Password</button>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    var t = $('#administrators_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        order: [
            [1, 'asc']
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