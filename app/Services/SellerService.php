<?php

namespace App\Services;

use App\Repositories\Interfaces\SellerRepositoryInterface;

class SellerService extends BaseService
{
    public function __construct(SellerRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
