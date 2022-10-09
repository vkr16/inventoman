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
                <div class="table-responsive">
                    <table class="table table-hover mt-5" id="employees_table">
                        <thead>
                            <th>No</th>
                            <th>Employee Number</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Division</th>
                        </thead>
                        <tbody>
                            <tr role="button">
                                <td>1</td>
                                <td>264895001</td>
                                <td>Fikri Miftah Akmaludin</td>
                                <td>Head of IT Division</td>
                                <td>IT</td>
                            </tr>
                        </tbody>
                    </table>
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
            $('#employees_table').DataTable();
        });

        function addEmployee() {
            const employee_number = $('#inputEmployeeNumber')
            const name = $('#inputName')
            const position = $('#inputPosition')
            const division = $('#inputDivision')

            employee_number.val() == '' ? employee_number.addClass('is-invalid') : employee_number.removeClass('is-invalid');
            name.val() == '' ? name.addClass('is-invalid') : name.removeClass('is-invalid');
            position.val() == '' ? position.addClass('is-invalid') : position.removeClass('is-invalid');
            division.val() == '' ? division.addClass('is-invalid') : division.removeClass('is-invalid');

            if (employee_number.val() == '' || name.val() == '' || position.val() == '' || division.val() == '') {
                Notiflix.Notify.warning("Field cannot be empty!")
            } else {
                $.post("<?= base_url('admin/employees/add') ?>", {
                        employee_number: employee_number.val(),
                        name: name.val(),
                        position: position.val(),
                        division: division.val()
                    })
                    .done(function(data) {
                        alert("Data Loaded: " + data);
                    });
            }

        }
    </script>
</body>

</html>