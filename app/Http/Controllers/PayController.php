<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ConnectionsTrait;
use App\Models\Transacction;

class PayController extends Controller
{
    use ConnectionsTrait;

    public function deposit(Request $request)
    {
        $amount = $request->get('amount');
        $plataform = $request->get('pay-method');
        $currency = $request->get('currency');
        if($plataform == 'easymoney'){

            $request->validate([
                'amount' => 'required|integer',

            ]);
            //conectamos al api
            $data = array(
                'amount' => (int)$amount,
                'currency' => $currency
            );

            $res = $this->easyMoney($data);

            if($res->successful()){

                Transacction::create([
                    'amount' => $amount,
                    'currency' => $currency,
                    'pay_method' => $plataform,
                    'status' => 'ok',
                    'response' => 'ok',
                ]);

                return redirect('/')->with('status', 'Transacction Succesfully');

            }else{

                Transacction::create([
                    'amount' => $amount,
                    'currency' => $currency,
                    'pay_method' => $plataform,
                    'status' => 'error',
                    'response' => 'error',
                ]);

                return redirect('/')->with('status', 'the transaction could not be carried out');
            }


        }else{ //superwallet

            $data = array(
                'amount' => (int)$amount,
                'currency' => $currency
            );

            $res = $this->superWalletz($data);

            if($res->successful()){

               $transaction_id = $res->object()->transaction_id;

                Transacction::create([
                    'amount' => $amount,
                    'currency' => $currency,
                    'pay_method' => $plataform,
                    'status' => 'ok',
                    'transaction_id' => $transaction_id,
                ]);

                return redirect('/')->with('status', 'Transacction Succesfully');

            }else{

                Transacction::create([
                    'amount' => $amount,
                    'currency' => $currency,
                    'pay_method' => $plataform,
                    'status' => 'error',
                    'response' => 'error',
                ]);

                return redirect('/')->with('status', 'the transaction could not be carried out');
            }

        }





    }

    public function responseSupeWallet(Request $request){

        $id_transaction = $request->transaction_id;
        $response = $request->status;
        Transacction::where('transaction_id', $id_transaction)
            ->update([
                'response' => $response
            ]);
        return;

    }
}
