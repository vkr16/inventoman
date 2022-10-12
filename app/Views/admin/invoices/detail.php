<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice [<?= $invoice['invoice_no'] ?>] - Inventory Manager</title>
    <?= $this->include('admin/components/links') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('public/assets/library/bootstrap-datepicker-1.9.0/bootstrap-datepicker.min.css') ?>">
</head>

<body>
    <div class="d-flex font-nunito-sans bg-light">
        <?= $this->include('admin/components/sidebar') ?>
        <section class="vh-100 w-100 scrollable-y" id="topbar-section" style="max-height: 100vh">
            <?= $this->include('admin/components/topbar') ?>

            <div class="mx-2 mx-lg-5 my-4 px-3 py-2">
                <h2 class="fw-semibold">Invoice Detail</h2>
                <hr class="mt-05" style="max-width: 200px;border: 2px solid; opacity: 1 ">
                <div class="d-flex mb-3 ">
                    <a class="btn btn-outline-primary rounded-0 me-3" href="<?= base_url('admin/invoices') ?>">
                        <i class="fa-solid fa-circle-chevron-left"></i>&nbsp; Back to Invoice List
                    </a>
                    <button class="btn btn-primary rounded-0" onclick="openUpdateInvoiceModal()">
                        <i class="fa-solid fa-file-invoice"></i>&nbsp; Edit Invoice
                    </button>
                </div>
                <div class="mb-4" style="max-width: 500px">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="200px">Purchase Order No.</td>
                            <td>:</td>
                            <td id="showPurchaseOrderNo"></td>
                        </tr>
                        <tr>
                            <td width="200px">Invoice No.</td>
                            <td>:</td>
                            <td id="showInvoiceNo"></td>
                        </tr>
                        <tr>
                            <td width="200px">Vendor</td>
                            <td>:</td>
                            <td id="showVendor"></td>
                        </tr>
                        <tr>
                            <td width="200px">Date</td>
                            <td>:</td>
                            <td id="showDate"></td>
                        </tr>
                    </table>
                </div>

                <button class="btn btn-primary rounded-0 mb-3" onclick="addItemModal()">
                    <i class="fa-solid fa-file-invoice"></i>&nbsp; Add Item
                </button>
                <div class="table-responsive" id="invoice_items_table_container">

                </div>
            </div>
        </section>
    </div>


    <!-- Invoice Update -->
    <div class="modal fade" id="modalUpdateInvoice" tabindex="-1" aria-labelledby="modalUpdateInvoiceLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalUpdateInvoiceLabel">
                        <i class="fa-solid fa-file-invoice"></i>&nbsp; Update Invoice
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="inputPurchaseOrderNumber">Purchase Order Number</label>
                            <input type="text" class="form-control my-2" name="inputPurchaseOrderNumber" id="inputPurchaseOrderNumber" value="<?= $invoice['purchase_no'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="inputInvoiceNumber">Invoice Number</label>
                            <input type="text" class="form-control my-2" name="inputInvoiceNumber" id="inputInvoiceNumber" value="<?= $invoice['invoice_no'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="inputVendor">Vendor</label>
                            <input type="text" class="form-control my-2" name="inputVendor" id="inputVendor" value="<?= $invoice['vendor'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="inputDate">Date</label>
                            <input type="text" class="form-control my-2" name="inputDate" id="inputDate" readonly value="<?= date('Y/m/d', $invoice['date']) ?>">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-0" onclick="updateInvoice()"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Asset Item Add -->
    <div class="modal fade" id="modalAddAssetItem" tabindex="-1" aria-labelledby="modalAddAssetItemLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddAssetItemLabel">
                        <i class="fa-solid fa-box-open"></i>&nbsp; Add Item
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="inputSerialNumber">Serial Number</label>
                            <input type="text" class="form-control my-2" name="inputSerialNumber" id="inputSerialNumber">
                        </div>
                        <div class="mb-3">
                            <label for="inputItemName">Item Name</label>
                            <input type="text" class="form-control my-2" name="inputItemName" id="inputItemName">
                        </div>
                        <div class="mb-3">
                            <label for="inputDescription">Description</label>
                            <textarea type="text" class="form-control my-2" name="inputDescription" id="inputDescription"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="inputValue">Item Value (Rp)</label>
                            <input type="number" class="form-control mt-2" name="inputValue" id="inputValue">
                            <small class="mb-2">*Dont use separator!, instead type "1000" for "1.000"</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-0" onclick="addItem()"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Asset Item Update -->
    <div class="modal fade" id="modalUpdateAssetItem" tabindex="-1" aria-labelledby="modalUpdateAssetItemLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalUpdateAssetItemLabel">
                        <i class="fa-solid fa-box-open"></i>&nbsp; Edit Item
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="updateSerialNumber">Serial Number</label>
                            <input type="text" class="form-control my-2" name="updateSerialNumber" id="updateSerialNumber">
                        </div>
                        <div class="mb-3">
                            <label for="updateItemName">Item Name</label>
                            <input type="text" class="form-control my-2" name="updateItemName" id="updateItemName">
                        </div>
                        <div class="mb-3">
                            <label for="updateDescription">Description</label>
                            <textarea type="text" class="form-control my-2" name="updateDescription" id="updateDescription"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="updateValue">Item Value (Rp)</label>
                            <input type="number" class="form-control mt-2" name="updateValue" id="updateValue">
                            <small class="mb-2">*Dont use separator!, instead type "1000" for "1.000"</small>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-0" id="updateAssetItemButton"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
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
            getInvoicesDetail(<?= $invoice['id'] ?>);
            getInvoicesItems(<?= $invoice['id'] ?>);
        })

        function updateInvoice() {
            const purchase_no = $('#inputPurchaseOrderNumber')
            const invoice_no = $('#inputInvoiceNumber')
            const vendor = $('#inputVendor')
            const date = $('#inputDate')
            const invoice_id = <?= $invoice['id'] ?>;

            purchase_no.val() == '' ? purchase_no.addClass('is-invalid') : purchase_no.removeClass('is-invalid')
            invoice_no.val() == '' ? invoice_no.addClass('is-invalid') : invoice_no.removeClass('is-invalid')
            vendor.val() == '' ? vendor.addClass('is-invalid') : vendor.removeClass('is-invalid')
            date.val() == '' ? date.addClass('is-invalid') : date.removeClass('is-invalid')

            if (purchase_no.val() == '' || invoice_no.val() == '' || vendor.val() == '' || date.val() == '') {
                Notiflix.Notify.failure("Field cannot be empty!")
            } else {
                Notiflix.Loading.pulse()
                $.post("<?= base_url('admin/invoices/update') ?>", {
                        invoice_id: invoice_id,
                        purchase_no: purchase_no.val(),
                        invoice_no: invoice_no.val(),
                        vendor: vendor.val(),
                        date: date.val(),
                    })
                    .done(function(data) {
                        Notiflix.Loading.remove(500)
                        setTimeout(() => {
                            if (data == "success") {
                                Notiflix.Notify.success("Invoice data updated successfully!")
                                getInvoicesDetail(invoice_id)
                                updateInvoiceModalReset()
                            } else if (data == "conflict") {
                                Notiflix.Notify.failure("Failed! Invoice no " + invoice_no.val() + " already exist!")
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

            function updateInvoiceModalReset() {
                $('#modalUpdateInvoice').modal('hide')
            }

        }

        function getInvoicesDetail(invoice_id) {
            $.post("<?= base_url('admin/invoices/get') ?>", {
                    invoice_id: invoice_id
                })
                .done(function(data) {
                    var invoice = JSON.parse(data)
                    $('#inputPurchaseOrderNumber').val(invoice['invoice'].purchase_no)
                    $('#inputInvoiceNumber').val(invoice['invoice'].invoice_no)
                    $('#inputVendor').val(invoice['invoice'].vendor)
                    $('#inputDate').val(invoice.invdate)

                    $('#showPurchaseOrderNo').html(invoice['invoice'].purchase_no)
                    $('#showInvoiceNo').html(invoice['invoice'].invoice_no)
                    $('#showVendor').html(invoice['invoice'].vendor)
                    $('#showDate').html(invoice.invdate)
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }

        function getInvoicesItems(invoice_id) {
            $.post("<?= base_url('admin/invoices/editableitemlist') ?>", {
                    invoice_id: invoice_id
                })
                .done(function(data) {
                    $('#invoice_items_table_container').html(data)
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }

        function openUpdateInvoiceModal() {
            $('#modalUpdateInvoice').modal('show')
            getInvoicesDetail(<?= $invoice['id'] ?>)
        }

        function addItem() {
            const invoice_id = '<?= $invoice['id'] ?>';
            var serial_number = $('#inputSerialNumber')
            var item_name = $('#inputItemName')
            var description = $('#inputDescription')
            var value = $('#inputValue')

            serial_number.val() == '' ? serial_number.addClass('is-invalid') : serial_number.removeClass('is-invalid')
            item_name.val() == '' ? item_name.addClass('is-invalid') : item_name.removeClass('is-invalid')
            description.val() == '' ? description.addClass('is-invalid') : description.removeClass('is-invalid')
            value.val() == '' ? value.addClass('is-invalid') : value.removeClass('is-invalid')

            if (serial_number.val() == '' || item_name.val() == '' || description.val() == '' || value.val() == '') {
                Notiflix.Notify.warning("Field cannot be empty!")
            } else {
                Notiflix.Loading.pulse()
                $.post("<?= base_url('admin/assets/add') ?>", {
                        invoice_id: invoice_id,
                        serial_number: serial_number.val(),
                        item_name: item_name.val(),
                        description: description.val(),
                        value: value.val()
                    })
                    .done(function(data) {
                        Notiflix.Loading.remove(500)
                        setTimeout(() => {
                            if (data == 'success') {
                                Notiflix.Notify.success("New item has been added successfully!")
                                getInvoicesItems(invoice_id)
                                serial_number.val('')
                                item_name.val('')
                                description.val('')
                                value.val('')
                                $('#modalAddAssetItem').modal('hide')
                            } else if (data == "conflict") {
                                Notiflix.Notify.failure("Failed to save, serial number already exist!")
                            } else if (data == "failed") {
                                Notiflix.Notify.failure("FAILED! INTERNAL SERVER ERROR!")
                            } else if (data == "empty") {
                                Notiflix.Notify.failure("Field cannot be empty!")
                            }
                        }, 500);
                    })
                    .fail(function() {
                        Notiflix.Report.failure('Server Error',
                            'Please check your connection and server status',
                            'Okay', )
                    })
            }

        }

        function addDuplicate(a, b, c, d) {
            $('#modalAddAssetItem').modal('show')

            var serial_number = $('#inputSerialNumber')
            var item_name = $('#inputItemName')
            var description = $('#inputDescription')
            var value = $('#inputValue')


            serial_number.val(a)
            item_name.val(b)
            value.val(c)
            description.val(d)
        }

        function addItemModal() {
            $('#modalAddAssetItem').modal('show')
            $('#inputSerialNumber').val('')
            $('#inputItemName').val('')
            $('#inputDescription').val('')
            $('#inputValue').val('')
        }

        function deleteItem(asset_id, sn) {
            Notiflix.Confirm.show(
                'Delete Item Data',
                'Are you sure want to delete item ' + sn + '?',
                'Yes',
                'No',
                () => {
                    Notiflix.Loading.pulse()
                    $.post("<?= base_url('admin/assets/delete') ?>", {
                            id: asset_id
                        })
                        .done(function(data) {
                            Notiflix.Loading.remove(500)
                            setTimeout(() => {
                                if (data == "success") {
                                    Notiflix.Notify.success("Item data has been deleted successfully!")
                                    getInvoicesItems(<?= $invoice['id'] ?>)
                                } else if (data == "notfound") {
                                    Notiflix.Notify.failure("Item data not found!")
                                    getInvoicesItems(<?= $invoice['id'] ?>)
                                } else if (data == "unreturned") {
                                    Notiflix.Report.failure(
                                        'Operation Aborted',
                                        'Cannot delete item data that has not been returned!',
                                        'Understand'
                                    );
                                } else if (data == "failed") {
                                    Notiflix.Notify.failure("FAILED! INTERNAL SERVER ERROR!")
                                }
                            }, 500);
                        })
                        .fail(function() {
                            Notiflix.Loading.remove()
                            Notiflix.Report.failure('Server Error',
                                'Please check your connection and server status',
                                'Okay', )
                        })
                },
                () => {}, {},
            );
        }

        function openUpdateItemModal(asset_id, serial_number, item_name, value, description) {
            $('#modalUpdateAssetItem').modal('show')
            $('#updateSerialNumber').val(serial_number)
            $('#updateItemName').val(item_name)
            $('#updateValue').val(value)
            $('#updateDescription').val(description)

            $('#updateAssetItemButton').attr('onclick', 'updateAssetItem(' + asset_id + ')')
        }

        function updateAssetItem(asset_id) {
            const invoice_id = <?= $invoice['id'] ?>;
            const serial_number = $('#updateSerialNumber').val()
            const item_name = $('#updateItemName').val()
            const value = $('#updateValue').val()
            const description = $('#updateDescription').val()
            Notiflix.Loading.pulse()
            $.post("<?= base_url('admin/assets/update') ?>", {
                    asset_id: asset_id,
                    serial_number: serial_number,
                    item_name: item_name,
                    value: value,
                    description: description
                })
                .done(function(data) {
                    console.log(data)
                    Notiflix.Loading.remove(500)
                    setTimeout(() => {
                        if (data == "success") {
                            Notiflix.Notify.success("Item data updated successfully!")
                            getInvoicesItems(invoice_id)
                            $('#modalUpdateAssetItem').modal('hide')
                        } else if (data == "conflict") {
                            Notiflix.Notify.failure("Failed to save, serial number already exist!")
                            getInvoicesItems(invoice_id)
                        } else if (data == "notfound") {
                            Notiflix.Notify.failure("Item data not found!")
                            getInvoicesItems(invoice_id)
                            $('#modalUpdateAssetItem').modal('hide')
                        } else if (data == "empty") {
                            Notiflix.Notify.failure("Field cannot be empty!")
                        } else if (data == "failed") {
                            Notiflix.Notify.failure("FAILED! INTERNAL SERVER ERROR!")
                        }
                    }, 500)
                })
                .fail(function() {
                    Notiflix.Loading.remove()
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }
    </script>
</body>

</html>