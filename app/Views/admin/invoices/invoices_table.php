<table class="table table-hover mt-5" id="invoices_table">
    <thead>
        <th>No</th>
        <th>Purchase Order No</th>
        <th>Invoice No</th>
        <th>Vendor</th>
        <th>Date</th>
        <th>Delete</th>
        <th>Detail</th>
    </thead>
    <tbody id="invoices_table_body">
        <?php
        foreach ($invoices as $index => $invoice) {
        ?>
            <tr>
                <td></td>
                <td><?= $invoice['purchase_no'] ?></td>
                <td><?= $invoice['invoice_no'] ?></td>
                <td><?= $invoice['vendor'] ?></td>
                <td><?= date("d M Y", $invoice['date']) ?></td>
                <td><button class="btn btn-danger btn-sm rounded-0" onclick="deleteInvoice(<?= $invoice['id'] ?>,'<?= $invoice['invoice_no'] ?>')"><i class="fa-solid fa-trash-can"></i>&nbsp; Delete</button></td>
                <td><button class="btn btn-primary btn-sm rounded-0" onclick="invoiceDetailModal(<?= $invoice['id'] ?>,'<?= $invoice['purchase_no'] ?>','<?= $invoice['invoice_no'] ?>','<?= $invoice['vendor'] ?>','<?= date('j F Y', $invoice['date']) ?>')"><i class="fa-solid fa-file-invoice"></i>&nbsp; Detail</button></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<script>
    var t = $('#invoices_table').DataTable({
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