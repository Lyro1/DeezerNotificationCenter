<?php

namespace App\Entity;

enum NotificationType: int {
    case recommendation = 1;
    case new = 2;
    case shared_content = 3;
    case information = 4;
}
