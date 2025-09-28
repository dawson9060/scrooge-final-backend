<?php

namespace App;

enum RecurringExpenseType: string
{
    case MISC = 'misc';
    case SAVINGS = 'savings';
    case HOUSING = 'housing';
    case UTILITIES = 'utilities';
    case SUBSCRIPTIONS = 'subscriptions';
    case FOOD = 'food';
    case TRANSPORTATION = 'transportation';
    case HEALTHCARE = 'healthcare';
    case INSURANCE = 'insurance';
    case PHONE = 'phone';
    case ENTERTAINMENT = 'entertainment';
    case PERSONAL_CARE = 'personal_care';
    case DEBT = 'debt';
    case GIFTS_DONATIONS = 'gifts_donations';
    case CHILDCARE = 'childcare';
    case PET_CARE = 'pet_care';
    case EDUCATION = 'education';
    case INVEST_GENERAL = 'invest_general';
    case INVEST_RETIREMENT = 'invest_retirement';
}