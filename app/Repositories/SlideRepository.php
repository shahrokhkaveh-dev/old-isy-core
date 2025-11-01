<?php

namespace App\Repositories;

use App\Models\Slide;
use App\Repositories\Interfaces\SlideRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class SlideRepository implements SlideRepositoryInterface
{
    protected Slide $model;

    /**
     * SlideRepository constructor.
     *
     * @param Slide $slide
     */
    public function __construct(Slide $slide)
    {
        $this->model = $slide;
    }

    public function findBySlider(int $sliderId, array $columns = ['*']): Collection
    {
        return $this->model->where('slider_id', $sliderId)
            ->orderBy('sort', 'asc') // Ensure slides are ordered by sort field
            ->get($columns);
    }

    public function find(int $id): ?Slide
    {
        return $this->model->find($id);
    }

    public function create(array $data): Slide
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $slide = $this->find($id);
        if (!$slide) {
            return false;
        }
        return $slide->update($data);
    }

    public function delete(int $id): bool
    {
        $slide = $this->find($id);
        if (!$slide) {
            return false;
        }
        return $slide->delete();
    }

    public function updateSort(int $id, int $sort): bool
    {
        $slide = $this->find($id);
        if (!$slide) {
            return false;
        }
        return $slide->update(['sort' => $sort]);
    }
}
