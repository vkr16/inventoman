<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Admin extends BaseController
{

    protected $employeeModel;

    function __construct()
    {
        $this->employeeModel = model('EmployeeModel', true, $db);
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
                    return "new employee added";
                } else {
                    return "failed to add";
                }
            } else {
                return "employee number already registered";
            }
        }
    }
}
