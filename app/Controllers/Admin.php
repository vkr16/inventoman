<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{

    protected $employeeModel;
    protected $adminModel;

    function __construct()
    {
        $this->employeeModel = model('EmployeeModel', true, $db);
        $this->adminModel = model('AdminModel', true, $db);
    }

    public function index()
    {
        return view('admin/dashboard');
    }

    public function employees()
    {
        return view('admin/employees/list');
    }

    public function employeesAdd()
    {
        $employee_number    = $_POST['employee_number'];
        $name               = $_POST['name'];
        $position           = $_POST['position'];
        $division           = $_POST['division'];

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
        $employee_number = $_POST['employee_number'];
        $name = $_POST['name'];
        $position = $_POST['position'];
        $division = $_POST['division'];

        $updatedData = [
            "employee_number" => $employee_number,
            "name" => $name,
            "position" => $position,
            "division" => $division,
        ];

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
}
