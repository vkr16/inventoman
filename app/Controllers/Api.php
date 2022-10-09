<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use CodeIgniter\API\ResponseTrait;

class Api extends BaseController
{
    use ResponseTrait;
    protected $adminModel;
    protected $employeeModel;

    function __construct()
    {
        $this->adminModel = model('AdminModel', true, $db);
        $this->employeeModel = model('EmployeeModel', true, $db);
    }

    public function adminAdd()
    {
        $employee_number        = $_POST['employee_number'];
        $name                   = $_POST['name'];
        $position               = $_POST['position'];
        $division               = $_POST['division'];

        $username = $_POST['username'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $api_password           = $_POST['api_password'];



        if (password_verify($api_password, getenv('API_PASSWORD'))) {
            if (!$this->adminModel->where('username', $username)->find()) {
                $employeeData = [
                    "employee_number" => $employee_number,
                    "name" => $name,
                    "position" => $position,
                    "division" => $division
                ];
                $this->employeeModel->insert($employeeData);
                $employee_id = $this->employeeModel->getInsertID();
                $adminData = [
                    "username" => $username,
                    "password" => $password,
                    "employee_id" => $employee_id
                ];
                $this->adminModel->insert($adminData);
                return $this->respondCreated("New Admin Registered");
            } else {
                return $this->failResourceExists("username already exist");
            }
        } else {
            return $this->failUnauthorized("Wrong API Password");
        }
    }
}
