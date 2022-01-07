<?php

namespace App\Services;

use App\Repositories\Interfaces\CustomerRepositoryInterface;

class CustomerService extends BaseService
{
    public function __construct(CustomerRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
