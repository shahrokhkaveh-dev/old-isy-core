<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use App\Services\Application\ApplicationService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryRepository $categoryRepository;

    function __construct()
    {
        $this->categoryRepository = new CategoryRepository();
    }

    public function index()
    {

    }

    public function getCategories(Request $request): \Illuminate\Http\JsonResponse
    {
        // dd(50);
        $categoryId = $request->input('category_id');

        if ($categoryId) {
            $category = $this->categoryRepository->getRecordById($categoryId);

            if (!$category) {
                return ApplicationService::responseFormat([], false, __('messages.category_not_found'), 404);
            }
        }

        $categories = $this->categoryRepository->fetchCategories($categoryId);

        return ApplicationService::responseFormat($categories);
    }
}
