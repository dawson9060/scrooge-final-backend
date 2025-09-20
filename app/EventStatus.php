<?php

namespace App;

enum EventStatus: string
{
    case CREATED = 'created';
    case PENDING_ACCEPT = 'pending_accept';
    case BOOKED = 'booked';
    case SETTLED = 'settled';
    case PROCESS_ERROR = 'process_error';
    case CANCELLED = 'cancelled';
}