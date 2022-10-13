<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Handover Note HO/<?= date("Y", $handover[0]['created_at']) . '/' . date("m", $handover[0]['created_at']) . '/' . date("d", $handover[0]['created_at']) ?>/<?= $handover[0]['category'] == "handover" ? "H" : "R" ?>/<?= $handover[0]['id'] ?> - Inventory Manager</title>
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
                <h2 class="fw-semibold">Handover Detail</h2>
                <hr class="mt-05" style="max-width: 200px;border: 2px solid; opacity: 1 ">
                <div class="d-flex mb-3 ">
                    <a class="btn btn-outline-primary rounded-0 me-3" href="<?= base_url('admin/handovers') ?>">
                        <i class="fa-solid fa-circle-chevron-left"></i>&nbsp; Back to Handover List
                    </a>
                    <span id="spanDeleteHandoverButton">

                    </span>

                    <span id="spanValidateHandoverButton">

                    </span>

                    <span id="spanPrintHandoverButton">

                    </span>

                </div>
                <div class="mb-4" style="max-width: 500px">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td width="200px">Handover No.</td>
                            <td>:</td>
                            <td id="showHandoverNo"></td>
                        </tr>
                        <tr>
                            <td width="200px">Employee</td>
                            <td>:</td>
                            <td id="showEmployee"></td>
                        </tr>
                        <tr>
                            <td width="200px">Category</td>
                            <td>:</td>
                            <td id="showCategory"></td>
                        </tr>
                        <tr>
                            <td width="200px">Status</td>
                            <td>:</td>
                            <td id="showStatus"></td>
                        </tr>

                    </table>
                </div>

                <span id="spanAddItemButton">

                </span>
                <div class="table-responsive" id="handover_items_table_container">

                </div>
            </div>
        </section>
    </div>

    <?= $this->include('admin/components/scripts') ?>
    <script src="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.js') ?>"></script>
    <script src="<?= base_url('public/assets/library/bootstrap-datepicker-1.9.0/bootstrap-datepicker.min.js') ?>"></script>

    <script>
        $('#sidebar_handovers').removeClass('link-dark').addClass('active')

        $('#inputDate').datepicker({
            format: "yyyy/mm/dd",
            startView: "days",
            minViewMode: "days",
        })

        $(document).ready(function() {
            getHandoverDetail()
        })

        function getHandoverDetail() {
            const handover_id = '<?= $handover[0]['id'] ?>'
            $.post("<?= base_url('admin/handovers/get') ?>", {
                    handover_id: handover_id
                })
                .done(function(data) {
                    const handover = JSON.parse(data)
                    $('#showHandoverNo').html(handover.handover_no)
                    $('#showEmployee').html(handover.handover[0]['employee'])
                    $('#showCategory').html(handover.handover[0]['category'] == "handover" ? "Handover" : "Return")
                    $('#showStatus').html(handover.handover[0]['status'] == 'pending' ? '<i class="fa-regular fa-clock text-danger"></i>&nbsp; Pending' : '<i class="fa-solid fa-circle-check text-primary"></i>&nbsp; Issued')

                    if (handover.handover[0]['status'] == 'pending') {
                        $('#spanDeleteHandoverButton').html('<button class="btn btn-danger rounded-0 me-3" onclick="deleteHandover(' + handover_id + ')"> <i class="fa-solid fa-trash-can"></i>&nbsp; Delete </button>')
                        $('#spanValidateHandoverButton').html('<button class="btn btn-primary rounded-0 me-3" onclick="validateHandover(' + handover_id + ')"> <i class="fa-solid fa-signature"></i>&nbsp; Validate </button>')
                        $('#spanPrintHandoverButton').html('')
                        $('#spanAddItemButton').html('<button class="btn btn-primary rounded-0 mb-3" onclick="addItemModal()"> <i class="fa-regular fa-square-plus"></i>&nbsp; Add Item </button>')
                    } else {
                        $('#spanDeleteHandoverButton').html('')
                        $('#spanValidateHandoverButton').html('')
                        $('#spanPrintHandoverButton').html('<button class="btn btn-primary rounded-0"> <i class="fa-solid fa-print"></i>&nbsp; Print </button>')
                        $('#spanAddItemButton').html('')
                    }
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }

        function validateHandover(handover_id) {
            Notiflix.Report.info(
                'Handover Note Validation',
                'After being validated this note will not be able to be changed and deleted again',
                'Okay',
                () => {
                    Notiflix.Confirm.show(
                        'Handover Note Validation',
                        'Validate this handover note?',
                        'Yes',
                        'No',
                        () => {
                            Notiflix.Loading.pulse()
                            $.post("<?= base_url('admin/handovers/validate') ?>", {
                                    handover_id: handover_id
                                })
                                .done(function(data) {
                                    Notiflix.Loading.remove(500)
                                    setTimeout(() => {
                                        if (data == "success") {
                                            Notiflix.Notify.success("Handover note has been validated successfully!")
                                            getHandoverDetail()
                                        } else if (data == "notfound") {
                                            Notiflix.Loading.pulse()
                                            Notiflix.Notify.failure("Data not found! Client out of sync!")
                                            setTimeout(() => {
                                                window.location.replace('<?= base_url('admin/handovers') ?>')
                                            }, 1000);
                                        } else if (data == "failed") {
                                            Notiflix.Notify.failure("FAILED! INTERNAL SERVER ERROR!")
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

        function deleteHandover(handover_id) {
            Notiflix.Confirm.show(
                'Delete Confirmation',
                'Delete this handover note?',
                'Yes',
                'No',
                () => {
                    Notiflix.Loading.pulse()
                    $.post("<?= base_url('admin/handovers/delete') ?>", {
                            handover_id: handover_id
                        })
                        .done(function(data) {
                            Notiflix.Loading.remove(500)
                            setTimeout(() => {
                                if (data == "success") {
                                    Notiflix.Notify.success("Handover note has been validated successfully!")
                                    getHandoverDetail()
                                } else if (data == "failed") {
                                    Notiflix.Notify.failure("FAILED! INTERNAL SERVER ERROR!")
                                } else if (data == "notfound") {
                                    Notiflix.Loading.pulse()
                                    Notiflix.Notify.failure("Data not found! Client out of sync!")
                                    setTimeout(() => {
                                        window.location.replace('<?= base_url('admin/handovers') ?>')
                                    }, 1000);
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
        }
    </script>
</body>

</html>