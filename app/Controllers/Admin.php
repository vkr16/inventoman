<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{

    protected $employeeModel;
    protected $adminModel;
    protected $invoiceModel;
    protected $assetModel;

    function __construct()
    {
        $this->employeeModel = model('EmployeeModel', true, $db);
        $this->adminModel = model('AdminModel', true, $db);
        $this->invoiceModel = model('InvoiceModel', true, $db);
        $this->assetModel = model('AssetModel', true, $db);
    }

    public function index()
    {
        return view('admin/dashboard');
    }


    /**
     * Employee Management
     */
    public function employees()
    {
        return view('admin/employees/list');
    }

    public function employeesAdd()
    {
        $employee_number    = trim($_POST['employee_number']);
        $name               = trim($_POST['name']);
        $position           = trim($_POST['position']);
        $division           = trim($_POST['division']);

        $employeeData = [
            "employee_number" => $employee_number,
            "name" => $name,
            "position" => $position,
            "division" => $division
        ];


        if ($employee_number == '' || $name == '' || $position == '' || $division == '') {
            return "empty";
        } else {
            if (!$this->employeeModel->where('employee_number', $employee_number)->find()) {
                if ($this->employeeModel->insert($employeeData)) {
                    return "success";
                } else {
                    return "failed";
                }
            } else {
                return "conflict";
            }
        }
    }

    public function employeesList()
    {
        $data['employees'] = $this->employeeModel->findAll();

        return view('admin/employees/employees_table', $data);
    }

    public function employeesDetail()
    {
        $employee_id = $_POST['id'];
        if ($employee = $this->employeeModel->find($employee_id)) {
            return json_encode($employee);
        } else {
            return "notfound";
        }
    }

    public function employeesUpdate()
    {
        $employee_id = $_POST['id'];
        $employee_number = trim($_POST['employee_number']);
        $name = trim($_POST['name']);
        $position = trim($_POST['position']);
        $division = trim($_POST['division']);

        $updatedData = [
            "employee_number" => $employee_number,
            "name" => $name,
            "position" => $position,
            "division" => $division,
        ];

        if ($employee_id == '' || $employee_number == '' || $name == '' || $position == '' || $division == '') {
            return "empty";
        } else {
            $db = \Config\Database::connect();
            $builder = $db->table('employees');

            $duplication = $builder->select('*')->where('id <>', $employee_id)->where('employee_number =', $employee_number)->countAllResults();

            if ($duplication > 0) {
                return "conflict";
            } else {
                if ($this->employeeModel->where('id', $employee_id)->set($updatedData)->update()) {
                    return "success";
                } else {
                    return "failed";
                }
            }
        }
    }

    public function employeesDelete()
    {
        $employee_id = $_POST['id'];

        if ($this->adminModel->where('employee_id', $employee_id)->find()) {
            return "admin";
        } else {
            if ($this->employeeModel->delete($employee_id)) {
                return "success";
            } else {
                return "failed";
            }
        }
    }


    /**
     * Administrator Management
     */
    public function administrators()
    {
        return view('admin/administrators/list');
    }

    public function administratorsEmployeeValidation()
    {
        $employee_number = $_POST['employee_number'];


        if ($employee = $this->employeeModel->where('employee_number', $employee_number)->find()) {
            return json_encode($employee);
        } else {
            return "notfound";
        }
    }

    public function administratorsUsernameValidation()
    {
        $username = $_POST['username'];

        if ($username != '') {
            if ($this->adminModel->where('username', $username)->find()) {
                return "conflict";
            } else {
                return "available";
            }
        } else {
            return "empty";
        }
    }

    public function administratorsAdd()
    {
        $employee_number = $_POST['employee_number'];
        $username = trim($_POST['username']);
        $password = $_POST['password'];

        if ($employee = $this->employeeModel->where('employee_number', $employee_number)->find()) {
            if ($this->adminModel->where('employee_id', $employee[0]['id'])->find()) {
                return "admin";
            } else {
                if ($this->adminModel->where('username', $username)->find()) {
                    return "conflict";
                } else {
                    $newAdminData = [
                        "username" => $username,
                        "password" => password_hash($password, PASSWORD_DEFAULT),
                        "employee_id" => $employee[0]['id'],
                    ];
                    if ($this->adminModel->insert($newAdminData)) {
                        return "success";
                    } else {
                        return "failed";
                    }
                }
            }
        } else {
            return "notfound";
        }
    }

    public function administratorsList()
    {
        $session = $_SESSION['inventoman_user_session'];
        $db = \Config\Database::connect();
        $query = $db->query("SELECT admins.id AS id, admins.username, employees.employee_number, employees.name, employees.position, employees.division FROM admins LEFT JOIN employees ON admins.employee_id = employees.id WHERE admins.deleted_at IS NULL");

        $data['administrators'] = $query->getResult('array');
        return view('admin/administrators/administrators_table', $data);
    }

    public function administratorsDelete()
    {
        $admin_id = $_POST['id'];

        if ($this->adminModel->find($admin_id)) {
            if ($this->adminModel->delete($admin_id)) {
                return "success";
            } else {
                return "failed";
            }
        } else {
            return "notfound";
        }
    }

    public function administratorsReset()
    {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $id = $_POST['id'];

        if ($this->adminModel->find($id)) {
            if ($this->adminModel->where('id', $id)->set('password', $password)->update()) {
                return "success";
            } else {
                return "failed";
            }
        } else {
            return "notfound";
        }
    }


    /**
     * Invoice Management
     */
    public function invoices()
    {
        return view('admin/invoices/list');
    }

    public function invoicesAdd()
    {
        $purchase_no = trim($_POST['purchase_no']);
        $invoice_no = trim($_POST['invoice_no']);
        $vendor = trim($_POST['vendor']);
        $date = date_format(date_create($_POST['date']), "U");

        $newInvoice = [
            "purchase_no" => $purchase_no,
            "invoice_no" => $invoice_no,
            "vendor" => $vendor,
            "date" => $date,
        ];

        if ($purchase_no == '' || $invoice_no == '' || $vendor == '' || $date == '') {
            return "empty";
        } else {
            if (!$this->invoiceModel->where('invoice_no', $invoice_no)->find()) {
                if ($this->invoiceModel->insert($newInvoice)) {
                    return "success";
                } else {
                    return "failed";
                }
            } else {
                return "conflict";
            }
        }
    }

    public function invoicesList()
    {
        $data['invoices'] = $this->invoiceModel->findAll();

        return view('admin/invoices/invoices_table', $data);
    }

    public function invoicesDelete()
    {
        $invoice_id = $_POST['id'];

        if ($this->invoiceModel->find($invoice_id)) {
            if ($this->assetModel->where("invoice_id = $invoice_id AND current_holder IS NOT NULL")->find()) {
                return "unreturned";
            } else {
                if ($this->invoiceModel->delete($invoice_id)) {
                    if ($this->assetModel->where('invoice_id', $invoice_id)->delete()) {
                        return "success";
                    } else {
                        return "failed-assets";
                    }
                } else {
                    return "failed-invoice";
                }
            }
        } else {
            return "notfound";
        }
    }
}
