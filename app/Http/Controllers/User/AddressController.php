<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Requests\User\AddressRequest;
use SebastianBergmann\Type\VoidType;
use App\Models\DeliveryZoneCity;
use App\Services\AddressService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class AddressController extends Controller
{
    protected AddressService $addressService;

    public function __construct(AddressService $addressService) {
        $this->middleware('auth');
        $this->addressService = $addressService;
    }

    public function store(AddressRequest $request): RedirectResponse
    {
        $save = new Address();
        $save->latitude = $request->lat;
        $save->longitude = $request->long;
        $save->address = $request->address;
        $save->city = $request->city;
        $save->street_address = $request->street;
        $save->apartment = $request->apartment;
        $save->floor = $request->floor;
        $save->delivery_instruction = $request->instruction;
        $save->creater()->associate(user());
        $save->save();

        //DEFAULT
        if(Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->where('is_default', 1)->get()->count() == 0){
            $save->is_default = true;
            $save->save();
        }

        flash()->addSuccess('New address added successfully');
        return redirect()->back();
    }

    public function details($id): JsonResponse
    {
        try{
            $data = $this->addressService->setUser(user())->list(true, $id);
            return response()->json($data, 200);
        }catch(ModelNotFoundException $e){
            return response()->json($e->getMessage(), 404);
        }catch(Exception $e){
            return response()->json($e->getMessage(), 500);
        }

    }

    public function update(AddressRequest $request): RedirectResponse
    {
        $query = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()));
        if($request->is_default == 1){
            $query->update(['is_default'=>0]);
        }
        $save = $query->where('id', $request->id)->get()->first();
        $save->latitude = $request->lat;
        $save->longitude = $request->long;
        $save->address = $request->address;
        $save->city = $request->city;
        $save->street_address = $request->street;
        $save->apartment = $request->apartment;
        $save->floor = $request->floor;
        $save->delivery_instruction = $request->instruction;
        $save->is_default = $request->is_default ?? false;
        $save->updater()->associate(user());
        $save->save();

        flash()->addSuccess('Address modified successfully');
        return redirect()->back();
    }

    public function list():View
    {
        $data['address'] = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->orderBy('is_default','asc')->get();
        return view('user.address.list', $data);
    }

    public function delete($id): RedirectResponse
    {
        $data = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->where('id', $id)->get()->first();
        if(!empty($data)){
            $data->deleter()->associate(user());
            $data->update();
            $data->delete();

            $this->setDefault();

            flash()->addSuccess('Address deleted successfully');
        }else{
            flash()->addError('Something went wrong');
        }

        return redirect()->back();
    }

    public function setDefault($id = null): void
    {
        $datas = Address::where('creater_id', user()->id)->where('creater_type', get_class(user()))->get();
        foreach($datas as $key => $data){
            if($id == null && $key == 0){ //randomly make default if there is not specific id
                $data->is_default = true;
                $data->updater()->associate(user());
                $data->update();
            }elseif($id == $data->id){
                $data->is_default = true;
                $data->updater()->associate(user());
                $data->update();
            }else{
                $data->is_default = false;
                $data->updater()->associate(user());
                $data->update();
            }
        }

    }

    public function cities(Request $request): JsonResponse
    {
        $cities = DeliveryZoneCity::query();
        if($request->has('q')){
            $cities->where('city_name', 'like', '%'.$request->q.'%');
        }
        $cities = $cities->orderBy('city_name', 'asc')->select('id', 'city_name')->get();
        return response()->json($cities);
    }
}
