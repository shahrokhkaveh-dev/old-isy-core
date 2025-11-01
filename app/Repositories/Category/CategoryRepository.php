<?php

namespace App\Repositories\Category;

use App\Enumerations\Category\Fields;
use App\Enums\CommonFields;
use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository
{
    public function __construct()
    {
        parent::__construct(new Category());
    }

    public function getCategoryChildren($id = null)
    {
        return $this->model->where('parent_id', $id)->get(['id', 'name', 'slug', 'icons', 'code']);
    }

    public function getChildrenFromCode($code): ?array
    {
        $code = rtrim($code, '0');
        $categories = $this->model->where('code', 'like', "{$code}%")->get()->pluck('id');
        return $categories ? $categories->toArray() : null;
    }

    public function homeCategories(): array
    {
        $mainCategories = $this->model->whereNull('parent_id')
            ->with([
                'childs:id,name,code,parent_id',
                'childs.childs:id,name,code,parent_id',
            ])
            ->select(['id', 'name', 'code', 'parent_id'])
            ->limit(15)
            ->get();
        $moreCategories = $this->model->whereNull('parent_id')
            ->with([
                'childs:id,name,code,parent_id',
                'childs.childs:id,name,code,parent_id',
            ])
            ->select(['id', 'name', 'code', 'parent_id'])
            ->offset(15)
            ->limit(15)
            ->get();
        return ['main' => $mainCategories, 'more' => $moreCategories];
    }

    // public function fetchCategories($parentId = null): array
    // {
    //     $categories = $this->model->where(Fields::PARENT_ID->value, $parentId)
    //         ->select([CommonFields::ID, Fields::NAME->value])
    //         ->withCount('childs')
    //         ->get()
    //         ->map(fn($category) => [
    //             CommonFields::ID => $category->getAttribute(CommonFields::ID),
    //             Fields::NAME->value => $category->getAttribute(Fields::NAME->value),
    //             'has_children' => $category->childs_count > 0
    //         ]);
    //     return $categories ? $categories->toArray() : [];
    // }
    public function fetchCategories($parentId = null): array
    {
        // دریافت زبان فعلی
        $currentLocale = \request()->header('X-Lang') ?? 'fa';

        $categories = $this->model->where(Fields::PARENT_ID->value, $parentId)
            ->with([
                'translations' => function($query) use ($currentLocale) {
                    $query->where('locale', $currentLocale);
                },
                'childs.translations' => function($query) use ($currentLocale) {
                    $query->where('locale', $currentLocale);
                }
            ])
            ->withCount('childs')
            ->get()
            ->map(function($category) use ($currentLocale) {
                return [
                    CommonFields::ID => $category->getAttribute(CommonFields::ID),
                    Fields::NAME->value => $currentLocale === 'fa'
                        ? $category->getAttribute(Fields::NAME->value)
                        : ($category->translations?->first()->name ?? $category->getAttribute(Fields::NAME->value)),
                    'has_children' => $category->childs_count > 0
                ];
            });

        return $categories ? $categories->toArray() : [];
    }
}
