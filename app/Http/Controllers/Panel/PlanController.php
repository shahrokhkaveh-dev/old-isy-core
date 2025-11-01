<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\sendBrandInformationRequest;
use App\Models\Brand;
use App\Models\Document;
use App\Models\Plan\Payment;
use App\Models\Plan\Plan;
use App\Models\User;
use App\Services\Gateway\Parsian;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('panel.plan.index', compact(['plans']));
    }

    public function buy(Request $request)
    {
        $request->validate([
            'plan_id' => 'required'
        ]);
        $plan = Plan::find($request->input('plan_id'));
        $brand = auth()->user()->brand;
        $payment = Payment::create([
            'plan_id' => $plan->id,
            'brand_id' => $brand->id,
            'amount' => $plan->price
        ]);
        Parsian::plan($payment);
    }

    public function callback(Request $request)
    {
        $inputs = $request->all();

        if ($inputs['status'] == 0 && $inputs['Token']) {
            $payment = Payment::find($inputs['OrderId']);
            $payment->status = 1;
            $payment->refrence_code = $inputs['RRN'];
            $payment->save();
            $brand = Brand::find($payment->brand_id);
            $plan = Plan::find($payment->plan_id);
            $brand->vip_expired_time = Carbon::now()->addMonth($plan->period);
            $brand->plan_id = $plan->id;
            $brand->plan_name = $plan->name;
            $brand->save();
            $users = User::where('brand_id', $brand->id)->get();
            foreach ($users as $user) {
                if ($user->status == 1) {
                    $user->update(['status' => 2]);
                }
            }
            return view('paymentStatus.success');
        }
        return view('paymentStatus.failed');
    }

    public function status(sendBrandInformationRequest $request)
    {
        $inputs = $request->all();
        $user = Auth::user();
        $brand = $user->brand;
        $brand->update([
            'name' => $inputs['company_name'],
            'nationality_code' => $inputs['company_code'],
            'register_code' => $inputs['company_register'],
            'post_code' => $inputs['company_postCode'],
            'phone_number' => $inputs['company_phone'],
            'province_id' => $inputs['province_id'],
            'city_id' => $inputs['city_id'],
            'ipark_id' => $inputs['ipark_id'],
            'address' => $inputs['address'],
            'type' => $inputs['type'],
            'category_id' => $inputs['category_id'],
        ]);
        if ($request->file('Ncard')) {
            $NcardName = time() . random_int(1000, 9999) . '.' . $request->file('Ncard')->getClientOriginalExtension();
            $request->file('Ncard')->move('upload/documents/', $NcardName);
            $NcardPath = 'upload/documents/' . $NcardName;
        }
        if ($request->file('Newspaper')) {
            $NewspaperName = time() . random_int(1000, 9999) . '.' . $request->file('Newspaper')->getClientOriginalExtension();
            $request->file('Newspaper')->move('upload/documents/', $NewspaperName);
            $NewspaperPath = 'upload/documents/' . $NewspaperName;
        }
        $lastChangePath = null;
        if ($request->file('lastChange')) {
            $lastChangeName = time() . random_int(1000, 9999) . '.' . $request->file('lastChange')->getClientOriginalExtension();
            $request->file('lastChange')->move('upload/documents/', $lastChangeName);
            $lastChangePath = 'upload/documents/' . $lastChangeName;
        }
        Document::create([
            'brand_id' => $brand->id,
            'ncard' => $NcardPath,
            'newspaper' => $NewspaperPath,
            'lastchange' => $lastChangePath
        ]);
        $user->update([
            'nationaliy_code' => $inputs['user_code'],
            'birthday' => $inputs['user_Byear'] . '/' . $inputs['user_Bmonth'] . '/' . $inputs['user_Bday'],
            'status' => 3
        ]);
        return view('panel.status1');
    }
}
