<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Permission;
use App\Models\Token;
use App\Models\User;
use App\Services\Notifications\SMSPattern;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Authentication extends Component
{
    use LivewireAlert;

    #[Validate(['required', 'ir_mobile:without_zero'])]
    public $phone = '';

    public $status = 'phone';

    public $code = '';
    public $userCode = '';

    public $firstName = '';
    public $lastName = '';
    public $identificationCode = '';

    public $user = '';

    public $tried = 0;

    public $errorMsg = null;

    public $bannedCounter = 0;

    public function __construct()
    {
        $this->code = rand(100000, 999999);
    }

    public function triedHandler()
    {
        $this->code = rand(100000, 999999);
        $this->tried = $this->tried + 1;
        if ($this->tried == 4) {
            $this->status = 'phone';
            $this->errorMsg = 'کاربر گرامی به دلیل نقض ماده 5 قوانین استفاده از سامانه دسترسی شما به مدت 60 دقیقه محدود شده است.';
            DB::table('banned_numbers')->insert([
                'number' => $this->phone,
                'ip' => request()->ip(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'free_at' => Carbon::now()->addHour(),
            ]);
        } else {
            $token = Token::where('phone', $this->phone)->latest()->first();
            if ($token) {
                if (!$token->isExpired()) {
                    $this->status = 'code';
                } else {
                    $token = Token::create([
                        'phone' => $this->phone,
                        'code' => $this->code,
                        'expired_time' => Carbon::now()->addMinutes(2)
                    ]);
                    SMSPattern::sendOtp($this->phone, $this->code);
                    $this->status = 'code';
                }
            } else {
                $token = Token::create([
                    'phone' => $this->phone,
                    'code' => $this->code,
                    'expired_time' => Carbon::now()->addMinutes(2)
                ]);
                SMSPattern::sendOtp($this->phone, $this->code);
                $this->status = 'code';
            }
            $this->code = $token;
        }
    }

    public function render()
    {
        return view('auth.login')->layout('auth.master');
    }

    public function save()
    {
        $this->validate();

        $is_banned = false;
        $freeTime = null;
        $bannedNumber = DB::table('banned_numbers')->where('number', '=', '0' . $this->phone)->latest()->first();
        $this->bannedCounter = DB::table('banned_numbers')->where('number', '=', '0' . $this->phone)->count();

        if ($bannedNumber) {
            $freeTime = $bannedNumber->free_at;
            $is_banned = Carbon::now() < $freeTime;
        }

        if (!$is_banned) {
            $this->phone = '0' . $this->phone;
            $token = Token::where('phone', $this->phone)->latest()->first();
            if ($token) {
                if (!$token->isExpired()) {
                    $this->status = 'code';
                } else {
                    $token = Token::create([
                        'phone' => $this->phone,
                        'code' => $this->code,
                        'expired_time' => Carbon::now()->addMinutes(2)
                    ]);
                    SMSPattern::sendOtp($this->phone, $this->code);
                    $this->status = 'code';
                }
            } else {
                $token = Token::create([
                    'phone' => $this->phone,
                    'code' => $this->code,
                    'expired_time' => Carbon::now()->addMinutes(2)
                ]);
                SMSPattern::sendOtp($this->phone, $this->code);
                $this->status = 'code';
            }
            $this->tried = $this->tried + 1;
            if ($this->tried == 3) {
                // if($this->bannedCounter <= 5){
                $this->status = 'phone';
                $this->errorMsg = 'کاربر گرامی به دلیل نقض ماده 5 قوانین استفاده از سامانه دسترسی شما به مدت 60 دقیقه محدود شده است.';
                DB::table('banned_numbers')->insert([
                    'number' => $this->phone,
                    'ip' => $_SERVER['HTTP_CLIENT_IP'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'free_at' => Carbon::now()->addHour(),
                ]);
                // }else{
                //     $
                // }
                // elseif($this->bannedCounter <= 8){
                //     $this->status = 'phone';
                //     $this->errorMsg = 'به دلیل نقض سیاست‌های محدود کننده سامانه لطفا 7 روز دیگر درخواست دهید.';
                //     DB::table('banned_numbers')->insert([
                //         'number'=>$this->phone,
                //         'ip'=> $_SERVER['HTTP_CLIENT_IP'],
                //         'created_at' => Carbon::now(),
                //         'updated_at' => Carbon::now(),
                //         'free_at' => Carbon::now()->addDays(7),
                //     ]);
                // }
                // elseif($this->bannedCounter <= 10){
                //     $this->status = 'phone';
                //     $this->errorMsg = 'به دلیل نقض سیاست‌های محدود کننده سامانه لطفا 30 روز دیگر درخواست دهید.';
                //     DB::table('banned_numbers')->insert([
                //         'number'=>$this->phone,
                //         'ip'=> $_SERVER['HTTP_CLIENT_IP'],
                //         'created_at' => Carbon::now(),
                //         'updated_at' => Carbon::now(),
                //         'free_at' => Carbon::now()->addDays(30),
                //     ]);
                // }
            }
            $this->code = $token;
        } else {
            $this->errorMsg = "دسترسی شما تا " . jdate($freeTime)->format('H:i') . " محدود شده است.";
        }
    }

    public function checkCode()
    {
        if ($this->code->isExpired() || $this->code->used) {
            $this->alert('error', 'کد منقضی شده است.' , [
                'toast' => false
            ]);
        } else {
            if ($this->code->code == $this->userCode) {
                $user = User::where('phone', $this->phone)->first();
                if ($user) {
                    Auth::login($user, true);
                    $this->redirect('/');
                } else {
                    // $user = User::create([
                    //     'phone'=>$this->phone,
                    // ]);
                    // Auth::login($user);
                    // $user = new User([
                    //     'phone' => $this->phone,
                    // ]);
                    // $this->user = $user;
                    $this->status = 'register';
                }
                $this->code->update(['used' => true]);
            } else {
                $this->alert('error', 'کد نامعتبر است.' , [
                    'toast' => false,
                    'position' => 'center',
                ]);
            }
        }
    }

    public function register()
    {
        $user = new User();
        $user->first_name = $this->firstName;
        $user->last_name = $this->lastName;
        $user->name = $this->firstName . ' ' . $this->lastName;
        $user->identification_code = $this->identificationCode;
        $user->phone = $this->phone;
        $brand = Brand::create([
            'name'=> 'بی نام'
        ]);
        $user->is_branding = true;
        $user->brand_id = $brand->id;
        $user = $user->save();
        $user = User::where('phone', $this->phone)->first();
        Auth::login($user);
        foreach (Permission::all() as $p) {
            DB::table('user_permissions')->insert([
                'user_id' => $user->id,
                'permission_id' => $p->id
            ]);
        }
        $this->redirect('/');
    }
}
