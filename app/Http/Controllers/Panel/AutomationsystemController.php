<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\MobileLetterRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Group;
use App\Models\GroupBrands;
use App\Models\Letter;
use App\Models\Province;
use App\Repositories\AttachmentRepositories;
use App\Repositories\SignatureRepositories;
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

class AutomationsystemController extends Controller
{

    public function paginate($items, $perPage = 5, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    public function search(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'search' => 'required'
        ]);
        $response = [];
        switch ($request->input('type')) {
            case 1:
                $response = DB::table('brands')->select(['id', 'name'])->where('name', 'LIKE', "%{$request->input('search')}%")->limit(6)->get();
                break;
            case 2:
                $response = DB::table('groups')->select(['id', 'name'])->where('brand_id', Auth::user()->brand->id)->where('name', 'LIKE', "%{$request->input('search')}%")->limit(6)->get();
                break;
        }
        return response()->json($response);
    }

    public function inboxPage()
    {
        $brand_id = auth()->user()->brand->id;
        $letters = DB::select('CALL mobile_letters_inbox(' . $brand_id . ' , ' . 1 . ')');
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
        $data = $letters->toArray();
        $from = $data['from'];
        $to = $data['to'];
        $total = $data['total'];
        $current_page = $data['current_page'];
        $last_page = $data['last_page'];
        return view('panel.automationsystem.inbox', compact(['letters', 'from', 'to', 'total', 'current_page', 'last_page']));
    }

    public function archivePage()
    {
        $brand_id = auth()->user()->brand->id;
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
        $data = $letters->toArray();
        $from = $data['from'];
        $to = $data['to'];
        $total = $data['total'];
        $current_page = $data['current_page'];
        $last_page = $data['last_page'];
        return view('panel.automationsystem.archive', compact(['letters', 'from', 'to', 'total', 'current_page', 'last_page']));
    }

    public function outboxPage()
    {
        $brand_id = auth()->user()->brand->id;
        $letters = Letter::where('author_id', $brand_id);
        if (isset($_GET['search'])) {
            $letters = $letters->where('name', 'LIKE', '%' . $_GET['search'] . '%');
        }
        $letters = $letters->latest()->get();
        $page = isset($_GET['page']) ? $_GET['page'] : 1;
        $letters = $this->paginate($letters, 15, $page);
        $data = $letters->toArray();
        $from = $data['from'];
        $to = $data['to'];
        $total = $data['total'];
        $current_page = $data['current_page'];
        $last_page = $data['last_page'];
        return view('panel.automationsystem.outbox', compact(['letters', 'from', 'to', 'total', 'current_page', 'last_page']));
    }

    public function createPage()
    {
        $groups = Group::where('brand_id', auth()->user()->brand->id)->get();
        return view('panel.automationsystem.create', compact(['groups']));
    }

    public function send(MobileLetterRequest $request)
    {
        $letter = new Letter;
        $letter->author_id = auth()->user()->brand->id;
        $letter->content = $request->input('content');
        $letter->name = $request->input('subject');
        $letter->reciver_name = $request->input('reciver_name');
        $letter->save();
        // dd($letter);

        if ($request->file('attachment')) {
            $path = AttachmentRepositories::put($request->file('attachment'));
            DB::table('letter_attachments')->insert([
                'letter_id' => $letter->id,
                'attachment' => $path
            ]);
        }
        if (Auth::user()->signature) {
            DB::table('letter_signatures')->insert([
                'letter_id' => $letter->id,
                'signature' => Auth::user()->signature->signature
            ]);
        }
        if ($request->input('reciver_type') == 1) {
            $brand = Brand::find($request->input('reciver_id'));
            if ($brand) {
                $name = $brand->name;
                $letter->reciver_name = $name;
                DB::table('letter_brands')->insert(['letter_id' => $letter->id, 'brand_id' => $brand->id]);
                $id = $brand->id;
                $phones = array_column(DB::select("CALL `brand_automation_system_notification`({$id})"), 'phone');
                foreach ($phones as $phone) {
                    // SMSPattern::sendMail($phone);
                }

                $content = "نامه ای از " . \request()->user()->brand->name . " دریافت شد.";

                $firebaseService = new FirebaseService();
                $firebaseService->sendLetterNotificationToUsers($brand, $content);

                $letter->save();
            }
        } else {
            $group = Group::find($request->input('reciver_id'));
            foreach ($group->brands as $key => $brand) {
                DB::table('letter_brands')->insert(['letter_id' => $letter->id, 'brand_id' => $brand->id]);
                $id = $brand->id;
                $phones = array_column(DB::select("CALL `brand_automation_system_notification`({$id})"), 'phone');
                foreach ($phones as $phone) {
                    // SMSPattern::sendMail($phone);
                }

                $content = "نامه ای از " . \request()->user()->brand->name . " دریافت شد.";

                $firebaseService = new FirebaseService();
                $firebaseService->sendLetterNotificationToUsers($brand, $content);
            }
            $letter->group_name = $group->name;
            $letter->save();
        }
        return redirect()->route('automationSystem.outboxpage');
    }

    public function show(string $type, string $id)
    {
        $id = decrypt($id);
        if ($type == 'reciver') {
            $connection = DB::table('letter_brands')->where(['brand_id' => auth()->user()->brand->id, 'letter_id' => $id])->first();
            if ($connection !== null) {
                if (!$connection->seen) {
                    DB::table('letter_brands')->where('letter_id', $id)->where('brand_id', auth()->user()->brand->id)->update(['seen' => 1]);
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
                $is_attach = DB::table('letter_attachments')->where(['letter_id' => $id])->first() ? true : false;
                return view('panel.automationsystem.show', compact(['type', 'letter', 'signature', 'brand', 'is_attach']));
            } else {
                abort(404);
            }
        } else if ($type == 'sended') {
            $letter = Letter::findOrFail($id);
            if ($letter->author_id == Auth::user()->brand_id) {
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
                $is_attach = DB::table('letter_attachments')->where(['letter_id' => $id])->first() ? true : false;
                return view('panel.automationsystem.show', compact(['type', 'letter', 'signature', 'brand', 'is_attach']));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function attach(string $type, string $id)
    {
        $id = decrypt($id);
        $letter = Letter::findOrFail($id);
        $attach = DB::table('letter_attachments')->where(['letter_id' => $id])->first();
        if (!$attach) {
            abort(404);
        }
        if ($type == 'reciver') {
            $connection = DB::table('letter_brands')->where(['brand_id' => auth()->user()->brand->id, 'letter_id' => $id])->first();
            if ($connection !== null) {
                $path = $attach->attachment;
                return Storage::download($path);
            }
        } else if ($type == 'sended') {
            if ($letter->author_id == Auth::user()->brand_id) {
                $path = $attach->attachment;
                return Storage::download($path);
            }
        }

        abort(404);
    }

    public function archive(string $type, string $id)
    {
        $id = decrypt($id);
        $relation = DB::table('letter_brands')->where(['letter_id' => $id, 'brand_id' => Auth::user()->brand->id])->first();
        if ($relation) {
            DB::table('letter_brands')->where(['letter_id' => $id, 'brand_id' => Auth::user()->brand->id])->update(['status' => !$relation->status]);
            return back();
        } else {
            return back();
        }
    }

    public function print(string $type, string $id)
    {
        $id = decrypt($id);
        if ($type == 'reciver') {
            $connection = DB::table('letter_brands')->where(['brand_id' => auth()->user()->brand->id, 'letter_id' => $id])->first();
            if ($connection !== null) {
                if (!$connection->seen) {
                    DB::table('letter_brands')->where('letter_id', $id)->where('brand_id', auth()->user()->brand->id)->update(['seen' => 1]);
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
                    // $myLogo = public_path($myLogo);
                    if (file_exists($myLogo)) {
                        $myLogo = file_get_contents($myLogo);
                        $myLogo = base64_encode($myLogo);
                        $myLogo = 'data:image/png;base64,' . $myLogo;
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
                ini_set("pcre.backtrack_limit", "5000000");
                $pdf = Pdf::loadView('panel.automationsystem.invoice', compact(['myLogo', 'number', 'date', 'brandName', 'subject', 'signature', 'content']));
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
                    // $myLogo = public_path($myLogo);
                    if (file_exists($myLogo)) {
                        $myLogo = file_get_contents($myLogo);
                        $myLogo = base64_encode($myLogo);
                        $myLogo = 'data:image/png;base64,' . $myLogo;
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
                ini_set("pcre.backtrack_limit", "5000000");
                $pdf = Pdf::loadView('panel.automationsystem.invoice', compact(['myLogo' , 'content' , 'number' ,'date' , 'subject','brandName','type', 'letter', 'signature', 'brand']));
                return $pdf->stream('report.pdf');
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function settingpage()
    {
        return view('panel.automationsystem.setting');
    }

    public function setting(Request $request)
    {
        $request->validate([
            'signature' => 'required|max:512|mimes:png'
        ]);
        $path = SignatureRepositories::put($request->file('signature'));
        $connection = DB::table('user_signature')->where(['user_id' => Auth::user()->id])->get();
        if ($connection) {
            DB::table('user_signature')->where('user_id', Auth::user()->id)->update(['signature' => $path]);
        } else {
            DB::table('user_signature')->insert(['user_id' => Auth::user()->id, 'signature' => $path, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }
        return back()->with('success', 'امضا تغییر کرد');
    }

    public function groupsPage()
    {
        $groups = Group::where('brand_id', auth()->user()->brand->id)->latest()->select(['id', 'name'])->get();
        return view('panel.automationsystem.groups', compact(['groups']));
    }

    public function groupCreatePage()
    {
        return view('panel.automationsystem.groupsCreate');
    }

    public function groupStore(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50'
        ]);
        $group = Group::create([
            'brand_id' => auth()->user()->brand->id,
            'name' => $request->input('name')
        ]);
        return redirect()->route('automationSystem.groupShow', ['id' => encrypt($group->id)]);
    }

    public function groupShow(string $id)
    {
        $group = Group::findOrFail(decrypt($id));
        if (Auth::user()->brand->id != $group->brand_id) {
            abort(404);
        }
        $brands = $group->brands;
        return view('panel.automationsystem.group', compact(['group', 'brands']));
    }

    public function addBrandToGroup(Request $request)
    {
        $request->validate([
            'id' => ['required'],
            'reciver_id' => ['required'],
        ]);
        $group = Group::findOrFail(decrypt($request->input('id')));
        $brand = Brand::findOrFail($request->input('reciver_id'));
        if (Auth::user()->brand->id != $group->brand_id || !$group) {
            abort(419);
        }
        if (!$brand) {
            abort(419);
        }
        try {
            GroupBrands::create([
                'group_id' => $group->id,
                'brand_id' => $brand->id
            ]);
        } catch (\Exception $e) {
            abort(419);
        }
        return back();
    }

    public function removeBrandFromGroup(Request $request)
    {
        $request->validate([
            'brand_id' => 'required',
            'group_id' => 'required'
        ]);
        $group = Group::find(decrypt($request->input('group_id')));
        $brand = Brand::find(decrypt($request->input('brand_id')));
        DB::table('group_brands')->where(['brand_id' => $brand->id, 'group_id' => $group->id])->delete();
        return back();
    }

    public function destroyGroup(Request $request)
    {
        $request->validate([
            'group_id' => 'required'
        ]);
        $group = Group::findOrFail(decrypt($request->input('group_id')));
        if (Auth::user()->brand->id != $group->brand_id) {
            abort(404);
        }
        DB::table('group_brands')->where('group_id', $group->id)->delete();
        $group->delete();
        return back();
    }

    public function bulkPage()
    {
        $provinces = Province::all(['id', 'name']);
        $categories = Category::where('parent_id', null)->get(['id', 'name']);
        return view('panel.automationsystem.bulk', compact(['provinces', 'categories']));
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            "attachment" => 'max:1024|mimes:jpg,png,pdf|nullable',
            "subject" => 'required|max:250',
            "content" => 'required'
        ]);

        $letter = new Letter;
        $letter->author_id = auth()->user()->brand->id;
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
        if (Auth::user()->signature) {
            DB::table('letter_signatures')->insert([
                'letter_id' => $letter->id,
                'signature' => Auth::user()->signature->signature
            ]);
        }

        $group = Brand::query();
        if($request->input('province_id') && $request->input('province_id')!=0){
            $group = $group->where('province_id', $request->input('province_id'));
        }
        if($request->input('city_id') && $request->input('city_id')!=0){
            $group = $group->where('city_id', $request->input('city_id'));
        }
        if($request->input('ipark_id') && $request->input('ipark_id')!=0){
            $group = $group->where('ipark_id', $request->input('ipark_id'));
        }
        if($request->input('category_id') && $request->input('category_id')!=0){
            $group = $group->where('category_id', $request->input('category_id'));
        }
        $group = $group->get();
        foreach ($group as $key => $brand) {
            DB::table('letter_brands')->insert(['letter_id' => $letter->id, 'brand_id' => $brand->id]);
            $id = $brand->id;
            $phones = array_column(DB::select("CALL `brand_automation_system_notification`({$id})"), 'phone');
            foreach ($phones as $phone) {
                // SMSPattern::sendMail($phone);
            }

            $content = "نامه ای از " . \request()->user()->brand->name . " دریافت شد.";

            $firebaseService = new FirebaseService();
            $firebaseService->sendLetterNotificationToUsers($brand, $content);
        }
        $letter->group_name = 'ارسال انبوه';
        $letter->save();
        return redirect()->route('automationSystem.outboxpage');
    }
}
