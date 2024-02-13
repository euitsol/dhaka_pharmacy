<?php

namespace App\Http\Controllers\DM\KYC;

use App\Http\Controllers\Controller;
use App\Models\KycSetting;
use App\Models\SubmittedKyc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class KycVerificationController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('dm');
    }

    public function kyc_verification(){
        $data['details'] = KycSetting::where('type', 'dm')->where('status',1)->first();
        $data['datas'] = SubmittedKyc::where('type', 'dm')->where('creater_id', dm()->id)->where('creater_type', get_class(dm()))->first();
        return view('district_manager.kyc_verification_center.index', $data);
    }

    public function kyc_store(Request $request){
        $kyc_setting = KycSetting::where('type', 'dm')->where('status',1)->first();
        $submitted_kyc = SubmittedKyc::where('type', 'dm')->where('creater_id', dm()->id)->where('creater_type', get_class(dm()))->first();
        if($submitted_kyc && ($submitted_kyc->status === 1 || $submitted_kyc->status === 0)){
            flash()->addWarning('Data already submitted.');
            return redirect()->back();
        }
        $params = json_decode($kyc_setting->form_data);
        if($submitted_kyc){
            $saved_data = json_decode($submitted_kyc->submitted_data);
        }
		$rules = [];
        $data = [];
		if ($params != null) {
			foreach ($params as $key => $fd) {
				$rules[$fd->field_key] = [''];
                $input_name = $fd->field_key;

				if ($fd->type == 'text') {
					array_push($rules[$fd->field_key], 'string');
					array_push($rules[$fd->field_key], 'max:255');

					$data[$fd->field_key]=$request->$input_name;

				}elseif ($fd->type == 'number') {
					array_push($rules[$fd->field_key], 'numeric');
					array_push($rules[$fd->field_key], 'max:9999999999');

					$data[$fd->field_key]=$request->$input_name;
				}elseif ($fd->type == 'url') {
					array_push($rules[$fd->field_key], 'url');

					$data[$fd->field_key]=$request->$input_name;
				}elseif ($fd->type == 'textarea') {

					$data[$fd->field_key]=$request->$input_name;
				}elseif ($fd->type == 'image') {
					array_push($rules[$fd->field_key], 'image');
					array_push($rules[$fd->field_key], 'mimes:jpeg,png,jpg,gif,svg');
					array_push($rules[$fd->field_key], 'max:2048');

                    try{
                        if($request->hasFile($input_name)){
                            $file = $request->file($input_name);

                            $customFileName = time().'.' . $file->getClientOriginalExtension();
                            $path = $file->storeAs('district-manager/kyc/'.dm()->id.'/'.'image-single/'.$input_name, $customFileName,'public');
                            $data[$fd->field_key]=$path;
                        }else{
                            if(isset($saved_data->$input_name) && !empty($saved_data->$input_name)){
                                $data[$fd->field_key]=$saved_data->$input_name;
                            }
                        }

                    }catch (\Exception $exp) {
                        session()->flash('error', 'Could not upload your ' . $fd->field_name);
                        return back()->withInput();
                    }
				}elseif ($fd->type == 'image_multiple') {
                    $image_paths=[];
                    if(isset($saved_data->$input_name) && !empty($saved_data->$input_name)){
                        $image_paths = $saved_data->$input_name;
                    }

                    try{
                        if (is_array($request->$input_name)) {
                            foreach($request->$input_name as $key=>$file){
                                if ($file->isFile()) {
                                    $customFileName = time().rand(100000, 999999).'.' . $file->getClientOriginalExtension();
                                    $image_path = $file->storeAs('district-manager/kyc/'.dm()->id.'/'.'image-multiple/'.$input_name, $customFileName,'public');
                                    $image_paths = json_decode(json_encode($image_paths), true);
                                    $image_paths = array_values($image_paths);
                                    array_push($image_paths, $image_path);
                                }
                            }
                        }
                        $data[$fd->field_key]=$image_paths;
                    }catch (\Exception $exp) {
                        session()->flash('status', 'Could not upload ' . $fd->field_name);
                        return back()->withInput();
                    }
				}elseif ($fd->type == 'file_single') {
                    if (isset($request->$input_name['url']) && Storage::exists($request->$input_name['url'])) {

                        if(isset($saved_data->$input_name) && !empty($saved_data->$input_name)){
                            if(Storage::exists('public/' . $saved_data->$input_name)){
                                Storage::delete('public/' . $saved_data->$input_name);
                            }
                        }

                        $file_path = $request->$input_name['url'];
                        $directoryPath = 'public/district-manager/kyc/'.dm()->id.'/'.'single-uploads';
                        if (!Storage::exists($directoryPath)) {
                            Storage::makeDirectory($directoryPath, 0755, true);
                        }

                        $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                        $new_filename = Str::slug($request->$input_name['title'] ?? 'single-file') . '.' . $file_extension;


                        $sourceFilePath = $file_path;
                        $destinationFilePath = $directoryPath . '/' . $new_filename;
                        $databasePath = 'district-manager/kyc/'.dm()->id.'/'.'single-uploads/' . $new_filename;
                        $moveSuccessful = Storage::move($sourceFilePath, $destinationFilePath);

                        $data[$fd->field_key]=$databasePath;
                    }else{
                        if(isset($saved_data->$input_name) && !empty($saved_data->$input_name)){
                            $data[$fd->field_key]=$saved_data->$input_name;
                        }
                    }
				}elseif ($fd->type == 'file_multiple') {
                    $paths = [];

                    if (isset($request->$input_name) && !empty($request->$input_name)) {
                        if (isset($saved_data->$input_name) && !empty($saved_data->$input_name)) {
                            if (is_array($saved_data->$input_name)) {
                                $paths = $saved_data->$input_name;
                            } elseif (is_object($saved_data->$input_name)) {
                                $paths = (array)$saved_data->$input_name;
                            }
                        }

                        foreach ($request->$input_name as $key => $input_data) {
                            $file_path = $input_data['url'];
                            $directoryPath = 'public/district-manager/kyc/'.dm()->id.'/'.'multiple-uploads';

                            if (!Storage::exists($directoryPath)) {
                                $path = Storage::makeDirectory($directoryPath, 0755, true);
                                array_push($paths, $path);
                            }

                            $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                            $new_filename = Str::slug($input_data['title'] ?? 'multiple-file') . '.' . $file_extension;

                            $sourceFilePath = $file_path;
                            $destinationFilePath = $directoryPath . '/' . $new_filename;
                            $databasePath = 'district-manager/kyc/'.dm()->id.'/'.'multiple-uploads/' . $new_filename;

                            $moveSuccessful = Storage::move($sourceFilePath, $destinationFilePath);
                            if ($moveSuccessful) {
                                array_push($paths, $databasePath);
                            }
                        }
                        $data[$fd->field_key] = $paths;
                    } else {
                        if (isset($saved_data->$input_name) && !empty($saved_data->$input_name)) {
                            if (is_array($saved_data->$input_name)) {
                                $data[$fd->field_key] = $saved_data->$input_name;
                            } elseif (is_object($saved_data->$input_name)) {
                                $data[$fd->field_key] = (array)$saved_data->$input_name;
                            }
                        }
                    }
                }elseif ($fd->type == 'email'){
					array_push($rules[$fd->field_key], 'email');

					$data[$fd->field_key]=$request->$input_name;
                }elseif ($fd->type == 'option'){
                    $values = implode(',', array_keys((array)$fd->option_data));
					array_push($rules[$fd->field_key], 'in:'.$values);
					$data[$fd->field_key]=$request->$input_name;
                }
			}
		}
		$this->validate($request, $rules);
        if($submitted_kyc){
            $submitted_kyc->type = 'dm';
            $submitted_kyc->creater()->associate(dm());
            $submitted_kyc->submitted_data = json_encode($data);
        }else{
            $submitted_kyc = new SubmittedKyc();
            $submitted_kyc->type = 'dm';
            $submitted_kyc->creater()->associate(dm());
            $submitted_kyc->submitted_data = json_encode($data);
        }
        $submitted_kyc->status = 0;
        $submitted_kyc->save();
        flash()->addSuccess('Data has been saved successfully.');
        return redirect()->back();

    }

    public function file_upload(Request $request){
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFileName = $file->getClientOriginalName();

            $filePath = $file->store('public/district_manager/kyc/'.dm()->id.'/'.'uploads');
            $ext = pathinfo($filePath, PATHINFO_EXTENSION);
            $title = pathinfo($originalFileName, PATHINFO_FILENAME);
            return response()->json(['success' => true, 'file_path' => $filePath, 'title' => $title, 'extension' => $ext, 'url' => base64_encode($filePath)]);
        }

        return response()->json(['success' => false, 'message' => 'File upload failed.']);
    }

    public function delete($id = null, $key = null, $file_path = null){
        if($file_path){
            $acc_file_path = base64_decode($file_path);

            if (!Str::startsWith($acc_file_path, 'public/')) {
                $file_path = 'public/' . $acc_file_path;
            }
        }
        if($file_path != null){
            if(Storage::exists($file_path)){
                Storage::delete($file_path);
            }
            if($id != null && $key != null){
                $sp = SubmittedKyc::findOrFail($id);
                $saved_data = json_decode($sp->saved_data, true);
                if (isset($saved_data[$key])) {
                    if(is_array($saved_data)){
                        $array = $saved_data[$key];
                        $index = array_search($acc_file_path, $array);
                        unset($array[$index]);
                        $saved_data[$key] = $array;

                    }else{
                        unset($saved_data[$key]);
                    }
                    $sp->submitted_kyc = json_encode($saved_data);
                    $sp->save();
                }
            }
        }else{
            if($id != null && $key != null){
                $kyc = SubmittedKyc::where('id', $id)->firstOrFail();
                $saved_data = json_decode($kyc->saved_data, true);
                if (isset($saved_data[$key])) {
                    if(Storage::exists('public/'.$saved_data[$key])){
                        Storage::delete('public/'.$saved_data[$key]);
                    }
                    unset($saved_data[$key]);
                    $kyc->submitted_kyc = json_encode($saved_data);
                    $kyc->save();
                }
            }
        }
        flash()->addSuccess('File deleted successfully.');
        return redirect()->back();
    }
}
