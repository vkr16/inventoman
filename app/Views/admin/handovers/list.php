<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Handovers - Inventory Manager</title>
    <?= $this->include('admin/components/links') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.css') ?>">
</head>

<body>
    <div class="d-flex font-nunito-sans bg-light">
        <?= $this->include('admin/components/sidebar') ?>
        <section class="vh-100 w-100 scrollable-y" id="topbar-section">
            <?= $this->include('admin/components/topbar') ?>

            <div class="mx-2 mx-lg-5 my-4 px-3 py-2">
                <h2 class="fw-semibold">List of Handovers</h2>
                <hr class="mt-05" style="max-width: 200px;border: 2px solid; opacity: 1 ">
                <div class="d-flex mb-5">
                    <button class="btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#modalAddHandover">
                        <i class="fa-solid fa-file-contract"></i>&nbsp; Add Handover Note
                    </button>
                </div>
                <div class="table-responsive" id="handovers_table_container">

                </div>
            </div>
        </section>
    </div>

    <!-- Handover Add -->
    <div class="modal fade" id="modalAddHandover" tabindex="-1" aria-labelledby="modalAddHandoverLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddHandoverLabel">
                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Handover
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <label for="inputEmployeeNumber">Employee Number</label>
                        <input type="text" class="form-control my-2" name="inputEmployeeNumber" id="inputEmployeeNumber" onchange="employeeValidation($(this).val())" onkeyup="employeeValidation($(this).val())">
                    </div>
                    <div class="mb-3" id="employee-validation-feedback">
                        <table class="small table-sm table table-borderless text-success" id="employee-valid" style="display: none">
                            <tr>
                                <td>Name</td>
                                <td>: &emsp; <span id="valid-name"></span></td>
                            </tr>
                            <tr>
                                <td>Position</td>
                                <td>: &emsp; <span id="valid-position"></span></td>
                            </tr>
                            <tr>
                                <td>Division</td>
                                <td>: &emsp; <span id="valid-division"></span></td>
                            </tr>
                        </table>
                        <small class="text-danger" style="display: none" id="employee-invalid">Employee number invalid</small>
                    </div>
                    <div class="mb-3">
                        <label>Category</label>
                        <div class="row mt-2">
                            <div class="w-auto">
                                <input class="form-check-input rounded-0" type="radio" value="handover" name="inputHandoverCategory" id="inputHandoverCategory1" checked>
                                <label class="form-check-label" for="inputHandoverCategory1">
                                    Hand over
                                </label>
                            </div>
                            <div class="w-auto">
                                <input class="form-check-input rounded-0" type="radio" value="return" name="inputHandoverCategory" id="inputHandoverCategory2">
                                <label class="form-check-label" for="inputHandoverCategory2">
                                    Return
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-0" onclick="addHandover()"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Handover Update -->
    <div class="modal fade" id="modalUpdateHandover" tabindex="-1" aria-labelledby="modalUpdateHandoverLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalUpdateHandoverLabel">
                        <i class="fa-solid fa-user-pen"></i>&nbsp; Update Handover
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyUpdateHandover">
                    <form>
                        <div class="mb-3">
                            <label for="updateHandoverNumber">Handover Number</label>
                            <input type="text" class="form-control my-2 updatable" name="updateHandoverNumber" id="updateHandoverNumber">
                        </div>
                        <div class="mb-3">
                            <label for="updateName">Name</label>
                            <input type="text" class="form-control my-2 updatable" name="updateName" id="updateName">
                        </div>
                        <div class="mb-3">
                            <label for="updatePosition">Position</label>
                            <input type="text" class="form-control my-2 updatable" name="updatePosition" id="updatePosition">
                        </div>
                        <div class="mb-3">
                            <label for="updateDivision">Division</label>
                            <input type="text" class="form-control my-2 updatable" name="updateDivision" id="updateDivision">
                        </div>
                    </form>
                </div>
                <div class="modal-footer d-flex justify-content-between">
                    <button type="button" class="btn btn-danger rounded-0" id="handoverDeleteButton"><i class="fa-solid fa-trash-alt"></i>&nbsp; Delete</button>

                    <span>
                        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary rounded-0" id="handoverUpdateButton"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('admin/components/scripts') ?>
    <script src="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.js') ?>"></script>
    <script>
        $('#sidebar_handovers').removeClass('link-dark').addClass('active')

        $(document).ready(function() {
            getHandovers();
        })

        function getHandovers() {
            $.post("<?= base_url('admin/handovers/list') ?>", function(data) {
                    $('#handovers_table_container').html(data)
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay')
                })
        }

        function employeeValidation(employee_number) {
            $.post("<?= base_url('admin/administrators/validation/employee') ?>", {
                    employee_number: employee_number
                })
                .done(function(data) {
                    if (data == "notfound") {
                        $('#inputEmployeeNumber').addClass('is-invalid').removeClass('is-valid')
                        $('#employee-valid').hide()
                        $('#employee-invalid').show()
                    } else {
                        $('#inputEmployeeNumber').removeClass('is-invalid').addClass('is-valid')
                        $('#employee-valid').show()
                        $('#employee-invalid').hide()

                        var employee = JSON.parse(data)
                        $('#valid-name').html(employee[0].name)
                        $('#valid-position').html(employee[0].position)
                        $('#valid-division').html(employee[0].division)
                    }
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }

        function addHandover() {
            const employee_number = $('#inputEmployeeNumber')
            const category = $('input[name="inputHandoverCategory"]:checked').val()

            if (employee_number.val() == '') {
                employee_number.addClass('is-invalid')
                Notiflix.Notify.warning("Field cannot be empty!")
            } else {
                Notiflix.Loading.pulse()
                employee_number.removeClass('is-invalid')
            }


            $.post("<?= base_url('admin/handovers/add') ?>", {
                    employee_number: employee_number.val(),
                    category: category
                })
                .done(function(data) {
                    Notiflix.Loading.remove(500)
                    console.log(data)
                    setTimeout(() => {
                        if (data == "success") {
                            Notiflix.Notify.success("Handover note has been saved successfully!")
                            $('#inputEmployeeNumber').val('').removeClass('is-valid is-invalid')
                            $('#employee-valid').hide
                            $('#employee-invalid').hide
                            getHandovers()
                            $('#modalAddHandover').modal('hide')
                        } else if (data == "conflict") {
                            Notiflix.Notify.failure("Unable to add handover note, there is another pending note!")
                            getHandovers()
                        } else if (data == "notfound") {
                            Notiflix.Notify.failure("Employee not found!")
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

        }
    </script>
</body>

</html>