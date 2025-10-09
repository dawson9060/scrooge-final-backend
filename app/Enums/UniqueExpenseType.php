<?php

namespace App\Enums;

enum UniqueExpenseType: string
{
    case EXPENSE = 'expense';
    case DEPOSIT = 'deposit';
}