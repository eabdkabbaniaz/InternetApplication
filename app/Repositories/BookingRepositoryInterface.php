<?php

namespace App\Repositories;

use App\Models\User;

interface   BookingRepositoryInterface
{
    public function storeBooking($data, $files);
    
}
