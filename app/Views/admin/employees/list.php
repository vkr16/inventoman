<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Employees - Inventory Manager</title>
    <?= $this->include('admin/components/links') ?>
    <link rel="stylesheet" href="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.css') ?>">
</head>

<body>
    <div class="d-flex font-nunito-sans bg-light">
        <?= $this->include('admin/components/sidebar') ?>
        <section class="vh-100 w-100 scrollable-y" id="topbar-section">
            <?= $this->include('admin/components/topbar') ?>

            <div class="mx-2 mx-lg-5 my-4 px-3 py-2">
                <h2 class="fw-semibold">List of Employees</h2>
                <hr class="mt-05" style="max-width: 200px;border: 2px solid; opacity: 1 ">
                <div class="d-flex mb-5">
                    <button class="btn btn-primary rounded-0" data-bs-toggle="modal" data-bs-target="#modalAddEmployee">
                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Employee
                    </button>
                </div>
                <div class="table-responsive" id="employees_table_container">
                    <!-- <table class="table table-hover mt-5" id="employees_table">
                        <thead>
                            <th>Employee Number</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Division</th>
                        </thead>
                        <tbody id="employees_table_body">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table> -->
                </div>
            </div>
        </section>
    </div>

    <!-- Employee Add -->
    <div class="modal fade" id="modalAddEmployee" tabindex="-1" aria-labelledby="modalAddEmployeeLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalAddEmployeeLabel">
                        <i class="fa-solid fa-user-plus"></i>&nbsp; Add Employee
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="inputEmployeeNumber">Employee Number</label>
                            <input type="text" class="form-control my-2 updatable" name="inputEmployeeNumber" id="inputEmployeeNumber">
                        </div>
                        <div class="mb-3">
                            <label for="inputName">Name</label>
                            <input type="text" class="form-control my-2 updatable" name="inputName" id="inputName">
                        </div>
                        <div class="mb-3">
                            <label for="inputPosition">Position</label>
                            <input type="text" class="form-control my-2 updatable" name="inputPosition" id="inputPosition">
                        </div>
                        <div class="mb-3">
                            <label for="inputDivision">Division</label>
                            <input type="text" class="form-control my-2 updatable" name="inputDivision" id="inputDivision">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary rounded-0" onclick="addEmployee()"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Employee Update -->
    <div class="modal fade" id="modalUpdateEmployee" tabindex="-1" aria-labelledby="modalUpdateEmployeeLabel" aria-hidden="true" data-bs-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalUpdateEmployeeLabel">
                        <i class="fa-solid fa-user-pen"></i>&nbsp; Update Employee
                    </h1>
                    <button type="button" class="btn-close rounded-0 noglow" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalBodyUpdateEmployee">
                    <form>
                        <div class="mb-3">
                            <label for="updateEmployeeNumber">Employee Number</label>
                            <input type="text" class="form-control my-2 updatable" name="updateEmployeeNumber" id="updateEmployeeNumber">
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
                    <button type="button" class="btn btn-danger rounded-0" id="employeeDeleteButton"><i class="fa-solid fa-trash-alt"></i>&nbsp; Delete</button>

                    <span>
                        <button type="button" class="btn btn-secondary rounded-0" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary rounded-0" id="employeeUpdateButton"><i class="fa-solid fa-floppy-disk"></i>&nbsp; Save</button>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <?= $this->include('admin/components/scripts') ?>
    <script src="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.js') ?>"></script>
    <script>
        $('#sidebar_employees').removeClass('link-dark').addClass('active')

        $(document).ready(function() {
            getEmployees();
        });

        function addEmployee() {
            var employee_number = $('#inputEmployeeNumber')
            var name = $('#inputName')
            var position = $('#inputPosition')
            var division = $('#inputDivision')

            employee_number.val() == '' ? employee_number.addClass('is-invalid') : employee_number.removeClass('is-invalid');
            name.val() == '' ? name.addClass('is-invalid') : name.removeClass('is-invalid');
            position.val() == '' ? position.addClass('is-invalid') : position.removeClass('is-invalid');
            division.val() == '' ? division.addClass('is-invalid') : division.removeClass('is-invalid');

            if (employee_number.val() == '' || name.val() == '' || position.val() == '' || division.val() == '') {
                Notiflix.Notify.warning("Field cannot be empty!")
            } else {
                Notiflix.Loading.pulse()
                $.post("<?= base_url('admin/employees/add') ?>", {
                        employee_number: employee_number.val(),
                        name: name.val(),
                        position: position.val(),
                        division: division.val()
                    })
                    .done(function(data) {
                        Notiflix.Loading.remove(500)
                        setTimeout(function() {
                            if (data == "success") {
                                Notiflix.Notify.success("New employee data saved!")
                                getEmployees()
                                employee_number.val('')
                                name.val('')
                                position.val('')
                                division.val('')
                                $('#modalAddEmployee').modal('hide')
                            } else if (data == "conflict") {
                                Notiflix.Notify.failure("Failed to save, employee number already exist!")
                            } else if (data == "empty") {
                                Notiflix.Notify.failure("Field cannot be empty!")
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
            }

        }

        function getEmployees() {
            $.post("<?= base_url('admin/employees/list') ?>", function(data) {
                    $('#employees_table_container').html(data)
                })
                .fail(function() {
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }

        function employeeUpdateModal(id) {
            $('#modalUpdateEmployee').modal('show')

            Notiflix.Loading.pulse()
            $.post("<?= base_url('admin/employees/detail') ?>", {
                    id: id
                })
                .done(function(data) {
                    if (data != "notfound") {
                        Notiflix.Loading.remove(500)
                        const employee = JSON.parse(data)
                        setTimeout(function() {
                            $('#updateEmployeeNumber').val(employee.employee_number)
                            $('#updateName').val(employee.name)
                            $('#updatePosition').val(employee.position)
                            $('#updateDivision').val(employee.division)
                            $('#employeeUpdateButton').attr("onclick", "updateEmployee(" + id + ")")
                            $('#employeeDeleteButton').attr("onclick", "deleteEmployee(" + id + ",'" + employee.name + "')")
                        }, 500);
                    } else {
                        Notiflix.Loading.remove(500)
                        setTimeout(function() {
                            $('#modalUpdateEmployee').modal('hide')
                            Notiflix.Report.failure('Client Data Error',
                                'Employee not found, it might happen because the data has been deleted',
                                'Okay', () => {
                                    window.location.reload()
                                })
                        }, 500);
                    }
                })
                .fail(function() {
                    $('#modalUpdateEmployee').modal('hide')
                    Notiflix.Loading.remove()
                    Notiflix.Report.failure('Server Error',
                        'Please check your connection and server status',
                        'Okay', )
                })
        }

        function updateEmployee(id) {
            const employee_number = $('#updateEmployeeNumber').val()
            const name = $('#updateName').val()
            const position = $('#updatePosition').val()
            const division = $('#updateDivision').val()

            $('#updateEmployeeNumber').val() == '' ? $('#updateEmployeeNumber').addClass('is-invalid') : $('#updateEmployeeNumber').removeClass('is-invalid');
            $('#updateName').val() == '' ? $('#updateName').addClass('is-invalid') : $('#updateName').removeClass('is-invalid');
            $('#updatePosition').val() == '' ? $('#updatePosition').addClass('is-invalid') : $('#updatePosition').removeClass('is-invalid');
            $('#updateDivision').val() == '' ? $('#updateDivision').addClass('is-invalid') : $('#updateDivision').removeClass('is-invalid');

            if (employee_number == '' || name == '' || position == '' || division == '') {
                Notiflix.Notify.warning("Field cannot be empty!")
            } else {
                Notiflix.Loading.pulse()
                $.post("<?= base_url('admin/employees/update') ?>", {
                        id: id,
                        employee_number: employee_number,
                        name: name,
                        position: position,
                        division: division
                    })
                    .done(function(data) {
                        Notiflix.Loading.remove(500)
                        setTimeout(function() {
                            if (data == "success") {
                                Notiflix.Notify.success("Employee data saved!")
                                getEmployees()
                                $('#modalUpdateEmployee').modal('hide')
                            } else if (data == "conflict") {
                                Notiflix.Notify.failure("Failed to save, employee number already exist!")
                            } else if (data == "failed") {
                                Notiflix.Notify.failure("FAILED! INTERNAL SERVER ERROR!")
                            }
                        }, 500);
                        console.log(data)
                    })
                    .fail(function() {
                        Notiflix.Loading.remove()
                        Notiflix.Report.failure('Server Error',
                            'Please check your connection and server status',
                            'Okay', )
                    })
            }
        }

        function deleteEmployee(id, name) {
            Notiflix.Confirm.show(
                'Delete ' + name,
                'Are you sure want to delete this employee? this action cannot be undone',
                'Yes',
                'No',
                () => {
                    Notiflix.Loading.pulse()
                    $.post("<?= base_url('admin/employees/delete') ?>", {
                            id: id
                        })
                        .done(function(data) {
                            Notiflix.Loading.remove(500)
                            setTimeout(function() {
                                if (data == "admin") {
                                    Notiflix.Report.warning(
                                        'Administrator Account Detected',
                                        'This employee has an administrator access, you have to delete it\'s admin accout first before delete the employee data',
                                        'Okay',
                                    );
                                } else if (data == "success") {
                                    $('#modalUpdateEmployee').modal('hide')
                                    Notiflix.Notify.success("Employee Data Deleted!")
                                    getEmployees()
                                } else if (data == "success") {
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
    </script>
</body>

</html>