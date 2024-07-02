<?php

namespace App\Http\Controllers\User\PaymentGateway;

use App\Http\Controllers\Controller;
use App\Library\SslCommerz\SslCommerzNotification;
use App\Models\AddToCart;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Traits\TransformOrderItemTrait;

class SslCommerzController extends Controller
{
    use TransformOrderItemTrait;
    public function __construct()
    {
        return $this->middleware('auth');
    }
    public function index($payment_id)
    {
        $payment_id = decrypt($payment_id);
        $payment = Payment::with('order')->findOrFail($payment_id);
        # Here you have to receive all the order data to initate the payment.
        # Let's say, your oder transaction informations are saving in a table called "orders"
        # In "orders" table, order unique identity is "transaction_id". "status" field contain status of the transaction, "amount" is the order amount to be paid and "currency" is for storing Site Currency which will be checked with paid currency.

        $post_data = array();
        $post_data['total_amount'] = $payment->amount; # You cant not pay less than 10
        $post_data['currency'] = "BDT";
        $post_data['tran_id'] = generateTranId(); // tran_id must be unique

        # CUSTOMER INFORMATION
        $post_data['cus_name'] = $payment->order->customer->name;
        $post_data['cus_email'] = $payment->order->customer->email ? $payment->order->customer->email : 'user@dp.com';
        $post_data['cus_add1'] = $payment->order->address ? $payment->order->address->name : 'Mirpur, Dhaka';
        $post_data['cus_add2'] = $payment->order->address ? $payment->order->address->name : 'Mirpur, Dhaka'; //optional
        $post_data['cus_city'] = $payment->order->address ? $payment->order->address->city : "Dhaka"; //optional
        $post_data['cus_state'] = "Dhaka"; //optional
        $post_data['cus_postcode'] = "1255"; //optional
        $post_data['cus_country'] = "Bangladesh";
        $post_data['cus_phone'] = $payment->order->customer ? $payment->order->customer->phone : '01700000000';
        $post_data['cus_fax'] = "null"; //optional

        # SHIPMENT INFORMATION
        $post_data['ship_name'] = "Store Test";
        $post_data['ship_add1'] = "Dhaka";
        $post_data['ship_add2'] = "Dhaka";
        $post_data['ship_city'] = "Dhaka";
        $post_data['ship_state'] = "Dhaka";
        $post_data['ship_postcode'] = "1000";
        $post_data['ship_phone'] = "01000000000";
        $post_data['ship_country'] = "Bangladesh";

        $post_data['shipping_method'] = "NO";
        $post_data['product_name'] = "Computer";
        $post_data['product_category'] = "Goods";
        $post_data['product_profile'] = "physical-goods";

        # OPTIONAL PARAMETERS
        $post_data['value_a'] = $payment->order->id;
        $post_data['value_b'] = "ref002";
        $post_data['value_c'] = "ref003";
        $post_data['value_d'] = "ref004";

        #Before  going to initiate the payment order status need to insert or update as Pending.
        // $update_product = Payment::where('transaction_id', $post_data['tran_id'])
        //     ->updateOrInsert([
        //         // 'customer_id' => admin()->id, // Assuming 'admin()' returns the ID of the related model
        //         // 'customer_type' => admin()->getMorphClass(),
        //         'customer_id' => 1, //for test
        //         'customer_type' =>  "App\Models\User", //for test
        //         'amount' => $post_data['total_amount'],
        //         'order_id' => decrypt($post_data['value_a']),
        //         'status' => '0', //Pending
        //         // 'address' => $post_data['cus_add1'],
        //         'transaction_id' => $post_data['tran_id'],
        //         'currency' => $post_data['currency']
        //     ]);

        $sslc = new SslCommerzNotification();
        # initiate(Transaction Data , false: Redirect to SSLCOMMERZ gateway/ true: Show all the Payement gateway here )
        $payment_options = $sslc->makePayment($post_data, 'hosted');

        if (!is_array($payment_options)) {
            print_r($payment_options);
            $payment_options = array();
        }
    }
    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $amount = $request->input('amount');
        $currency = $request->input('currency');
        $payment = Payment::where('transaction_id', $tran_id)->first();
        $payment->details = json_encode($request->all());
        $payment->save();

        $sslc = new SslCommerzNotification();

        #Check order status in order tabel against the transaction id or order id.
        $order_details = Payment::where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 0) {
            $validation = $sslc->orderValidate($request->all(), $tran_id, $amount, $currency);

            if ($validation) {
                /*
                That means IPN did not work or IPN URL was not set in your merchant panel. Here you need to update order status
                in order table as Processing or Complete.
                Here you can also sent sms or email for successfull transaction to customer
                */
                $update_product = Payment::where('transaction_id', $tran_id)
                    ->update(['status' => 2]); //Status 2 , Processing
                Order::where('id', decrypt($request->value_a))
                    ->update(['status' => 1]);
                flash()->addSuccess('Transaction is successfully Completed');
            }
        } else if ($order_details->status == 2 || $order_details->status == 1) { //Status 1 , Complete
            /*
             That means through IPN Order status already updated. Now you can just show the customer that transaction is completed. No need to udate database.
             */
            flash()->addSuccess('Transaction is successfully Completed');
        } else {
            #That means something wrong happened. You can redirect customer to your product page.
            flash()->addSuccess('Transaction is successfully Completed');
        }
        if ($request->value_a) {
            return redirect()->route('u.ck.product.order.success', ['order_id' => $request->value_a]);
        }
        return redirect()->route('home');
    }

    public function fail(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $payment = Payment::where('transaction_id', $tran_id)->first();
        $payment->details = json_encode($request->all());
        $payment->save();

        $order_details = Payment::where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 0) {
            $update_product = Payment::where('transaction_id', $tran_id)
                ->update(['status' => -1]);  //Status -1 , Failed
            Order::where('id', decrypt($request->value_a))
                ->update(['status' => -1]);
            flash()->addError('Transaction is Falied');
        } else if ($order_details->status == 2 || $order_details->status == 1) {
            flash()->addWarning('Transaction is already Successful');
        } else {
            flash()->addError('Transaction is Invalid');
        }

        if ($request->value_a) {
            return redirect()->route('u.ck.product.order.failed', ['order_id' => $request->value_a]);
        }
        return redirect()->route('home');
    }

    public function cancel(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $payment = Payment::where('transaction_id', $tran_id)->first();
        $payment->details = json_encode($request->all());
        $payment->save();

        $order_details = Payment::where('transaction_id', $tran_id)
            ->select('transaction_id', 'status', 'currency', 'amount')->first();

        if ($order_details->status == 0) {
            $update_product = Payment::where('transaction_id', $tran_id)
                ->update(['status' => -2]); //Status -2 Canceled
            Order::where('id', decrypt($request->value_a))
                ->update(['status' => -2]);
            flash()->addError('Transaction is Cancel');
        } else if ($order_details->status == 2 || $order_details->status == 1) {
            flash()->addWarning('Transaction is already Successful');
        } else {
            flash()->addError('Transaction is Invalid');
        }
        if ($request->value_a) {
            return redirect()->route('u.ck.product.order.cancel', ['order_id' => $request->value_a]);
        }
        return redirect()->route('home');
    }

    public function ipn(Request $request)
    {
        #Received all the payement information from the gateway
        if ($request->input('tran_id')) #Check transation id is posted or not.
        {

            $tran_id = $request->input('tran_id');
            $payment = Payment::where('transaction_id', $tran_id)->first();
            $payment->details = json_encode($request->all());
            $payment->save();

            #Check order status in order tabel against the transaction id or order id.
            $order_details = Payment::where('transaction_id', $tran_id)
                ->select('transaction_id', 'status', 'currency', 'amount')->first();

            if ($order_details->status == 0) {
                $sslc = new SslCommerzNotification();
                $validation = $sslc->orderValidate($request->all(), $tran_id, $order_details->amount, $order_details->currency);
                if ($validation == TRUE) {
                    /*
                    That means IPN worked. Here you need to update order status
                    in order table as Processing or Complete.
                    Here you can also sent sms or email for successful transaction to customer
                    */
                    $update_product = Payment::where('transaction_id', $tran_id)
                        ->update(['status' => 2]);
                    Order::where('id', decrypt($request->value_a))
                        ->update(['status' => 1]);

                    flash()->addSuccess('Transaction is successfully Completed');
                }
            } else if ($order_details->status == 2 || $order_details->status == 1) {

                #That means Order status already updated. No need to udate database.

                flash()->addWarning('Transaction is already successfully Completed');
            } else {
                #That means something wrong happened. You can redirect customer to your product page.

                flash()->addError('Invalid Transaction');
            }
        } else {
            flash()->addError('Invalid Data');
        }
        return redirect()->route('u.payment.checkout2');
    }
}
