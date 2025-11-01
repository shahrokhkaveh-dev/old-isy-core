<?php
namespace App\Services\Slider;

use App\Models\SliderSelection;
use App\Repositories\Interfaces\SliderRepositoryInterface;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;

class SliderService
{
    protected SliderRepositoryInterface $sliderRepository;
    protected ImageService $imageService;

    public function __construct(
        SliderRepositoryInterface $sliderRepository,
        ImageService $imageService
    ) {
        $this->sliderRepository = $sliderRepository;
        $this->imageService = $imageService;
    }

    public function getAllSliders(array $filters = [])
    {
        return $this->sliderRepository->all($filters);
    }

    public function getSliderById(int $id)
    {
        return $this->sliderRepository->find($id);
    }

    public function createSlider(array $data)
    {
        // پردازش تصویر
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $data['image'] = $this->imageService->processSliderImage($data['image']);
        }

        $slider = $this->sliderRepository->create($data);

        // ایجاد ترجمه‌ها
        if (isset($data['translations'])) {
            foreach ($data['translations'] as $locale => $translation) {
                $slider->translations()->create([
                    'locale' => $locale,
                    'title' => $translation['title'],
                    'subtitle' => $translation['subtitle'] ?? null,
                    'button_text' => $translation['button_text'] ?? null,
                    'button_url' => $translation['button_url'] ?? null,
                ]);
            }
        }

        $this->clearCache($slider->type);
        return $slider;
    }

    public function updateSlider(int $id, array $data)
    {
        // پردازش تصویر جدید
        if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
            $oldSlider = $this->getSliderById($id);
            if ($oldSlider && $oldSlider->image) {
                $this->imageService->deleteImage($oldSlider->image);
            }
            $data['image'] = $this->imageService->processSliderImage($data['image']);
        }

        $slider = $this->sliderRepository->update($id, $data);

        if ($slider) {
            // به‌روزرسانی ترجمه‌ها
            if (isset($data['translations'])) {
                foreach ($data['translations'] as $locale => $translation) {
                    $slider->translations()->updateOrCreate(
                        ['locale' => $locale],
                        [
                            'title' => $translation['title'],
                            'subtitle' => $translation['subtitle'] ?? null,
                            'button_text' => $translation['button_text'] ?? null,
                            'button_url' => $translation['button_url'] ?? null,
                        ]
                    );
                }
            }

            $this->clearCache($slider->type);
        }

        return $slider;
    }

    public function deleteSlider(int $id)
    {
        $slider = $this->getSliderById($id);

        if (!$slider) {
            return false;
        }

        // حذف تصویر
        if ($slider->image) {
            $this->imageService->deleteImage($slider->image);
        }

        $result = $this->sliderRepository->delete($id);

        if ($result) {
            $this->clearCache($slider->type);
        }

        return $result;
    }

    public function getActiveSliders(string $type, string $mode = null)
    {
        return $this->sliderRepository->getActiveSliders($type, $mode);
    }

    public function getSlidersBySelection(string $selectionKey)
    {
        return $this->sliderRepository->getBySelection($selectionKey);
    }

    public function createSelection(array $data)
    {
        $selection = SliderSelection::create($data);

        // پیوند دادن اسلایدرها به انتخاب
        if (isset($data['slider_ids']) && is_array($data['slider_ids'])) {
            $order = 1;
            foreach ($data['slider_ids'] as $sliderId) {
                $selection->sliders()->attach($sliderId, ['order' => $order++]);
            }
        }

        $this->clearCache('selection');
        return $selection;
    }

    public function updateSelection(int $id, array $data)
    {
        $selection = SliderSelection::find($id);

        if (!$selection) {
            return null;
        }

        $selection->update($data);

        // به‌روزرسانی پیوندهای اسلایدرها
        if (isset($data['slider_ids']) && is_array($data['slider_ids'])) {
            $selection->sliders()->detach();

            $order = 1;
            foreach ($data['slider_ids'] as $sliderId) {
                $selection->sliders()->attach($sliderId, ['order' => $order++]);
            }
        }

        $this->clearCache('selection');
        return $selection;
    }

    protected function clearCache(string $type)
    {
        Cache::tags(['sliders', $type])->flush();
    }
}
