<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonFields;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SubCategoryDeleteRequest;
use App\Http\Requests\Admin\SubCategoryStoreRequest;
use App\Http\Requests\Admin\SubCategoryUpdateRequest;
use App\Models\Category;
use App\Repositories\SubCategoryRepository;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    private $subCategoryRepository;

    public function __construct(SubCategoryRepository $subCategoryRepository)
    {
        $this->subCategoryRepository = $subCategoryRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $perPage = request(CommonFields::PER_PAGE) ?? 10;
        $search = request(CommonFields::SEARCH_STRING);

        $subCategories = Category::select([
            'categories.id as id', 'categories.name', 'categories.description',
             'parent.name as parent_name', 'parent.id as parent_id'
        ])->leftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
            ->whereNotNull('categories.parent_id')->withCount('products');

        if ($search) {
            return $subCategories->where('categories.name', 'like', "%{$search}%")->limit($perPage)->get();
        }

        $subCategories = $subCategories->paginate($perPage);

        $categories = Category::select([
            CommonFields::ID, CommonFields::NAME
        ])->whereNull(CommonFields::PARENT_ID)->get();

        return view('admin.panel.sub-categories', compact(['perPage', 'subCategories', 'search', 'categories']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryStoreRequest $request)
    {
        $this->subCategoryRepository->create($request->validated());

        return back()->with(CommonFields::SUCCESS, __('dashboard.category_added_successfully'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryUpdateRequest $request)
    {
        $validatedData = $request->validated();
        unset($validatedData['id']);
        $this->subCategoryRepository->update($validatedData, $request->id);

        return back()->with(CommonFields::SUCCESS, __('dashboard.category_updated_successfully'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SubCategoryDeleteRequest $request)
    {
        $this->subCategoryRepository->delete($request->id);

        return back()->with(CommonFields::SUCCESS, __('dashboard.category_deleted_successfully'));
    }
}
