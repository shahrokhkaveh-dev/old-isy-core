<?php

namespace App\Enums\Admin;

final class Rules
{
    public const REQUIRED = 'required';
    public const STRING = 'string';
    public const NUMERIC = 'numeric';
    public const ARRAY = 'array';
    public const INTEGER = 'integer';
    public const CONFIRMED = 'confirmed';
    public const IMAGE = 'image';
    public const AT_LEAST_EIGHT_CHARACTERS = 'min:8';
    public const SHOULD_EXIST_IN_PROVINCES = 'exists:provinces,id';
    public const SHOULD_EXIST_IN_BRANDS = 'exists:brands,id';
    public const NAME_SHOULD_NOT_EXIST_IN_CATEGORIES = 'unique:categories,name';
    public const NAME_SHOULD_NOT_EXIST_IN_CATEGORIES_EXCEPT_CURRENT_RECORD = 'unique:categories,name';
    public const SHOULD_EXIST_IN_CATEGORIES = 'exists:categories,id';
    public const CATEGORY_SHOULD_NOT_EXIST_IN_BRANDS = 'unique:brands,category_id';
    public const CATEGORY_SHOULD_NOT_EXIST_IN_PRODUCTS = 'unique:products,sub_category_id';
    public const NULLABLE = 'nullable';
    public const CATEGORY_SHOULD_NOT_BE_PARENT = 'unique:categories,parent_id';
    public const MOBILE_REGEX_PATTERN = 'regex:/^0?9[0-9]{9}$/';
    public const SHOULD_BE_BETWEEN_ONE_TO_FOUR = 'between:1,4';
    public const FILE = 'file';
    public const FILE_MIMES = 'mimes:jpg,jpeg,png,pdf,doc,docx';
    public const FILE_SIZE = 'max:2048';
    public const UUID = 'uuid';
    public const UUID_SHOULD_EXISTS_IN_TICKETS = 'exists:tickets,uuid';
    public const ID_SHOULD_EXISTS_IN_TICKETS = 'exists:tickets,id';

}
