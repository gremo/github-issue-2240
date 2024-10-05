<?php

namespace App\Model;

use App\Enum\Employee;
use App\Enum\Office;

class WorkHoursSearch
{
    public ?Office $office = null;

    public ?Employee $employee = null;
}
