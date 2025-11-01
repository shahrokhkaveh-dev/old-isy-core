<?php

namespace App\Repositories\Interfaces;

use App\Models\Slider;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface SliderRepositoryInterface
{
    /**
     * Get all sliders.
     *
     * @param array $columns
     * @return Collection
     */
    public function all(array $columns = ['*']): Collection;

    /**
     * Get paginated sliders.
     *
     * @param int $perPage
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate(int $perPage = 15, array $columns = ['*']): LengthAwarePaginator;

    /**
     * Find a slider by its ID.
     *
     * @param int $id
     * @return Slider|null
     */
    public function find(int $id): ?Slider;

    /**
     * Create a new slider.
     *
     * @param array $data
     * @return Slider
     */
    public function create(array $data): Slider;

    /**
     * Update an existing slider.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a slider.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
