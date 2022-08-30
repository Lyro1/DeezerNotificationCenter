<?php

namespace App\Entity;

enum NotificationType: int {
    case recommendation = 1;
    case new_album = 2;
    case new_single = 3;
    case shared_content = 4;
    case information = 5;
}
