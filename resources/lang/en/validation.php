<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
     */

    "accepted" => ":attribute must be accepted.",
    "active_url" => "adress :attribute not valid",
    "after" => ":attribute it must be another date :date .",
    "alpha" => ":attribute it must contain alphabets.",
    "alpha_dash" => ":attribute it must contain alphabets, numbers and hyphens(-).",
    "alpha_num" => ":attribute it must contain alphabets and numbers.",
    "array" => ":attribute it must contain figures of speech",
    "before" => ":attribute it must be date before :date.",
    "between" => [
        "numeric" => ":attribute it must be between :min and :max .",
        "file" => ":attribute it must be between :min and :max KB.",
        "string" => ":attribute it must be between :min and :max character.",
        "array" => ":attribute it must be between :min and :max item.",
    ],
    "boolean" => "the field :attribute only can be true or fals.",
    "confirmed" => ":attribute does not match the confirmation.",
    "date" => ":attribute the date is not valid.",
    "date_format" => ":attribute with pattern :format does not match.",
    "different" => ":attribute and :other it must be different.",
    "digits" => ":attribute it must :digits be numeral.",
    "digits_between" => ":attribute it must be between :min and :max numeral.",
    'dimensions' => 'dimensions  :attribute are invalid.',
    "email" => "format :attribute is invalid.",
    "exists" => ":attribute selected is not valid.",
    "filled" => "field :attribute is essential.",
    "image" => ":attribute it must be image.",
    "in" => ":attribute selected is not valid.",
    "integer" => ":attribute the data type must be numeric. (integer) ",
    "ip" => ":attribute ip adress must be valid.",
    "max" => [
        "numeric" => ":attribute it must be bigger than :max .",
        "file" => "volume :attribute should not be more than :max Kb.",
        "string" => ":attribute should not be more than :max  character.",
        "array" => ":attribute should not be more than :max item.",
    ],
    "mimes" => ":attribute it must be one of the formats :values ",
    "min" => [
        "numeric" => ":attribute should not be less :min .",
        "file" => ":attribute should not be less than :min Kb.",
        "string" => ":attribute should not be less than :min character.",
        "array" => ":attribute should not be less than :min item.",
    ],
    "not_in" => ":attribute selected not valid.",
    "numeric" => ":attribute it must contain number .",
    "regex" => ":attribute not a valid format .",
    "required" => ":attribute this field is required .",
    "required_if" => "field :attribute when :other is equal to :value is nessessary .",
    "required_with" => ":attribute it is mandatory when :values exist.",
    "required_with_all" => ":attribute it is mandatory when :values not valid.",
    "required_without" => ":attribute it is mandatory when :values not valid.",
    "required_without_all" => ":attribute it is mandatory when :values not valid.",
    "same" => ":attribute and :other they must be the same .",
    "size" => [
        "numeric" => ":attribute should be equal to :size .",
        "file" => ":attribute should be equal to :size Kb ",
        "string" => ":attribute should be equal to :size character.",
        "array" => ":attribute must include :size item.",
    ],
    "string" => ":attribute it must be string .",
    "timezone" => "field :attribute must be valid area .",
    "unique" => ":attribute already selected .",
    'uploaded' => 'upload :attribute failed.',
    "url" => "the adress format:attribute is incorrect.",

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
     */

    'custom' => array(
        'adult_id' => array(
            'required' => 'Please choose some parents!',
        ),
        'group_id' => array(
            'required' => 'Please choose a group or choose temp!',
        ),
    ),

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
     */
    'attributes' => [
        "name" => "name",
        'firstName' => 'first name',
        "username" => "username",
        "email" => "email",
        "first_name" => "first name",
        "last_name" => "last name",
        "lastName" => "last name",
        "family" => "last name",
        "password" => "password",
        "password_confirmation" => "password confirmation",
        "discription" => "discription",
        "city" => "city",
        "country" => "country",
        "address" => "adress",
        "phone" => "phone number",
        "mobile" => "mobile number",
        "cellphone" => "cellephone",
        "age" => "age",
        "sex" => "gender",
        "gender" => "gender",
        "day" => "day",
        "month" => "month",
        "year" => "year",
        "hour" => "hour",
        "minute" => "minute",
        "second" => "second",
        "title" => "title",
        "text" => "text",
        "content" => "content",
        "description" => "description",
        "excerpt" => "excerpt",
        "date" => "date",
        "time" => "time",
        "available" => "available",
        "size" => "size",
        "file" => "file",
        "fullname" => "fullname",
        "postal_code" => "postal code",
        "comment" => "comment",
        "body" => "main text",
        "image" => "image",
        "photos" => "photos",
        "photo" => "photo",
        "cat_id" => "grouping",
        "published_at" => "date of release",
        "reference_id" => "refrence",
        "priority_id" => "priority",
        "category_id" => "categories",
        'status' => 'status',
        'tags' => 'tags',
        'summary' => 'summery',
        'question' => 'question',
        'answer' => 'answer',
        'parent_id' => 'main menu',
        'url' => 'address',
        'keywords' => 'keywords',
        'logo' => 'logo',
        'icon' => 'icon',
        'amount' => 'amount',
        'delivery_time' => 'delivery time',
        'delivery_time_unit' => 'delivery time unit',
        'original_name' => 'real name',
        'persian_name' => 'persian name',
        'brand_id' => 'brand',
        'weight' => 'weight',
        'length' => 'length',
        'width' => 'width',
        'height' => 'height',
        'price' => 'price',
        'introduction' => 'introduction',
        'persian_name' => 'persian name',
        'price_increase' => 'price increase',
        'color_name' => 'color',
        'unit' => 'unit',
        'receiver' => 'reciver',
        'deliverer' => 'deliver',
        'marketable_number' => 'marketable number',
        'percentage' => 'percentage',
        'discount_ceiling' => 'discountin ceiling',
        'minimal_order_amount' => 'minimum order amount',
        'product_id' => 'commodity',
        'code' => 'code',
        'user_id' => 'user',
        'type' => 'type',
        'otp' => 'one time password',
        'color' => 'color',
        'national_code' => 'national ID number',
        'postal_code' => 'postal code',
        'province_id' => 'provience',
        'city_id' => 'city',
        'no' => 'No',
        'recipient_first_name' => 'recipient first name',
        'recipient_last_name' => 'recipient last name',
        'delivery_id' => 'consign',
        'address_id' => 'address',
        'copan' => 'copan',
        'userName'=>'username',
        'captcha'=>'captcha',
        'confirm_password'=>'confirm password'
    ],
];
