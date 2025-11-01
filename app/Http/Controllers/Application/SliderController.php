<?php

namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\StoreSlideRequest;
use App\Http\Resources\SlideResource;
use App\Services\FileService;
use App\Services\SliderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
{
    protected SliderService $sliderService;
    protected FileService $fileService;

    /**
     * SliderController constructor.
     *
     * @param SliderService $sliderService
     * @param FileService $fileService
     */
    public function __construct(SliderService $sliderService, FileService $fileService)
    {
        $this->sliderService = $sliderService;
        $this->fileService = $fileService;
    }

    /**
     * Display a listing of the sliders.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $sliders = $this->sliderService->getAllSliders();
        return response()->json($sliders);
    }

    /**
     * Store a newly created slider in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $slider = $this->sliderService->createSlider($data);
        return response()->json($slider, 201);
    }

    /**
     * Display the specified slider.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $slider = $this->sliderService->getSliderById($id);
        if (!$slider) {
            return response()->json(['message' => 'Slider not found'], 404);
        }

        $slider->load(['slides.file', 'slides.translation']); // Eager load relationships
        return response()->json($slider);
    }

    /**
     * Update the specified slider in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'status' => 'nullable|boolean',
        ]);

        $updated = $this->sliderService->updateSlider($id, $data);
        if (!$updated) {
            return response()->json(['message' => 'Slider not found or update failed'], 404);
        }

        return response()->json(['message' => 'Slider updated successfully']);
    }

    /**
     * Remove the specified slider from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->sliderService->deleteSlider($id);
        if (!$deleted) {
            return response()->json(['message' => 'Slider not found or delete failed'], 404);
        }

        return response()->json(['message' => 'Slider deleted successfully']);
    }

    /**
     * Get all slides for a specific slider, ordered by sort.
     * This is the main endpoint requested.
     *
     * @param int $sliderId
     * @return Collection
     */
    public function getSlides(int $sliderId): Collection
    {
        $slides = $this->sliderService->getOrderedSlidesBySliderId($sliderId);
        // Return the collection of slides formatted by SlideResource
        return SlideResource::collection($slides)->collection;
    }

    /**
     * Add a new slide to a slider.
     *
     * @param StoreSlideRequest $request
     * @return JsonResponse
     */
    public function addSlide(StoreSlideRequest $request): JsonResponse
    {
        $validatedData = $request->validated();
        $imageFile = $request->file('image');

        DB::beginTransaction();
        try {
            // The service method now handles creating the slide and uploading/attaching the file
            $slide = $this->sliderService->addSlideToSlider(
                $validatedData['slider_id'],
                $validatedData,
                $imageFile
            );

            if (!$slide) {
                throw new \Exception('Failed to create slide.');
            }

            DB::commit();

            // Return the newly created slide with its file, formatted by SlideResource
            return response()->json(new SlideResource($slide), 201);

        } catch (\Exception $e) {
            DB::rollBack();
            // TODO: Log the error $e->getMessage()
            return response()->json(['message' => 'Failed to create slide.'], 500);
        }
    }
}
