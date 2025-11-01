<?php

namespace App\Repositories\Interfaces;

use App\Models\Slide;
use Illuminate\Database\Eloquent\Collection;

interface SlideRepositoryInterface
{
    /**
     * Get all slides for a specific slider, ordered by sort.
     *
     * @param int $sliderId
     * @param array $columns
     * @return Collection
     */
    public function findBySlider(int $sliderId, array $columns = ['*']): Collection;

    /**
     * Find a slide by its ID.
     *
     * @param int $id
     * @return Slide|null
     */
    public function find(int $id): ?Slide;

    /**
     * Create a new slide.
     *
     * @param array $data
     * @return Slide
     */
    public function create(array $data): Slide;

    /**
     * Update an existing slide.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * Delete a slide.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Update the sort order of a slide.
     *
     * @param int $id
     * @param int $sort
     * @return bool
     */
    public function updateSort(int $id, int $sort): bool;
}
