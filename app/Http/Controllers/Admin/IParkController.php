<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CommonFields;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IParkStoreRequest;
use App\Models\Ipark;
use App\Models\Province;
use App\Repositories\IParkRepository;
use Illuminate\Http\Request;

class IParkController extends Controller
{
    private $iParkRepository;
    public function __construct(IParkRepository $iParkRepository)
    {
        $this->iParkRepository = $iParkRepository;
    }

    public function index()
    {
        $perPage = request(CommonFields::PER_PAGE) ?? 10;
        $provinceId = request(CommonFields::PROVINCE);
        $search = request(CommonFields::SEARCH_STRING);

        $iParks = Ipark::select([
            CommonFields::ID, CommonFields::CREATED_AT, CommonFields::NAME, CommonFields::PROVINCE_ID
        ]);

        if ($provinceId) {
            $iParks->where(CommonFields::PROVINCE_ID, $provinceId);
        }

        if ($search) {
            $iParks->where(CommonFields::NAME, 'like', "%{$search}%");
        }

        $iParks = $iParks->paginate($perPage);
        $provinces = Province::all();

        return view('admin.panel.i-parks', compact(['perPage', 'iParks', 'provinces', 'search', 'provinceId']));
    }

    public function store(IParkStoreRequest $request)
    {
        $this->iParkRepository->create($request->validated());

        return back()->with(CommonFields::SUCCESS, __('dashboard.i_park_added_successfully'));
    }

}
