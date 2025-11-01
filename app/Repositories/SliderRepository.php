<?php

namespace App\Repositories;

use App\Models\Slider;
use App\Repositories\Interfaces\SliderRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class SliderRepository implements SliderRepositoryInterface
{
    protected Slider $model;

    /**
     * SliderRepository constructor.
     *
     * @param Slider $slider
     */
    public function __construct(Slider $slider)
    {
        $this->model = $slider;
    }

    public function all(array $columns = ['*']): Collection
    {
        return $this->model->all($columns);
    }

    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator
    {
        return $this->model->paginate($perPage, $columns);
    }

    public function find(int $id): ?Slider
    {
        return $this->model->find($id);
    }

    public function create(array $data): Slider
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $slider = $this->find($id);
        if (!$slider) {
            return false;
        }
        return $slider->update($data);
    }

    public function delete(int $id): bool
    {
        $slider = $this->find($id);
        if (!$slider) {
            return false;
        }
        return $slider->delete();
    }
}
