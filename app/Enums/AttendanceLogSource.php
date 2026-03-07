<?php

namespace App\Enums;

enum AttendanceLogSource: string
{
    case WEB = 'web';
    case BIOMETRIC = 'biometric';
    case MANUAL = 'manual';
}
