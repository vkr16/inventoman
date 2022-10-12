<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Assets - Inventory Manager</title>
    <?= $this->include('admin/components/links') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.css') ?>">
</head>

<body>
    <div class="d-flex font-nunito-sans bg-light">
        <?= $this->include('admin/components/sidebar') ?>
        <section class="vh-100 w-100 scrollable-y" id="topbar-section">
            <?= $this->include('admin/components/topbar') ?>

            <div class="mx-2 mx-lg-5 my-4 px-3 py-2">
                <h2 class="fw-semibold">List of Assets</h2>
                <hr class="mt-05" style="max-width: 200px;border: 2px solid; opacity: 1 ">
                <div class="d-flex mb-5">
                    <!-- <button class="btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#modalAddAsset">
                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Asset
                    </button> -->
                </div>
                <div class="table-responsive" id="assets_table_container">

                </div>
            </div>
        </section>
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

    <!-- Asset Item Detail -->
    <div class="modal fade" id="modalAssetItemDetail" tabindex="-1" aria-labelledby="modalAssetItemDetailLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAssetItemDetailLabel">
                        <i class="fa-solid fa-clipboard"></i>&nbsp; Item Detail
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-5">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td style="width: 180px" class="fw-semibold">Invoice Number</td>
                                <td>:&emsp;</td>
                                <td>INV/234/4353/DF/234/DFFGER</td>
                            </tr>
                            <tr>
                                <td style="width: 180px" class="fw-semibold">Serial Number</td>
                                <td>:&emsp;</td>
                                <td>SN98SDGFSDVB</td>
                            </tr>
                            <tr>
                                <td style="width: 180px" class="fw-semibold">Item Name</td>
                                <td>:&emsp;</td>
                                <td>Laptop Lenovo D300-ISS</td>
                            </tr>
                            <tr>
                                <td style="width: 180px" class="fw-semibold">Value</td>
                                <td>:&emsp;</td>
                                <td>Rp 23.120.000</td>
                            </tr>
                            <tr>
                                <td style="width: 180px" class="fw-semibold">Description</td>
                                <td>:&emsp;</td>
                                <td>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Fuga laudantium quis rerum esse sint nisi, voluptate even</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('admin/components/scripts') ?>
    <script src="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.js') ?>"></script>
    <script>
        $('#sidebar_assets').removeClass('link-dark').addClass('active')

        $(document).ready(function() {
            getAssets();
        });

        function getAssets() {
            $.post("<?= base_url('admin/assets/list') ?>", function(data) {
                    $('#assets_table_container').html(data)
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
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
                                    getAssets()
                                } else if (data == "notfound") {
                                    Notiflix.Notify.failure("Item data not found!")
                                    getAssets()
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

        function openUpdateItemModal(asset_id, serial_number, item_name, value, description, invoice_id) {
            $('#modalUpdateAssetItem').modal('show')
            $('#updateSerialNumber').val(serial_number)
            $('#updateItemName').val(item_name)
            $('#updateValue').val(value)
            $('#updateDescription').val(description)

            $('#updateAssetItemButton').attr('onclick', 'updateAssetItem(' + asset_id + ',' + invoice_id + ')')
        }

        function updateAssetItem(asset_id, invoice_id) {
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
                            getAssets()
                            $('#modalUpdateAssetItem').modal('hide')
                        } else if (data == "conflict") {
                            Notiflix.Notify.failure("Failed to save, serial number already exist!")
                            getAssets()
                        } else if (data == "notfound") {
                            Notiflix.Notify.failure("Item data not found!")
                            getAssets()
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

        function openItemDetailModal(asset_id) {
            $('#modalAssetItemDetail').modal('show')
        }
    </script>
</body>

</html>