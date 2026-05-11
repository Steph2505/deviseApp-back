<?php
namespace App\Repositories;

use App\Models\Devise;
use App\Repositories\ResourceRepository;

class DeviseRepository extends ResourceRepository
{
    public function __construct(Devise $devise)
    {
        $this->model = $devise;
    }
}