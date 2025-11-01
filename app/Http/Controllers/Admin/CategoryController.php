<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonFields;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryDeleteRequest;
use App\Http\Requests\Admin\CategoryStoreRequest;
use App\Http\Requests\Admin\CategoryUpdateRequest;
use App\Models\Category;
use App\Repositories\CategoryRepository;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        $perPage = request(CommonFields::PER_PAGE) ?? 10;
        $search = request(CommonFields::SEARCH_STRING);

        $categories = Category::select([
            CommonFields::ID, CommonFields::NAME, CommonFields::DESCRIPTION
        ])->whereNull(CommonFields::PARENT_ID)->withCount('brands')->withCount('childs');

        if ($search) {
            return $categories->where(CommonFields::NAME, 'like', "%{$search}%")->limit($perPage)->get();
        }

        $categories = $categories->paginate($perPage);

        return view('admin.panel.categories', compact(['perPage', 'categories', 'search']));
    }

    public function store(CategoryStoreRequest $request)
    {
        $this->categoryRepository->create($request->validated());

        return back()->with(CommonFields::SUCCESS, __('dashboard.category_added_successfully'));
    }

    public function delete(CategoryDeleteRequest $request)
    {
        $this->categoryRepository->delete($request->id);

        return back()->with(CommonFields::SUCCESS, __('dashboard.category_deleted_successfully'));
    }

    public function update(CategoryUpdateRequest $request)
    {
        $validatedData = $request->validated();
        unset($validatedData['id']);
        $this->categoryRepository->update($validatedData, $request->id);

        return back()->with(CommonFields::SUCCESS, __('dashboard.category_updated_successfully'));
    }
}
