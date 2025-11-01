<?php

namespace App\Repositories;

use App\Enums\AdminLoginAttempt\Fields;
use App\Enums\AdminLoginAttempt\Entries;
use App\Enums\CommonFields;
use App\Models\Admin\AdminLoginAttempt;

class AdminLoginAttemptRepository extends BaseRepository
{
    private static $object;

    public function __construct()
    {
        $model = new AdminLoginAttempt();
        parent::__construct($model);
    }

    public function checkAttempt($ip, $username): bool
    {
        $lastSuccessfulLogin = $this->model->where(function ($query) use ($ip, $username) {
            $query->where(Fields::IP, $ip)
                ->orWhere(CommonFields::USERNAME, $username);
        })->where(Fields::STATUS, Entries::SUCCESS_LOGIN)
            ->latest()->first();


        $count = $this->model->where(function ($query) use ($ip, $username) {
            $query->where(Fields::IP, $ip)
                ->orWhere(CommonFields::USERNAME, $username);
        })->where(Fields::STATUS, Entries::FAILED_LOGIN);

        if ($lastSuccessfulLogin) {
            $count = $count->where(CommonFields::CREATED_AT, CommonFields::GREATER_THAN,
                $lastSuccessfulLogin->created_at);
        }

        $count = $count->count();

        return $count > Entries::ATTEMPT_LIMIT;
    }

    public function createEntry($data)
    {
        self::$object = $this->create($data);
    }

    public function successStatus()
    {
        self::$object->update([Fields::STATUS => Entries::SUCCESS_LOGIN]);
    }
}
