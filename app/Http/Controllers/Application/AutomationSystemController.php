<?php
namespace App\Http\Controllers\Application;

use App\Http\Controllers\Controller;
use App\Http\Requests\Application\ASSendRequest;
use App\Http\Requests\Application\ASSendOrganizationRequest;
use App\Http\Requests\Application\BulkRequest;
use App\Http\Requests\MobileLetterRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Group;
use App\Models\GroupBrands;
use App\Models\Letter;
use App\Models\Province;
use App\Models\Signature;
use App\Repositories\AttachmentRepositories;
use App\Repositories\SignatureRepositories;
use App\Services\Application\ApplicationService;
use App\Services\Notifications\FirebaseService;
use App\Services\Notifications\SMSPattern;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use niklasravnsborg\LaravelPdf\Facades\Pdf;

class AutomationSystemController extends Controller
{
    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function search(Request $request)
    {
        $messages = [
            'type.required' => __('messages.type_required'),
            'search.required' => __('messages.search_required'),
        ];

        $request->validate([
            'type' => 'required',
            'search' => 'required'
        ], $messages);

        if (!$request->input('type') || !$request->input('search')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $response = [];
        switch ($request->input('type')) {
            case 1:
                if(getMode() == 'global'){
                    $response = DB::table('brands')->select(['id', 'name'])->where('name', 'LIKE', "%{$request->input('search')}%")->limit(6)->get();
                }elseif(getMode() == 'freezone'){
                    $response = DB::table('brands')->select(['id', 'name'])->where('freezone_id', '!=', null)->where('name', 'LIKE', "%{$request->input('search')}%")->limit(6)->get();
                }
                break;
            case 2:
                $response = DB::table('groups')->select(['id', 'name'])->where('brand_id', \request()->user()->brand_id)->where('name', 'LIKE', "%{$request->input('search')}%")->limit(6)->get();
                break;
        }

        $response = $response ? $response->toArray() : null;
        $response = array_map(function ($item) {
            return [
                'id' => encrypt($item->id),
                'name' => $item->name
            ];
        }, $response);
        $data['items'] = $response;
        return ApplicationService::responseFormat($data);
    }

    public function search2(Request $request)
    {
        $messages = [
            'type.required' => __('messages.type_required'),
            'search.required' => __('messages.search_required'),
        ];

        $request->validate([
            'type' => 'required',
            'search' => 'required'
        ], $messages);

        if (!$request->input('type') || !$request->input('search')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $searchTerm = $request->input('search');
        $response = collect();

        switch ($request->input('type')) {
            case 1:
                $query = Brand::query()
                    ->select(['id', 'name'])
                    ->where(
                        fn($q) => $q->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhereHas('translation', fn($q1) => $q1->where('name', 'LIKE', "%{$searchTerm}%"))
                    );

                if (getMode() == 'freezone') {
                    $query->whereNotNull('freezone_id');
                }

                $response = $query->limit(6)->get();
                break;
            case 2:
                $response = Group::query()
                    ->select(['id', 'name'])
                    ->where('brand_id', $request->user()->brand_id)
                    ->where(
                        fn($q) => $q->where('name', 'LIKE', "%{$searchTerm}%")
                            ->orWhereHas('translation', fn($q1) => $q1->where('name', 'LIKE', "%{$searchTerm}%"))
                    )
                    ->limit(6)
                    ->get();
                break;
        }

        $processedItems = $response->map(function ($item) {
            return [
                'id' => encrypt($item->id),
                'name' => $item->toArray()['name']
            ];
        })->all();

        $data['items'] = $processedItems;
        return ApplicationService::responseFormat($data);
    }

    public function inboxPage()
    {
        $brand_id = \request()->user()->brand_id;
        $letters = DB::select('CALL mobile_letters_inbox(' . $brand_id . ' , ' . 1 . ')');

        if (isset($_GET['search'])) {
            $letters = array_filter($letters, function ($letter) {
                $search = $_GET['search'];
                $title = $letter->title;
                $name = $letter->name;
                $number = strval($letter->letter_id + 1000);
                if (!str_contains($title, $search) && !str_contains($name, $search) && !str_contains($number, $search)) {
                    return false;
                } else {
                    return true;
                }
            });
        }

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $letters = $this->paginate($letters, 15, $page);
        $letters = $letters->toArray();
        $data['letters'] = $letters['data'];
        $data['from'] = $letters['from'];
        $data['to'] = $letters['to'];
        $data['total'] = $letters['total'];
        $data['current_page'] = $letters['current_page'];
        $data['last_page'] = $letters['last_page'];

        $data['letters'] = array_map(function ($letter) {
            $letter = (array) $letter;
            $letter['number'] = 1000 + $letter['letter_id'];
            $letter['letter_id'] = encrypt($letter['letter_id']);
            $letter['created_at'] = jdate($letter['created_at'])->ago();
            return $letter;
        }, $data['letters']);
        $data['letters'] = array_values($data['letters']);

        return ApplicationService::responseFormat($data);
    }

    public function inboxPage2(Request $request)
    {
        $brand_id = $request->user()->brand_id;

        $letters = Letter::query()
            ->select('id', 'name', 'author_id', 'created_at')
            ->with([
                'translation:letter_id,name',
                'letter_brands:letter_id,brand_id,status,seen',
                'author' => fn($q) => $q->select('id', 'name', 'logo_path')
                    ->with('translation:brand_id,name'),
            ])
            ->whereHas(
                'letter_brands',
                fn($q) => $q->where([
                    ['brand_id', '=', $brand_id],
                    ['status', '=', 1]
                ])
            );

        if ($request->filled('search')) {
            $search = $request->get('search');
            $letters->where(
                fn($q) => $q->where(DB::raw('(id + 1000)'), 'LIKE', "%{$search}%")
                    ->orWhere('name', 'LIKE', "%{$search}%")
                    ->orWhereHas(
                        'translation',
                        fn($q) => $q->where('name', 'LIKE', "%{$search}%")
                    )
                    ->orWhereHas(
                        'author',
                        fn($q) => $q->where('name', 'LIKE', "%{$search}%")
                            ->orWhereHas(
                                'translation',
                                fn($q1) => $q1->where('name', 'LIKE', "%{$search}%")
                            )
                    )
            );
        }

        $letters = $letters
            ->latest('created_at')
            ->paginate(15);

        $items = $letters->items();
        $lettersResponse = [
            'letters' => array_map(
                fn($item) => [
                    'letter_id' => encrypt($item['id']),
                    'number' => 1000 + intval($item['id']),
                    'title' => $item['translation']['name'],
                    'name' => $item['author']['translation']['name'],
                    'seen' => $item['letter_brands'][0]['seen'],
                    //'created_at' => jdate($item['created_at'])->ago(),
                    'created_at' => Carbon::parse($item['created_at'])->diffForHumans(),
                    'logo' => $item['author']['logo_path'],
                ],
                $items
            ),
            'from' => $letters->firstItem(),
            'to' => $letters->lastItem(),
            'total' => $letters->total(),
            'current_page' => $letters->currentPage(),
            'last_page' => $letters->lastPage(),
        ];

        return ApplicationService::responseFormat($lettersResponse);
    }

    public function archivePage()
    {
        $brand_id = \request()->user()->brand->id;
        $letters = DB::select('CALL mobile_letters_inbox(' . $brand_id . ' , ' . 0 . ')');

        if (isset($_GET['search'])) {
            $letters = array_filter($letters, function ($letter) {
                $search = $_GET['search'];
                $title = $letter->title;
                $name = $letter->name;
                if (!str_contains($title, $search) && !str_contains($name, $search)) {
                    return false;
                } else {
                    return true;
                }
            });
        }

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $letters = $this->paginate($letters, 15, $page);
        $letters = $letters->toArray();
        $data['letters'] = $letters['data'];
        $data['from'] = $letters['from'];
        $data['to'] = $letters['to'];
        $data['total'] = $letters['total'];
        $data['current_page'] = $letters['current_page'];
        $data['last_page'] = $letters['last_page'];

        $data['letters'] = array_map(function ($letter) {
            $letter = (array) $letter;
            $letter['number'] = 1000 + $letter['letter_id'];
            $letter['letter_id'] = encrypt($letter['letter_id']);
            $letter['created_at'] = jdate($letter['created_at'])->ago();
            return $letter;
        }, $data['letters']);

        return ApplicationService::responseFormat($data);
    }

    public function outboxPage()
    {
        $brand_id = \request()->user()->brand->id;
        $letters = Letter::where('author_id', $brand_id);

        if (isset($_GET['search'])) {
            $letters = $letters->where('name', 'LIKE', '%' . $_GET['search'] . '%');
        }

        $letters = $letters->with(['brands'])->withCount('brands');
        $letters = $letters->latest()->get();
        $letters = $letters->map(function ($letter){
            if($letter->brands_count === 1){
                $brand = $letter->brands->first();
                $letter->logo = $brand->logo_path;
            }else{
                $letter->log = '';
            }
            unset($letter->brands);
            unset($letter->brands_count);
            return $letter;
        });

        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $letters = $this->paginate($letters, 15, $page);
        $letters = $letters->toArray();
        $data['letters'] = $letters['data'];
        $data['from'] = $letters['from'];
        $data['to'] = $letters['to'];
        $data['total'] = $letters['total'];
        $data['current_page'] = $letters['current_page'];
        $data['last_page'] = $letters['last_page'];

        $data['letters'] = array_map(function ($letter) {
            $letter = (array) $letter;
            $letter['number'] = 1000 + $letter['id'];
            $letter['id'] = encrypt($letter['id']);
            //$letter['created_at'] = jdate($letter['created_at'])->ago();
            $letter['created_at'] = Carbon::parse($letter['created_at'])->diffForHumans();
            return $letter;
        }, $data['letters']);
        $data['letters'] = array_values($data['letters']);

        return ApplicationService::responseFormat($data);
    }

    public function createPage()
    {
        $groups = Group::where('brand_id', auth()->user()->brand->id)->get(['id', 'name']);
        $groups = $groups ? $groups->toArray() : null;
        $groups = array_map(function ($group) {
            return [
                'id' => encrypt($group['id']),
                'name' => $group['name']
            ];
        }, $groups);
        $data['groups'] = $groups;
        return ApplicationService::responseFormat($data);
    }

    public function send(ASSendRequest $request)
    {
        $letter = new Letter;
        $letter->author_id = \request()->user()->brand_id;
        $letter->content = nl2br(e($request->input('content')));
        $letter->name = $request->input('subject');
        $letter->save();

        if ($request->file('attachment')) {
            $path = AttachmentRepositories::put($request->file('attachment'));
            DB::table('letter_attachments')->insert([
                'letter_id' => $letter->id,
                'attachment' => $path
            ]);
        }

        if (\request()->user()->signature) {
            DB::table('letter_signatures')->insert([
                'letter_id' => $letter->id,
                'signature' => \request()->user()->signature->signature
            ]);
        }

        if ($request->input('reciver_type') == 1) {
            $brand = Brand::find(decrypt($request->input('reciver_id')));
            if ($brand) {
                $name = $brand->name;
                $letter->reciver_name = $name;
                DB::table('letter_brands')->insert(['letter_id' => $letter->id, 'brand_id' => $brand->id]);
                $id = $brand->id;
                $phones = array_column(DB::select("CALL `brand_automation_system_notification`({$id})"), 'phone');
                foreach ($phones as $phone) {
                    SMSPattern::sendMail($phone, \request()->user()->brand->name, $letter->name);
                }
                $content = __('messages.letter_received_from', ['brand' => \request()->user()->brand->name]);
                $firebaseService = new FirebaseService();
                $firebaseService->sendLetterNotificationToUsers($brand, $content);
                $letter->save();
            }
        } else {
            $group = Group::find(decrypt($request->input('reciver_id')));
            foreach ($group->brands as $key => $brand) {
                DB::table('letter_brands')->insert(['letter_id' => $letter->id, 'brand_id' => $brand->id]);
                $id = $brand->id;
                $phones = array_column(DB::select("CALL `brand_automation_system_notification`({$id})"), 'phone');
                foreach ($phones as $phone) {
                    SMSPattern::sendMail($phone, \request()->user()->brand->name, $letter->name);
                }
                $content = __('messages.letter_received_from', ['brand' => \request()->user()->brand->name]);
                $firebaseService = new FirebaseService();
                $firebaseService->sendLetterNotificationToUsers($brand, $content);
            }
            $letter->group_name = $group->name;
            $letter->save();
        }

        return ApplicationService::responseFormat([], true, __('messages.letter_sent_successfully'));
    }

    public function show(Request $request)
    {
        if (!$request->input('type') || !$request->input('id')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $id = $request->input('id');
        $type = $request->input('type');
        $id = decrypt($id);

        if ($type == 'reciver') {
            $connection = DB::table('letter_brands')->where(['brand_id' => \request()->user()->brand_id, 'letter_id' => $id])->first();
            if ($connection !== null) {
                if (!$connection->seen) {
                    DB::table('letter_brands')->where('letter_id', $id)->where('brand_id', \request()->user()->brand_id)->update(['seen' => 1]);
                }
                $letter = Letter::findOrFail($id);
                $letter = array_intersect_key($letter->toArray(), array_flip(['id', 'author_id', 'content', 'is_government', 'created_at', 'name', 'author_name']));
                $letter['created_at'] = jdate(Carbon::createFromTimeString($letter['created_at'])->format('Y-m-d H:i:s'))->format('Y/m/d H:i');
                $brand = Brand::where('id', $letter['author_id'])->first(['id', 'name', 'slug', 'logo_path'])->toArray();
                unset($letter['author_id']);
                $signature = DB::table('letter_signatures')->where('letter_id', $letter['id'])->first(['signature']);
                $signature = $signature ? ((array) $signature)['signature'] : null;
                $letter['number'] = strval($letter['id'] + 1000);
                $letter['id'] = encrypt($letter['id']);
                $image = $signature ?  storage_path('app/' . $signature) : null;
                if ($image && file_exists($image)) {
                    $base64 = base64_encode(file_get_contents($image));
                    $signature = $base64;
                } else {
                    $signature = '';
                }
                $is_attach = DB::table('letter_attachments')->where(['letter_id' => $id])->first() ? true : false;
                $reciver_name = auth('sanctum')->user();
                if($reciver_name->brand){
                    $reciver_name = $reciver_name->brand->name;
                }else{
                    $reciver_name = '...';
                }
                $data = [
                    'type' => $type,
                    'letter' => $letter,
                    'signature' => $signature,
                    'brand' => $brand,
                    'is_attach' => $is_attach,
                    'revicer_name' => $reciver_name
                ];
                $data['brand']['id'] = encrypt($data['brand']['id']);
                return ApplicationService::responseFormat($data);
            } else {
                abort(404);
            }
        } else if ($type == 'sended') {
            $letter = Letter::findOrFail($id, ['id', 'author_id', 'is_government', 'created_at', 'reciver_name', 'group_name', 'content', 'author_name', 'name']);
            if ($letter->author_id == \request()->user()->brand_id) {
                $brand = Brand::findOrFail($letter->author_id, ['id', 'name', 'slug', 'logo_path']);
                $signature = $letter->signature();
                $image = $signature ?  storage_path('app/' . $signature) : null;
                if ($image && file_exists($image)) {
                    $base64 = base64_encode(file_get_contents($image));
                    $signature = $base64;
                } else {
                    $signature = '';
                }
                $is_attach = DB::table('letter_attachments')->where(['letter_id' => $id])->first() ? true : false;
                $letter->created_at = jdate($letter->created_at);
                $data = [
                    'type' => $type,
                    'letter' => $letter->toArray(),
                    'signature' => $signature,
                    'brand' => $brand->toArray(),
                    'is_attach' => $is_attach
                ];
                $data['letter']['created_at'] = $letter->created_at->format('Y/m/d H:i');
                $data['letter']['number'] = $data['letter']['id'] + 1000;
                $data['letter']['id'] = encrypt($data['letter']['id']);
                $data['brand']['id'] = encrypt($data['brand']['id']);
                unset($data['letter']['author_id']);
                return ApplicationService::responseFormat($data);
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function attach(Request $request)
    {
        if (!$request->input('type') || !$request->input('id')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $id = $request->input('id');
        $type = $request->input('type');
        $id = decrypt($id);
        $letter = Letter::findOrFail($id);
        $attach = DB::table('letter_attachments')->where(['letter_id' => $id])->first();

        if (!$attach) {
            return ApplicationService::responseFormat([], false, __('messages.letter_has_no_attachment'), -2);
        }

        if ($type == 'reciver') {
            $connection = DB::table('letter_brands')->where(['brand_id' => \request()->user()->brand_id, 'letter_id' => $id])->first();
            if ($connection !== null) {
                $path = $attach->attachment;
                return Storage::download($path);
            } else {
                return ApplicationService::responseFormat([], false, __('messages.no_access_to_file'), -3);
            }
        } else if ($type == 'sended') {
            if ($letter->author_id == \request()->user()->brand_id) {
                $path = $attach->attachment;
                return Storage::download($path);
            }
        }
    }

    public function archive(Request $request)
    {
        if (!$request->input('type') || !$request->input('id')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $id = $request->input('id');
        $type = $request->input('type');
        $id = decrypt($id);
        $relation = DB::table('letter_brands')->where(['letter_id' => $id, 'brand_id' => \request()->user()->brand_id])->first();

        if ($relation) {
            DB::table('letter_brands')->where(['letter_id' => $id, 'brand_id' => \request()->user()->brand_id])->update(['status' => !$relation->status]);
            return ApplicationService::responseFormat([], true, $relation->status ? __('messages.letter_archived') : __('messages.letter_unarchived'));
        } else {
            return ApplicationService::responseFormat([], false, __('messages.letter_not_found'), -2);
        }
    }

    public function print(Request $request)
    {
        if (!$request->input('type') || !$request->input('id')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $id = $request->input('id');
        $type = $request->input('type');
        $id = decrypt($id);

        if ($type == 'reciver') {
            $connection = DB::table('letter_brands')->where(['brand_id' => \request()->user()->brand_id, 'letter_id' => $id])->first();
            if ($connection !== null) {
                if (!$connection->seen) {
                    DB::table('letter_brands')->where('letter_id', $id)->where('brand_id', \request()->user()->brand_id)->update(['seen' => 1]);
                }
                $letter = Letter::findOrFail($id);
                $brand = $letter->author;
                $signature = $letter->signature();
                $image = $signature ?  storage_path('app/' . $signature) : null;
                if ($image && file_exists($image)) {
                    $base64 = base64_encode(file_get_contents($image));
                    $base64 = 'data:image/png;base64,' . $base64;
                    $signature = $base64;
                } else {
                    $signature = '';
                }
                $myLogo = $letter->author->logo_path ? $letter->author->logo_path : null;
                if ($myLogo) {
                    if (file_exists($myLogo)) {
                        $imageData  = file_get_contents($myLogo);
                        $imageType = mime_content_type($myLogo);
                        $base64 = base64_encode($imageData);
                        $myLogo = 'data:' . $imageType . ';base64,' . $base64;
                    } else {
                        $myLogo = '';
                    }
                } else {
                    $myLogo = '#';
                }
                $number = $letter->id + 1000;
                $date = jdate($letter->created_at)->format('y/m/d');
                $brandName = $brand->name;
                $subject = $letter->name;
                $content = $letter->content;
                $reciverName = $letter->reciver_name;
                ini_set("pcre.backtrack_limit", "5000000");
                if(getMode() == 'freezone'){
                    $pdf = Pdf::loadView('panel.automationsystem.freezoneInvoice', compact(['myLogo', 'number', 'date', 'brandName', 'subject', 'signature', 'content', 'reciverName']));
                }else{
                    $pdf = Pdf::loadView('panel.automationsystem.invoice', compact(['myLogo', 'number', 'date', 'brandName', 'subject', 'signature', 'content', 'reciverName']));
                }
                return $pdf->stream('report.pdf');
            } else {
                abort(404);
            }
        } else if ($type == 'sended') {
            $letter = Letter::findOrFail($id);
            if ($letter->author_id == Auth::user()->brand_id) {
                $brand = $letter->author;
                $brandName = $brand->name;
                $signature = $letter->signature();
                $image = $signature ?  storage_path('app/' . $signature) : null;
                if ($image && file_exists($image)) {
                    $base64 = base64_encode(file_get_contents($image));
                    $base64 = 'data:image/png;base64,' . $base64;
                    $signature = $base64;
                } else {
                    $signature = '';
                }
                $myLogo = $letter->author->logo_path ? $letter->author->logo_path : null;
                if ($myLogo) {
                    if (file_exists($myLogo)) {
                        $imageData  = file_get_contents($myLogo);
                        $imageType = mime_content_type($myLogo);
                        $base64 = base64_encode($imageData);
                        $myLogo = 'data:' . $imageType . ';base64,' . $base64;
                    } else {
                        $myLogo = '';
                    }
                } else {
                    $myLogo = '#';
                }
                $subject = $letter->name;
                $number = $letter->id + 1000;
                $date = jdate($letter->created_at)->format('y/m/d');
                $content = $letter->content;
                $reciverName = $letter->reciver_name;
                ini_set("pcre.backtrack_limit", "5000000");
                if(getMode() == 'freezone'){
                    $pdf = Pdf::loadView('panel.automationsystem.freezoneInvoice', compact(['myLogo', 'content', 'number', 'date', 'subject', 'brandName', 'type', 'letter', 'signature', 'brand', 'reciverName']));
                }else{
                    $pdf = Pdf::loadView('panel.automationsystem.invoice', compact(['myLogo', 'content', 'number', 'date', 'subject', 'brandName', 'type', 'letter', 'signature', 'brand', 'reciverName']));
                }
                return $pdf->stream('report.pdf');
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function settingPage()
    {
        $user = \request()->user();
        $signature = SignatureRepositories::getBase64($user->id);
        $data['signature'] = $signature;
        return ApplicationService::responseFormat($data);
    }

    public function setting(Request $request)
    {
        $user = \request()->user();

        $messages = [
            'signature.required' => __('messages.signature_required'),
            'signature.max' => __('messages.signature_max'),
            'signature.mimes' => __('messages.signature_mimes'),
        ];

        $request->validate([
            'signature' => 'required|max:512|mimes:png,jpg,jpeg'
        ], $messages);

        $extension = $request->file('signature')->getClientOriginalExtension();
        $image = null;
        switch ($extension) {
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($request->file('signature'));
                break;
            case 'gif':
                $image = imagecreatefromgif($request->file('signature'));
                break;
            case 'png':
                $image = imagecreatefrompng($request->file('signature'));
                imagealphablending($image, false);
                imagesavealpha($image, true);
                break;
        }

        if ($image) {
            $imageName = 'signature-' . $user->id . '-' . time() . '.png';
            $outputPath = storage_path('app/signatures/' . $imageName);
            imagepng($image, $outputPath);
            imagedestroy($image);

            $sig = Signature::where('user_id', Auth::user()->id)->first();
            if ($sig) {
                $sig->signature = 'signatures/' . $imageName;
                $sig->save();
            } else {
                $sig = Signature::create([
                    'user_id' => Auth::user()->id,
                    'signature' => 'signatures/' . $imageName
                ]);
            }
            $data['signature'] = base64_encode(file_get_contents($outputPath));
            return ApplicationService::responseFormat($data, true, __('messages.signature_changed'));
        } else {
            return ApplicationService::responseFormat([], false, __('messages.signature_not_changed'));
        }
    }

    public function groupsPage()
    {
        $groups = Group::where('brand_id', \request()->user()->brand_id)->latest()->select(['id', 'name'])->get();
        if ($groups) {
            $groups = $groups->toArray();
            $groups = array_map(function ($group) {
                $group['id'] = encrypt($group['id']);
                return $group;
            }, $groups);
        } else {
            $groups = null;
        }
        $data = [
            'groups' => $groups
        ];
        return ApplicationService::responseFormat($data);
    }

    public function groupStore(Request $request)
    {
        if (!$request->input('name')) {
            return ApplicationService::responseFormat([], false, __('messages.group_name_required'), -1);
        }

        if (strlen($request->input('name')) > 50) {
            return ApplicationService::responseFormat([], false, __('messages.group_name_max_50'), -1);
        }

        $group = Group::create([
            'brand_id' => \request()->user()->brand_id,
            'name' => $request->input('name')
        ]);

        $data = [
            'group' => [
                'id' => encrypt($group->id),
                'name' => $group->name,
            ],
        ];

        return ApplicationService::responseFormat($data, true, __('messages.group_created'));
    }

    public function groupShow(Request $request)
    {
        if (!$request->input('id')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $id = $request->input('id');
        $group = Group::findOrFail(decrypt($id));

        if (\request()->user()->brand_id != $group->brand_id) {
            return ApplicationService::responseFormat([], false, __('messages.access_denied'), -2);
        }

        $brands = $group->brands;
        if ($brands) {
            $brands = array_map(function ($brand) {
                $result = [
                    'id' => encrypt($brand['id']),
                    'name' => $brand['name'],
                    'logo_path' => $brand['logo_path'],
                ];
                return $result;
            }, $brands->toArray());
        }

        $data = [
            'brands' => $brands,
            'group' => [
                'id' => encrypt($group->id),
                'name' => $group->name,
            ],
        ];

        return ApplicationService::responseFormat($data);
    }

    public function addBrandToGroup(Request $request)
    {
        if (!$request->input('group_id') || !$request->input('brand_id')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $group = Group::findOrFail(decrypt($request->input('group_id')));
        if (!$group) {
            return ApplicationService::responseFormat([], false, __('messages.group_not_found'), -2);
        }

        $brand = Brand::findOrFail(decrypt($request->input('brand_id')));
        if (!$brand) {
            return ApplicationService::responseFormat([], false, __('messages.brand_not_found'), -3);
        }

        if (\request()->user()->brand_id != $group->brand_id) {
            return ApplicationService::responseFormat([], false, __('messages.no_permission'), -4);
        }

        $test = $group->brands;
        if ($test) {
            $test = $test->toArray();
            $test = array_column($test, 'id');
            if (in_array($brand->id, $test)) {
                return ApplicationService::responseFormat([], false, __('messages.brand_already_member'), -5);
            }
        }

        try {
            GroupBrands::create([
                'group_id' => $group->id,
                'brand_id' => $brand->id
            ]);

            $data = [
                'brand' => [
                    'id' => encrypt($brand->id),
                    'name' => $brand->name,
                    'logo_path' => $brand->logo_path,
                ],
                'group' => [
                    'id' => encrypt($group->id),
                    'name' => $group->name
                ]
            ];

            return ApplicationService::responseFormat($data, true, __('messages.brand_added'));
        } catch (\Exception $e) {
            return ApplicationService::responseFormat([], false, $e, -5);
        }
    }

    public function removeBrandFromGroup(Request $request)
    {
        if (!$request->input('group_id') || !$request->input('brand_id')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $group = Group::findOrFail(decrypt($request->input('group_id')));
        if (!$group) {
            return ApplicationService::responseFormat([], false, __('messages.group_not_found'), -2);
        }

        $brand = Brand::findOrFail(decrypt($request->input('brand_id')));

        DB::table('group_brands')->where(['brand_id' => $brand->id, 'group_id' => $group->id])->delete();

        $data = [
            'brand' => [
                'id' => encrypt($brand->id),
                'name' => $brand->name,
                'logo_path' => $brand->logo_path,
            ],
            'group' => [
                'id' => encrypt($group->id),
                'name' => $group->name
            ]
        ];

        return ApplicationService::responseFormat($data, true, __('messages.brand_removed'));
    }

    public function destroyGroup(Request $request)
    {
        if (!$request->input('group_id')) {
            return ApplicationService::responseFormat([], false, __('messages.invalid_form'), -1);
        }

        $group = Group::find(decrypt($request->input('group_id')));
        if (!$group) {
            return ApplicationService::responseFormat([], false, __('messages.group_not_found'), -2);
        }

        if (\request()->user()->brand_id != $group->brand_id) {
            return ApplicationService::responseFormat([], false, __('messages.access_denied'), -3);
        }

        DB::table('group_brands')->where('group_id', $group->id)->delete();
        $group->delete();

        return ApplicationService::responseFormat([], true, __('messages.group_deleted'));
    }

    public function bulkPage()
    {
        $provinces = Province::all(['id', 'name']);
        $categories = Category::where('parent_id', null)->get(['id', 'name']);
        $data = [
            'provinces' => $provinces,
            'categories' => $categories,
        ];
        return ApplicationService::responseFormat($data);
    }

    public function bulkAction(BulkRequest $request)
    {
        $letter = new Letter;
        $letter->author_id = \request()->user()->brand_id;
        $letter->content = $request->input('content');
        $letter->name = $request->input('subject');
        $letter->reciver_name = $request->input('reciver_name');
        $letter->save();

        if ($request->file('attachment')) {
            $path = AttachmentRepositories::put($request->file('attachment'));
            DB::table('letter_attachments')->insert([
                'letter_id' => $letter->id,
                'attachment' => $path
            ]);
        }

        if (\request()->user()->signature) {
            DB::table('letter_signatures')->insert([
                'letter_id' => $letter->id,
                'signature' => \request()->user()->signature->signature
            ]);
        }

        $group = Brand::query();
        if ($request->input('province_id') && $request->input('province_id') != 0) {
            $group = $group->where('province_id', $request->input('province_id'));
        }
        if ($request->input('city_id') && $request->input('city_id') != 0) {
            $group = $group->where('city_id', $request->input('city_id'));
        }
        if ($request->input('ipark_id') && $request->input('ipark_id') != 0) {
            $group = $group->where('ipark_id', $request->input('ipark_id'));
        }
        if ($request->input('category_id') && $request->input('category_id') != 0) {
            $group = $group->where('category_id', $request->input('category_id'));
        }
        $group = $group->get();

        foreach ($group as $key => $brand) {
            DB::table('letter_brands')->insert(['letter_id' => $letter->id, 'brand_id' => $brand->id]);
            $id = $brand->id;
            $phones = array_column(DB::select("CALL `brand_automation_system_notification`({$id})"), 'phone');
            foreach ($phones as $phone) {
                SMSPattern::sendMail($phone, \request()->user()->brand->name, $letter->name);
            }
            $content = __('messages.letter_received_from', ['brand' => \request()->user()->brand->name]);
            $firebaseService = new FirebaseService();
            $firebaseService->sendLetterNotificationToUsers($brand, $content);
        }

        $letter->is_government = true;
        $letter->group_name = __('messages.bulk_sending');
        $letter->save();

        return ApplicationService::responseFormat([], true, __('messages.letter_sent'));
    }

    public function deleteSignature()
    {
        $signature =  DB::table('user_signature')->where('user_id', \request()->user()->id)->delete();
        return ApplicationService::responseFormat([], true, __('messages.signature_deleted'));
    }

    public function sendToOrganization(ASSendOrganizationRequest $request)
    {
        $letter = new Letter;
        $letter->author_id = \request()->user()->brand_id;
        $letter->content = nl2br(e($request->input('content')));
        $letter->name = $request->input('subject');
        $letter->save();

        if ($request->file('attachment')) {
            $path = AttachmentRepositories::put($request->file('attachment'));
            DB::table('letter_attachments')->insert([
                'letter_id' => $letter->id,
                'attachment' => $path
            ]);
        }

        if (\request()->user()->signature) {
            DB::table('letter_signatures')->insert([
                'letter_id' => $letter->id,
                'signature' => \request()->user()->signature->signature
            ]);
        }

        $brand = Brand::find($request->input('reciver_id'));
        if ($brand) {
            $name = $brand->name;
            $letter->reciver_name = $name;
            DB::table('letter_brands')->insert(['letter_id' => $letter->id, 'brand_id' => $brand->id]);
            $id = $brand->id;
            $phones = array_column(DB::select("CALL `brand_automation_system_notification`({$id})"), 'phone');
            foreach ($phones as $phone) {
                SMSPattern::sendMail($phone, \request()->user()->brand->name, $letter->name);
            }
            $content = __('messages.letter_received_from', ['brand' => \request()->user()->brand->name]);
            $firebaseService = new FirebaseService();
            $firebaseService->sendLetterNotificationToUsers($brand, $content);
            $letter->save();
        }

        return ApplicationService::responseFormat([], true, __('messages.letter_sent_successfully'));
    }
}
