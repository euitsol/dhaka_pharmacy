<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SingleOrderRequest;
use App\Http\Requests\User\OrderConfirmRequest;
use App\Http\Requests\User\OrderIntRequest;
use App\Http\Requests\User\VoucherRequest;
use App\Http\Traits\DeliveryTrait;
use App\Http\Traits\OrderTrait;
use App\Models\Address;
use App\Models\AddToCart;
use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Traits\TransformProductTrait;
use App\Http\Traits\TransformOrderItemTrait;
use App\Models\Payment;
use App\Services\AddressService;
use App\Services\OrderService;
use App\Services\VoucherService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;

class CheckoutController extends Controller
{
    use TransformProductTrait, OrderTrait, TransformOrderItemTrait, DeliveryTrait;

    private OrderService $orderService;
    private AddressService $addressService;
    private VoucherService $voucherService;

    public function __construct(OrderService $orderService, AddressService $addressService, VoucherService $voucherService)
    {
        $this->orderService = $orderService;
        $this->addressService = $addressService;
        $this->voucherService = $voucherService;
    }

    public function int_order(Request $request)
    {

        try {
            $cartIds = AddToCart::currentCart(user())->get()->pluck('id')->toArray();
            $user = User::findOrFail(user()->id);
            $this->orderService->setUser($user);
            $address = $this->addressService->setUser($user)->defaultAddress();
            if($address){
                $order = $this->orderService->processOrder(['carts' => $cartIds, 'address_id' => $address->id, 'delivery_type' => 'standard'], false, 'web');
            }else{
                $order = $this->orderService->processOrder(['carts' => $cartIds], false, 'web');
            }
            return redirect()->route('u.ck.index', encrypt($order->order_id));
        } catch (ModelNotFoundException $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        } catch (Exception $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }
    }

    public function checkout($order_id)
    {
        try {
            $data['user'] = User::findOrFail(user()->id);
            $this->orderService->setUser($data['user']);
            $data['order'] = $this->orderService->getOrderDetails(decrypt($order_id), 'user');
            return view('user.product_order.checkout', $data);
        } catch (ModelNotFoundException $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->route('home');
        }catch (Exception $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->route('home');
        }
    }
    public function confirm_order(OrderConfirmRequest $req)
    {
        try {
            $this->orderService->setUser(user());
            $this->orderService->setOrder(order_id: $req->validated()['order_id']);

            Log::info($req->order_id."Requesting Confirm");

            $this->orderService->addAddress($req->validated()['address'], $req->validated()['delivery_type']);
            $payment = $this->orderService->confirmOrder(['payment_method' => $req->validated()['payment_method']]);
            return redirect()->route('u.payment.int', encrypt($payment->id));
        } catch (ModelNotFoundException $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        } catch (Exception $e) {
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }
    }
    public function address($id): JsonResponse
    {
        $data = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->where('id', $id)->get()->first();
        return response()->json($data);
    }

    public function voucher_check(VoucherRequest $req)
    {
        try{

            $this->orderService->setUser(user());
            $this->orderService->setOrder(decrypt($req->order_id));
            $this->orderService->addVoucher($req->voucher_code);

            flash()->addSuccess('Voucher applied successfully.');
            return redirect()->back();

        }catch(ModelNotFoundException $e){
            flash()->addWarning($e->getMessage());
            return redirect()->back();
        }catch(Exception $e){
            flash()->addWarning('Something went wrong. Please try again.');
            return redirect()->back();
        }

    }
}
