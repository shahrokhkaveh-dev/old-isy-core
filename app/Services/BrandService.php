<?php
namespace App\Services;

use App\Models\Brand;
use App\Repositories\Admin\BrandRepository;

class BrandService
{
    protected BrandRepository $brandRepository;
    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function createBrand(array $data): Brand
    {
        return $this->brandRepository->create($data);
    }

    public function attachUserToBrand(int $userId, int $brandId)
    {
        $this->brandRepository->attachUser($userId, $brandId);
    }
}
