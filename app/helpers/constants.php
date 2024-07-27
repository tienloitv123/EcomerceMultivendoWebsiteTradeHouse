<?php

use App\Models\Client;

class constGuards
{
    const ADMIN = 'admin';
    const CLIENT = 'client';
    const SELLER = 'seller';
}

class constDefaults{
    const tokenExpriredMinutes = 15;
}
