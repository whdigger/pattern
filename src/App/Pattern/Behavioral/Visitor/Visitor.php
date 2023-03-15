<?php
namespace App\Pattern\Behavioral\Visitor;

use App\Pattern\Behavioral\Visitor\Component\Company;
use App\Pattern\Behavioral\Visitor\Component\Department;
use App\Pattern\Behavioral\Visitor\Component\Employee;

interface Visitor
{
    public function visitCompany(Company $company): string;

    public function visitDepartment(Department $department): string;

    public function visitEmployee(Employee $employee): string;
}