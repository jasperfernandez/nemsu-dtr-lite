<?php

namespace App\Enums;

enum AttendanceDayStatus: string
{
    case PRESENT = 'present';
    case LATE = 'late';
    case ABSENT = 'absent';
    case LEAVE = 'leave';
    case HOLIDAY = 'holiday';
}
