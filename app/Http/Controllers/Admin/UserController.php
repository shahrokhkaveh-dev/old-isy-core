<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonFields;
use App\Enums\User\Entries;
use App\Enums\User\Fields;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserDeleteRequest;
use App\Http\Requests\Admin\UserStoreRequest;
use App\Http\Requests\Admin\UserUpdateRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\ImageService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        $perPage = request(CommonFields::PER_PAGE) ?? 10;
        $search = request(CommonFields::SEARCH_STRING);

        $users = User::select([
            CommonFields::ID, CommonFields::NAME, Fields::PHONE, CommonFields::CREATED_AT, CommonFields::STATUS,
            DB::raw("(SELECT name FROM brands WHERE id = users.brand_id) as brand_name")
        ])->orderBy(CommonFields::CREATED_AT, 'desc');

        if ($search) {
            $users = $users->where(function ($query) use ($search) {
                $query->where(CommonFields::NAME, 'like', "%{$search}%")
                    ->orWhere(Fields::PHONE, 'like', "%{$search}%");
            })->limit($perPage)->get();

            foreach ($users as $user) {
                $user[CommonFields::CREATED_AT] = jdate($user->created_at);
                $user[CommonFields::STATUS] = Entries::STATUS[$user[CommonFields::STATUS]];
            }

            return $users;
        }

        $users = $users->paginate($perPage);

        foreach ($users as $user) {
            $user[CommonFields::CREATED_AT] = jdate($user->created_at);
            $user[CommonFields::STATUS] = Entries::STATUS[$user[CommonFields::STATUS]];
        }

        return view('admin.panel.users.index', compact(['perPage', 'users', 'search']));
    }

    public function show($userId)
    {
        $fields = [
            CommonFields::ID, Fields::PHONE, Fields::EMAIL, Fields::FIRST_NAME_FIELD, Fields::LAST_NAME_FIELD,
            CommonFields::STATUS, CommonFields::BRAND_ID, Fields::AVATAR
        ];

        $user = $this->userRepository->getRecordById($userId, $fields);

        return view('admin.panel.users.show', compact(['user']));
    }

    public function destroy(UserDeleteRequest $request)
    {
        $this->userRepository->delete($request->id);

        return back()->with(CommonFields::SUCCESS, __('dashboard.user_deleted_successfully'));
    }

    public function update(UserUpdateRequest $request, $userId)
    {
        $fields = [
            Fields::PHONE, Fields::EMAIL, Fields::PASSWORD,
            CommonFields::STATUS
        ];

        $entries = [];

        $firstName = request(Fields::FIRST_NAME_INPUT);
        $lastName = request(Fields::LAST_NAME_INPUT);
        $image = request(Fields::IMAGE);
        $password = request(Fields::PASSWORD);
        $entries[CommonFields::BRAND_ID] = request(CommonFields::BRAND_ID);

        if (!is_null($password)) {
            $entries[Fields::PASSWORD] = Hash::make($password);
        }

        if (!is_null($image)) {
            $path = ImageService::upload($image);
            $entries[Fields::AVATAR] = $path;
        }

        if (!is_null($firstName) && !is_null($lastName)) {
            $entries[Fields::NAME] = $firstName.' '.$lastName;
            $entries[Fields::FIRST_NAME_FIELD] = $firstName;
            $entries[Fields::LAST_NAME_FIELD] = $lastName;
        }


        foreach ($fields as $field) {
            $entry = request($field);
            if (!is_null($entry)) {
                $entries[$field] = $entry;
            }
        }

        $this->userRepository->update($entries, $userId);

        return back()->with(CommonFields::SUCCESS, __('dashboard.user_updated_successfully'));
    }

    public function store(UserStoreRequest $request)
    {
        $fields = [
            Fields::PHONE, Fields::EMAIL, Fields::PASSWORD,
            CommonFields::STATUS, CommonFields::BRAND_ID
        ];
        $firstName = request(Fields::FIRST_NAME_INPUT);
        $lastName = request(Fields::LAST_NAME_INPUT);
        $image = request(Fields::IMAGE);

        $inputs = request()->only($fields);
        $inputs[Fields::PASSWORD] = Hash::make($inputs[Fields::PASSWORD]);
        $inputs[Fields::NAME] = $firstName.' '.$lastName;
        $inputs[Fields::FIRST_NAME_FIELD] = $firstName;
        $inputs[Fields::LAST_NAME_FIELD] = $lastName;

        if ($image) {
            $path = ImageService::upload($image);
            $inputs[Fields::AVATAR] = $path;
        }

        $this->userRepository->create($inputs);

        return redirect('admin/users')->with(CommonFields::SUCCESS, __('dashboard.user_created_successfully'));
    }

    public function create()
    {
        return view('admin.panel.users.create');
    }
}
