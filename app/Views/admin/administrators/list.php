<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Administrators - Inventory Manager</title>
    <?= $this->include('admin/components/links') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.css') ?>">
</head>

<body>
    <div class="d-flex font-nunito-sans bg-light">
        <?= $this->include('admin/components/sidebar') ?>
        <section class="vh-100 w-100 scrollable-y" id="topbar-section">
            <?= $this->include('admin/components/topbar') ?>

            <div class="mx-2 mx-lg-5 my-4 px-3 py-2">
                <h2 class="fw-semibold">List of Administrators</h2>
                <hr class="mt-05" style="max-width: 200px;border: 2px solid; opacity: 1 ">
                <div class="d-flex mb-5">
                    <button class="btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#modalAddAdministrator">
                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Administrator
                    </button>
                </div>
                <div class="table-responsive" id="administrators_table_container">

                </div>
            </div>
        </section>
    </div>

    <!-- Administrator Add -->
    <div class="modal fade" id="modalAddAdministrator" tabindex="-1" aria-labelledby="modalAddAdministratorLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddAdministratorLabel">
                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Administrator
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
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
                            <label for="inputUsername">Username</label>
                            <input type="text" autocomplete="username" class="form-control mt-2" name="inputUsername" id="inputUsername" onchange="usernameValidation($(this).val())" onkeyup="usernameValidation($(this).val())">
                            <small class="mb-2">The username is permanent and cannot be changed once it's created</small>
                            <div class="username-validation-feedback">
                                <small class="text-success" style="display: none" id="username-valid">Username available</small>
                                <small class="text-danger" style="display: none" id="username-invalid">Username already taken</small>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="inputPassword">Password</label>
                            <input type="password" autocomplete="new-password" class="form-control my-2" name="inputPassword" id="inputPassword">
                        </div>
                        <div class="mb-3 d-flex align-items-center me-auto">
                            <input type="checkbox" class="form-check-input rounded-0 mt-0" id="checkShowPassword" onchange="inputPasswordVisible()">
                            <label for="checkShowPassword" class="form-label mb-0 ms-2">Show password</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-0" onclick="addAdministrator()"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Administrator Update -->
    <!-- <div class="modal fade" id="modalUpdateAdministrator" tabindex="-1" aria-labelledby="modalUpdateAdministratorLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalUpdateAdministratorLabel">
                        <i class="fa-solid fa-user-pen"></i>&nbsp; Update Administrator
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyUpdateAdministrator">
                    <form>
                        <div class="mb-3">
                            <label for="updateAdministratorNumber">Administrator Number</label>
                            <input type="text" class="form-control my-2 updatable" name="updateAdministratorNumber" id="updateAdministratorNumber">
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
                    <button type="button" class="btn btn-danger rounded-0" id="administratorDeleteButton"><i class="fa-solid fa-trash-alt"></i>&nbsp; Delete</button>

                    <span>
                        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary rounded-0" id="administratorUpdateButton"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                    </span>
                </div>
            </div>
        </div>
    </div> -->

    <?= $this->include('admin/components/scripts') ?>
    <script src="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.js') ?>"></script>
    <script>
        $('#sidebar_administrators').removeClass('link-dark').addClass('active')

        $(document).ready(function() {
            getAdministrators();
        });

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

        function usernameValidation(username) {
            $.post("<?= base_url('admin/administrators/validation/username') ?>", {
                    username: username
                })
                .done(function(data) {
                    if (data == "conflict") {
                        $('#inputUsername').addClass('is-invalid').removeClass('is-valid')
                        $('#username-valid').hide()
                        $('#username-invalid').show()
                    } else if (data == "empty") {
                        $('#inputUsername').removeClass('is-valid is-invalid')
                        $('#username-valid').hide()
                        $('#username-invalid').hide()
                    } else {
                        $('#inputUsername').removeClass('is-invalid').addClass('is-valid')
                        $('#username-valid').show()
                        $('#username-invalid').hide()
                    }
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }

        function inputPasswordVisible() {
            if ($('#inputPassword').attr('type') == 'password') {
                $('#inputPassword').attr('type', 'text')
            } else {
                $('#inputPassword').attr('type', 'password')
            }
        }

        function addAdministrator() {
            const employee_number = $('#inputEmployeeNumber')
            const username = $('#inputUsername')
            const password = $('#inputPassword')

            $.post("<?= base_url('admin/administrators/add') ?>", {
                    employee_number: employee_number.val(),
                    username: username.val(),
                    password: password.val(),
                })
                .done(function(data) {
                    console.log(data)
                })
        }

        function getAdministrators() {
            $.post("<?= base_url('admin/administrators/list') ?>", function(data) {
                    $('#administrators_table_container').html(data)
                    // console.log(data)
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }

        function deleteAdministrator(id, name) {
            Notiflix.Confirm.show(
                'Delete Administrator Access',
                'Are you sure want to delete ' + name + '\'s administrator access?',
                'Yes',
                'No',
                () => {
                    $.post("<?= base_url('admin/administrators/delete') ?>", {
                            id: id
                        })
                        .done(function(data) {
                            alert("Data Loaded: " + data);
                        });
                },
                () => {}, {},
            );
        }
    </script>
</body>

</html>