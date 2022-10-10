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

    <?= $this->include('admin/components/scripts') ?>
    <script src="<?= base_url('public/assets/library/datatables-1.12.1/datatables.min.js') ?>"></script>
    <script>
        $('#sidebar_dashboard').removeClass('active').addClass('link-dark')
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
                    });
                Notiflix.Loading.remove(10000)
                setTimeout(function() {
                    Notiflix.Notify.failure("It is longer than usual, please check your connection and server status")
                    setTimeout(function() {
                        window.location.reload()
                    }, 3000);
                }, 10000);
            }

        }

        function getEmployees() {
            $.post("<?= base_url('admin/employees/list') ?>", function(data) {
                $('#employees_table_container').html(data)
            });
        }
    </script>
</body>

</html>