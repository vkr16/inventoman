<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Invoices - Inventory Manager</title>
    <?= $this->include('admin/components/links') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/library/bootstrap-datepicker-1.9.0/bootstrap-datepicker.min.css') ?>">
</head>

<body>
    <div class="d-flex font-nunito-sans bg-light">
        <?= $this->include('admin/components/sidebar') ?>
        <section class="vh-100 w-100 scrollable-y" id="topbar-section">
            <?= $this->include('admin/components/topbar') ?>

            <div class="mx-2 mx-lg-5 my-4 px-3 py-2">
                <h2 class="fw-semibold">List of Invoices</h2>
                <hr class="mt-05" style="max-width: 200px;border: 2px solid; opacity: 1 ">
                <div class="d-flex mb-5">
                    <button class="btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#modalAddInvoice">
                        <i class="fa-solid fa-file-invoice"></i>&nbsp; Add Invoice
                    </button>
                </div>
                <div class="table-responsive" id="invoices_table_container">

                </div>
            </div>
        </section>
    </div>

    <!-- Invoice Add -->
    <div class="modal fade" id="modalAddInvoice" tabindex="-1" aria-labelledby="modalAddInvoiceLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddInvoiceLabel">
                        <i class="fa-solid fa-file-invoice"></i>&nbsp; Add Invoice
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div>
                            <label for="inputPurchaseOrderNumber">Purchase Order Number</label>
                            <input type="text" class="form-control my-2" name="inputPurchaseOrderNumber" id="inputPurchaseOrderNumber">
                        </div>
                        <div>
                            <label for="inputInvoiceNumber">Invoice Number</label>
                            <input type="text" class="form-control my-2" name="inputInvoiceNumber" id="inputInvoiceNumber">
                        </div>
                        <div>
                            <label for="inputVendor">Vendor</label>
                            <input type="text" class="form-control my-2" name="inputVendor" id="inputVendor">
                        </div>
                        <div>
                            <label for="inputDate">Date</label>
                            <input type="text" class="form-control my-2" name="inputDate" id="inputDate" readonly>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-0" onclick="addInvoice()"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('admin/components/scripts') ?>
    <script src="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/library/bootstrap-datepicker-1.9.0/bootstrap-datepicker.min.js') ?>"></script>

    <script>
        $('#sidebar_invoices').removeClass('link-dark').addClass('active')

        $('#inputDate').datepicker({
            format: "yyyy/mm/dd",
            startView: "days",
            minViewMode: "days",
        })

        $(document).ready(function() {
            getInvoices();
        })

        function addInvoice() {
            const purchase_no = $('#inputPurchaseOrderNumber')
            const invoice_no = $('#inputInvoiceNumber')
            const vendor = $('#inputVendor')
            const date = $('#inputDate')

            purchase_no.val() == '' ? purchase_no.addClass('is-invalid') : purchase_no.removeClass('is-invalid')
            invoice_no.val() == '' ? invoice_no.addClass('is-invalid') : invoice_no.removeClass('is-invalid')
            vendor.val() == '' ? vendor.addClass('is-invalid') : vendor.removeClass('is-invalid')
            date.val() == '' ? date.addClass('is-invalid') : date.removeClass('is-invalid')

            if (purchase_no.val() == '' || invoice_no.val() == '' || vendor.val() == '' || date.val() == '') {
                Notiflix.Notify.failure("Field cannot be empty!")
            } else {
                Notiflix.Loading.pulse()
                $.post("<?= base_url('admin/invoices/add') ?>", {
                        purchase_no: purchase_no.val(),
                        invoice_no: invoice_no.val(),
                        vendor: vendor.val(),
                        date: date.val(),
                    })
                    .done(function(data) {
                        Notiflix.Loading.remove(500)
                        setTimeout(() => {
                            if (data == "success") {
                                Notiflix.Notify.success("Invoice data saved successfully!")
                                getInvoices()
                                addInvoiceModalReset()
                            } else if (data == "conflict") {
                                Notiflix.Notify.failure("Failed! Invoice " + invoice_no.val() + " already exist!")
                            } else if (data == "failed") {
                                Notiflix.Notify.failure("FAILED! INTERNAL SERVER ERROR!")
                            } else if (data == "empty") {
                                Notiflix.Notify.failure("Field cannot be empty!")
                            }
                        }, 500);
                    })
                    .fail(function() {
                        Notiflix.Loading.remove()
                        Notiflix.Report.failure('Server Error',
                            'Please check your connection and server status',
                            'Okay', )
                    })
            }

            function addInvoiceModalReset() {
                $('#inputPurchaseOrderNumber').val('')
                $('#inputInvoiceNumber').val('')
                $('#inputVendor').val('')
                $('#inputDate').val('')

                $('#modalAddInvoice').modal('hide')
            }

        }

        function getInvoices() {
            $.post("<?= base_url('admin/invoices/list') ?>", function(data) {
                    $('#invoices_table_container').html(data)
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }

        function deleteInvoice(id, invoice_no) {
            Notiflix.Report.warning(
                'Delete Invoice',
                'Be careful, deleting invoice data will also delete every assets item related to this invoice number',
                'Understand',
                () => {
                    Notiflix.Confirm.merge({
                        plainText: false
                    })
                    Notiflix.Confirm.show(
                        'Delete Invoice',
                        'Delete Invoice <strong>"' + invoice_no + '"</strong> and all of it\'s item?',
                        'Yes',
                        'No',
                        () => {
                            Notiflix.Loading.pulse()
                            $.post("<?= base_url('admin/invoices/delete') ?>", {
                                    id: id
                                })
                                .done(function(data) {
                                    console.log(data)
                                    Notiflix.Loading.remove(500)
                                    setTimeout(() => {
                                        if (data == "success") {
                                            Notiflix.Notify.success("Invoice data has been deleted successfully!")
                                            getInvoices()
                                        } else if (data == "failed-assets") {
                                            Notiflix.Report.failure(
                                                'Unknown Error',
                                                'Invoice deleted successfully but cannot delete assets related to it',
                                                'Okay',
                                            )
                                            getInvoices()
                                        } else if (data == "failed-invoice") {
                                            Notiflix.Report.failure(
                                                'Unknown Error',
                                                'Failed to delete invoice, invoice and assets remain the same',
                                                'Okay',
                                            )
                                            getInvoices()
                                        } else if (data == "unreturned") {
                                            Notiflix.Report.failure(
                                                'Operation Aborted',
                                                'Cannot delete invoice due to there are assets that haven\'t been returned',
                                                'Okay',
                                            )
                                            getInvoices()
                                        } else if (data == "notfound") {
                                            Notiflix.Notify.failure("Invoice data not found")
                                            getInvoices()
                                        }
                                    }, 500);
                                })
                                .fail(function() {
                                    Notiflix.Report.failure('Server Error',
                                        'Please check your connection and server status',
                                        'Okay', )
                                })
                        },
                        () => {}, {},
                    );
                },
            );
        }
    </script>
</body>

</html>