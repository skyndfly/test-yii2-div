<?php

namespace app\services\request\enums;

enum RequestStatusEnum:string
{
    case ACTIVE = 'Active';
    case RESOLVED = 'Resolved';
}
