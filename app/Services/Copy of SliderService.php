<?php

namespace App\Services;

use App\Models\Slide;
use App\Models\Slider;
use App\Repositories\Interfaces\SlideRepositoryInterface;
use App\Repositories\Interfaces\SliderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;

class SliderService
{
    protected SliderRepositoryInterface $sliderRepository;
    protected SlideRepositoryInterface $slideRepository;
    protected FileService $fileService;

    /**
     * SliderService constructor.
     *
     * @param SliderRepositoryInterface $sliderRepository
     * @param SlideRepositoryInterface $slideRepository
     * @param FileService $fileService
     */
    public function __construct(
        SliderRepositoryInterface $sliderRepository,
        SlideRepositoryInterface $slideRepository,
        FileService $fileService
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->slideRepository = $slideRepository;
        $this->fileService = $fileService;
    }

    /**
     * Get all sliders.
     *
     * @return Collection
     */
    public function getAllSliders(): Collection
    {
        return $this->sliderRepository->all();
    }

    /**
     * Get a single slider by its ID.
     *
     * @param int $id
     * @return Slider|null
     */
    public function getSliderById(int $id): ?Slider
    {
        return $this->sliderRepository->find($id);
    }

    /**
     * Create a new slider.
     *
     * @param array $data
     * @return Slider
     */
    public function createSlider(array $data): Slider
    {
        return $this->sliderRepository->create($data);
    }

    /**
     * Update an existing slider.
     *
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function updateSlider(int $id, array $data): bool
    {
        return $this->sliderRepository->update($id, $data);
    }

    /**
     * Delete a slider and its associated slides and files.
     *
     * @param int $id
     * @return bool
     */
    public function deleteSlider(int $id): bool
    {
        $slider = $this->sliderRepository->find($id);
        if (!$slider) {
            return false;
        }

        // Find all slides for this slider
        $slides = $this->slideRepository->findBySlider($id);

        // Delete each slide and its associated file
        foreach ($slides as $slide) {
            if ($slide->file) {
                $this->fileService->handleDelete($slide->file->id);
            }
            $slide->delete(); // Delete the slide record itself
        }

        // Finally, delete the slider
        return $slider->delete();
    }

    /**
     * Get all slides for a specific slider, ordered by sort.
     *
     * @param int $sliderId
     * @return Collection
     */
    public function getOrderedSlidesBySliderId(int $sliderId): Collection
    {
        return $this->slideRepository->findBySlider($sliderId);
    }

    /**
     * Add a new slide to a slider.
     *
     * @param int $sliderId
     * @param array $slideData
     * @param UploadedFile $imageFile
     * @return Slide|null
     */
    public function addSlideToSlider(int $sliderId, array $slideData, UploadedFile $imageFile): ?Slide
    {
        // Add slider_id to the data array
        $slideData['slider_id'] = $sliderId;

        // Parse position strings to arrays
        $slideData['title_position'] = $this->parsePosition($slideData['title_position'] ?? 'top-start');
        $slideData['text_position'] = $this->parsePosition($slideData['text_position'] ?? 'bottom-start');

        // Create the slide record
        $slide = $this->slideRepository->create($slideData);

        if ($slide) {
            // Handle file upload and associate it with the slide
            $file = $this->fileService->handleUpload($imageFile);
            if ($file) {
                $slide->file()->save($file);
                return $slide->load('file'); // Return slide with the file relationship loaded
            }
        }

        return null; // Return null if something went wrong
    }

    /**
     * Update an existing slide.
     *
     * @param int $slideId
     * @param array $slideData
     * @return bool
     */
    public function updateSlide(int $slideId, array $slideData): bool
    {
        if (isset($slideData['title_position'])) {
            $slideData['title_position'] = $this->parsePosition($slideData['title_position']);
        }
        if (isset($slideData['text_position'])) {
            $slideData['text_position'] = $this->parsePosition($slideData['text_position']);
        }

        return $this->slideRepository->update($slideId, $slideData);
    }

    /**
     * Delete a slide and its associated file.
     *
     * @param int $slideId
     * @return bool
     */
    public function deleteSlide(int $slideId): bool
    {
        $slide = $this->slideRepository->find($slideId);
        if (!$slide) {
            return false;
        }

        if ($slide->file) {
            $this->fileService->handleDelete($slide->file->id);
        }

        return $slide->delete();
    }

    /**
     * Parses a position string (e.g., "top-start") into an array.
     *
     * @param string $positionString
     * @return array
     */
    private function parsePosition(string $positionString): array
    {
        $parts = explode('-', $positionString);
        return [
            'vertical' => $parts[0] ?? 'top', // top or bottom
            'horizontal' => $parts[1] ?? 'start', // start or end
        ];
    }
}
