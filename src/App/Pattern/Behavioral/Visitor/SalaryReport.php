<?php
namespace App\Pattern\Behavioral\Visitor;

use App\Pattern\Behavioral\Visitor\Component\Company;
use App\Pattern\Behavioral\Visitor\Component\Department;
use App\Pattern\Behavioral\Visitor\Component\Employee;

class SalaryReport implements Visitor
{
    public function visitCompany(Company $company): string
    {
        $output = "";
        $total = 0;

        foreach ($company->getDepartments() as $department) {
            $total += $department->getCost();
            $output .= "\n--" . $this->visitDepartment($department);
        }

        $output = $company->getName() .
            " (" . $total . ")\n" . $output;

        return $output;
    }

    public function visitDepartment(Department $department): string
    {
        $output = "";

        foreach ($department->getEmployees() as $employee) {
            $output .= "   " . $this->visitEmployee($employee);
        }

        $output = $department->getName() .
            " (" . $department->getCost() . ")\n\n" .
            $output;

        return $output;
    }

    public function visitEmployee(Employee $employee): string
    {
        return $employee->getSalary() .
            " " . $employee->getName() .
            " (" . $employee->getPosition() . ")\n";
    }
}
