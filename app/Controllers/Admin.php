<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{

    protected $employeeModel;
    protected $adminModel;
    protected $invoiceModel;
    protected $assetModel;
    protected $handoverModel;

    function __construct()
    {
        $this->employeeModel = model('EmployeeModel', true, $db);
        $this->adminModel = model('AdminModel', true, $db);
        $this->invoiceModel = model('InvoiceModel', true, $db);
        $this->assetModel = model('AssetModel', true, $db);
        $this->handoverModel = model('HandoverModel', true, $db);
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

    public function invoicesItemList()
    {

        $invoice_id = $_POST['invoice_id'];

        $db = \Config\Database::connect();
        $query = $db->query("SELECT assets.id,assets.serial_number,assets.item_name,assets.description,assets.value,employees.name as holder  FROM assets JOIN employees ON assets.current_holder=employees.id  WHERE assets.deleted_at IS NULL AND assets.invoice_id=$invoice_id UNION ALL  SELECT assets.id,assets.serial_number,assets.item_name,assets.description,assets.value, assets.current_holder FROM assets WHERE assets.current_holder IS NULL AND assets.deleted_at IS NULL AND assets.invoice_id=$invoice_id");

        $data['items'] = $query->getResult('array');

        return view('admin/invoices/items_table', $data);
    }

    public function invoicesEditableItemList()
    {

        $invoice_id = $_POST['invoice_id'];

        $db = \Config\Database::connect();
        $query = $db->query("SELECT assets.id,assets.serial_number,assets.item_name,assets.description,assets.value,employees.name as holder  FROM assets JOIN employees ON assets.current_holder=employees.id  WHERE assets.deleted_at IS NULL AND assets.invoice_id=$invoice_id UNION ALL  SELECT assets.id,assets.serial_number,assets.item_name,assets.description,assets.value, assets.current_holder FROM assets WHERE assets.current_holder IS NULL AND assets.deleted_at IS NULL AND assets.invoice_id=$invoice_id");

        $data['items'] = $query->getResult('array');

        return view('admin/invoices/editable_items_table', $data);
    }

    public function invoicesDetail()
    {
        $invoice_id = $_GET['i'];

        $data['invoice'] = $this->invoiceModel->find($invoice_id);

        return view('admin/invoices/detail', $data);
    }

    public function invoicesGet()
    {
        $invoice_id = $_POST['invoice_id'];

        $data['invoice'] = $this->invoiceModel->find($invoice_id);
        $data['invdate'] = date('Y/m/d', $data['invoice']['date']);
        return json_encode($data);
    }

    public function invoicesUpdate()
    {
        $invoice_id = $_POST['invoice_id'];
        $purchase_no = trim($_POST['purchase_no']);
        $invoice_no = trim($_POST['invoice_no']);
        $vendor = trim($_POST['vendor']);
        $date = date_format(date_create($_POST['date']), "U");

        $newInvoiceData = [
            "purchase_no" => $purchase_no,
            "invoice_no" => $invoice_no,
            "vendor" => $vendor,
            "date" => $date,
        ];

        if ($purchase_no == '' || $invoice_no == '' || $vendor == '' || $date == '') {
            return "empty";
        } else {
            $db = \Config\Database::connect();
            $builder = $db->table('invoices');

            $duplication = $builder->select('*')->where('id <>', $invoice_id)->where('invoice_no =', $invoice_no)->countAllResults();

            if ($duplication > 0) {
                return "conflict";
            } else {
                if ($this->invoiceModel->where('id', $invoice_id)->set($newInvoiceData)->update()) {
                    return "success";
                } else {
                    return "failed";
                }
            }
        }
    }



    /**
     * Asset Management
     */
    public function assetsAdd()
    {
        $invoice_id = trim($_POST['invoice_id']);
        $serial_number = trim($_POST['serial_number']);
        $item_name = trim($_POST['item_name']);
        $description = trim($_POST['description']);
        $value = trim($_POST['value']);

        $newAssetData = [
            "invoice_id" => $invoice_id,
            "serial_number" => $serial_number,
            "item_name" => $item_name,
            "description" => $description,
            "value" => $value
        ];

        if ($invoice_id == '' || $serial_number == '' || $item_name == '' || $description == '' || $value == '') {
            return "empty";
        } else {
            if ($this->assetModel->where('serial_number', $serial_number)->find()) {
                return "conflict";
            } else {
                if ($this->assetModel->insert($newAssetData)) {
                    return "success";
                } else {
                    return "failed";
                }
            }
        }
    }

    public function assetsDelete()
    {
        $assets_id = $_POST['id'];

        if ($item = $this->assetModel->find($assets_id)) {
            if ($item['current_holder'] == NULL) {
                if ($this->assetModel->delete($assets_id)) {
                    return "success";
                } else {
                    return "failed";
                }
            } else {
                return "unreturned";
            }
        } else {
            return "notfound";
        }
    }

    public function assetsUpdate()
    {
        $assets_id = trim($_POST['asset_id']);
        $serial_number = trim($_POST['serial_number']);
        $item_name = trim($_POST['item_name']);
        $value = trim($_POST['value']);
        $description = trim($_POST['description']);

        $updatedAssetData = [
            "serial_number" => $serial_number,
            "item_name" => $item_name,
            "description" => $description,
            "value" => $value
        ];
        if ($serial_number == '' || $item_name == '' || $description == '' || $value == '') {
            return "empty";
        } else {
            if ($this->assetModel->find($assets_id)) {
                $db = \Config\Database::connect();
                $builder = $db->table('assets');

                $duplication = $builder->select('*')->where('id <>', $assets_id)->where('serial_number =', $serial_number)->where('deleted_at =', NULL)->countAllResults();

                if ($duplication > 0) {
                    return "conflict";
                } else {
                    if ($this->assetModel->where('id', $assets_id)->set($updatedAssetData)->update()) {
                        return "success";
                    } else {
                        return "failed";
                    }
                }
            } else {
                return "notfound";
            }
        }
    }

    public function assets()
    {
        return view('admin/assets/list');
    }

    public function assetsList()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT assets.id,assets.serial_number,assets.item_name,assets.description,assets.value ,invoices.id as invoice_id,invoices.invoice_no, employees.id as holder_id,employees.name as holder FROM assets JOIN employees ON assets.current_holder=employees.id JOIN invoices ON assets.invoice_id=invoices.id WHERE assets.deleted_at IS NULL UNION SELECT assets.id,assets.serial_number,assets.item_name,assets.description,assets.value ,invoices.id as invoice_id,invoices.invoice_no,current_holder,current_holder FROM assets JOIN employees ON assets.current_holder IS NULL JOIN invoices ON assets.invoice_id=invoices.id WHERE assets.deleted_at IS NULL");

        $data['assets'] = $query->getResult('array');

        return view('admin/assets/assets_table', $data);
    }

    /**
     * Handover Management
     */
    public function handovers()
    {
        return view('admin/handovers/list');
    }

    public function handoversList()
    {
        $db = \Config\Database::connect();
        $query = $db->query("SELECT handovers.id, adm.name as admin, adm.id as admin_id, emp.name as employee, emp.id as employee_id, handovers.category, handovers.status FROM handovers JOIN employees as emp ON handovers.employee_id=emp.id JOIN employees as adm ON handovers.admin_emp_id=adm.id WHERE handovers.deleted_at IS NULL");

        $data['handovers'] = $query->getResult('array');

        return view('admin/handovers/handovers_table', $data);
    }

    public function handoversAdd()
    {
        $employee_number = trim($_POST['employee_number']);
        $category = trim($_POST['category']);

        $admin_id = $_SESSION['inventoman_user_session'];
        $admin = $this->adminModel->find($admin_id);
        $adminEmployee = $this->employeeModel->find($admin['employee_id']);
        $adminsEmployeeId = $adminEmployee['id'];


        if ($this->handoverModel->where('status', 'pending')->find()) {
            return "conflict";
        } else {
            if ($employee = $this->employeeModel->where('employee_number', $employee_number)->find()) {
                $employee_id = $employee[0]['id'];

                $handoverData = [
                    "admin_emp_id" => $adminsEmployeeId,
                    "employee_id" => $employee_id,
                    "category" => $category,
                    "status" => 'pending'
                ];
                if ($this->handoverModel->insert($handoverData)) {
                    return "success";
                } else {
                    return "failed";
                }
            } else {
                return "notfound";
            }
        }
    }
}
