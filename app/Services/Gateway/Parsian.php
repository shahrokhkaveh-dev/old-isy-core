<?php

namespace App\Services\Gateway;

use App\Models\Brand;
use App\Models\Plan\Payment;
use App\Models\Plan\Plan;
use App\Services\Application\ApplicationService;
use Exception;
use Illuminate\Support\Facades\Auth;
use SoapClient;

class Parsian
{
    static public function plan(Payment $payment)
    {
        ini_set("soap.wsdl_cache_enabled", "0");


        $PIN = 'g7UGB4wjg52ODn17lbuk';
        $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL";
        $site_call_back_url = route('panel.plan.callback');
        $amount = $payment->amount;
        $order_id = $payment->id;
        $params = array(
            "LoginAccount" => $PIN,
            "Amount" => $amount,
            "OrderId" => $order_id,
            "CallBackUrl" => $site_call_back_url
        );
        $err_mssg = null;
        $client = new SoapClient($wsdl_url);
        try {
            $result = $client->SalePaymentRequest(array(
                "requestData" => $params
            ));
            if ($result->SalePaymentRequestResult->Token && $result->SalePaymentRequestResult->Status === 0) {
                header("Location: https://pec.shaparak.ir/NewIPG/?Token=" . $result->SalePaymentRequestResult->Token); /* Redirect browser */
                exit();
            } elseif ($result->SalePaymentRequestResult->Status  != '0') {
                $err_msg = "(<strong> کد خطا : " . $result->SalePaymentRequestResult->Status . "</strong>) " .
                    $result->SalePaymentRequestResult->Message;
            }
        } catch (Exception $ex) {
            $err_msg =  $ex->getMessage();
        }
        if(!is_null($err_msg)){
            echo $err_msg;
        }
    }
    static public function planApi(Payment $payment)
    {
        ini_set("soap.wsdl_cache_enabled", "0");


        $PIN = 'g7UGB4wjg52ODn17lbuk';
        $wsdl_url = "https://pec.shaparak.ir/NewIPGServices/Sale/SaleService.asmx?WSDL";
        $site_call_back_url = route('panel.plan.callback');
        $amount = $payment->amount;
        $order_id = $payment->id;
        $params = array(
            "LoginAccount" => $PIN,
            "Amount" => $amount,
            "OrderId" => $order_id,
            "CallBackUrl" => $site_call_back_url
        );
        $err_mssg = null;
        $client = new SoapClient($wsdl_url);
        try {
            $result = $client->SalePaymentRequest(array(
                "requestData" => $params
            ));
            if ($result->SalePaymentRequestResult->Token && $result->SalePaymentRequestResult->Status === 0) {
                return ApplicationService::responseFormat(['url' => 'https://pec.shaparak.ir/NewIPG/?Token=' . $result->SalePaymentRequestResult->Token]);
            } elseif ($result->SalePaymentRequestResult->Status  != '0') {
                return ApplicationService::responseFormat([], false, $result->SalePaymentRequestResult->Message);
            }
        } catch (Exception $ex) {
            return ApplicationService::responseFormat([], false, $ex->getMessage());
        }
    }
}
