<?php

namespace App\Repositories;

use App\Models\Seller;
use App\Repositories\Interfaces\SellerRepositoryInterface;

class SellerRepository extends BaseRepository implements SellerRepositoryInterface
{
    public function __construct(Seller $model)
    {
        parent::__construct($model);
    }
}
