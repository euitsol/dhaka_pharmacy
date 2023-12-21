<?php

namespace App\Http\Controllers\Admin\UserManagement;

use App\Http\Controllers\Controller;
use App\Models\KycSetting;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;


class KycSettingsController extends Controller
{
    //

    public function __construct() {
        return $this->middleware('admin');
    }


    public function kycSettings(){
        $s['kyc_settings'] = KycSetting::all();
        return view('admin.user_management.kyc_settings.create',$s);
    }

    // public function kycSettingsUpdate(Request $request){
    //     $kyc_settings = new KycSetting();
    //     $kyc_settings->status = $request->status;
    //     $kyc_settings->documentation = json_encode($request->documentation);
    //     $data = [];
    //     foreach($request->formdata as $key=>$formdata){
    //         if(isset($formdata['field_name'])){
    //             $data[$key]['field_key'] = Str::slug($formdata['field_name']);
    //             $data[$key]['field_name'] = $formdata['field_name'];
    //             $data[$key]['type'] = $formdata['type'];
    //             $data[$key]['required'] = $formdata['required'];

    //             if($formdata['type'] == 'option'){
    //                 $data[$key]['option_data']  = $this->convertOptionDataToArray($formdata['option_data']) ?? [];
    //             }
    //         }
    //     }

    //     $kyc_settings->form_data = json_encode($data);
    //     $kyc_settings->save();

    //     return redirect()->route('um.user_kyc.kyc_settings_view')->withStatus(__('KYC settings updated successfully.'));
    // }


    public function kycSettingsUpdate(Request $request){
        $data = $this->prepareKycData($request);
    
        // Find an existing record or create a new one based on the status field
        KycSetting::updateOrCreate(
            ['type' => $request->type],
            [
                'status' => $request->status,
                'documentation' => json_encode($request->documentation),
                'form_data' => json_encode($data),
            ]
        );
    
        return redirect()->route('um.user_kyc.kyc_settings_view')->withStatus(__('KYC settings updated successfully.'));
    }
    
    private function prepareKycData(Request $request) {
        $data = [];
        foreach($request->formdata as $key => $formdata) {
            if(isset($formdata['field_name'])) {
                $data[$key]['field_name'] = $formdata['field_name'];
                $data[$key]['type'] = $formdata['type'];
                $data[$key]['required'] = $formdata['required'];
    
                if($formdata['type'] == 'option') {
                    $data[$key]['option_data']  = $this->convertOptionDataToArray($formdata['option_data']) ?? [];
                }
            }
        }
    
        return $data;
    }










    // public function show($page_key){
    //     if (!auth()->user()->can('single_pages')) {
    //         abort(403, 'Unauthorized');
    //     }
    //     $details = SinglePages::where('page_key', $page_key)->latest()->firstOrFail();

    //     return view('show', ['details' => $details]);
    // }

    // public function form_store(Request $request, $page_key){
    //     $single_page = SinglePages::where('page_key', $page_key)->latest()->get()->first();
    //     $params = json_decode($single_page->form_data);
    //     $saved_data = json_decode($single_page->saved_data);
	// 	$rules = [];
    //     $data = [];
	// 	if ($params != null) {
	// 		foreach ($params as $key => $fd) {
	// 			$rules[$fd->field_key] = [''];
    //             $input_name = $fd->field_key;

	// 			if ($fd->type == 'text') {
	// 				array_push($rules[$fd->field_key], 'string');
	// 				array_push($rules[$fd->field_key], 'max:255');

	// 				$data[$fd->field_key]=$request->$input_name;

	// 			}elseif ($fd->type == 'number') {
	// 				array_push($rules[$fd->field_key], 'numeric');
	// 				array_push($rules[$fd->field_key], 'max:55');

	// 				$data[$fd->field_key]=$request->$input_name;
	// 			}elseif ($fd->type == 'url') {
	// 				array_push($rules[$fd->field_key], 'url');

	// 				$data[$fd->field_key]=$request->$input_name;
	// 			}elseif ($fd->type == 'textarea') {

	// 				$data[$fd->field_key]=$request->$input_name;
	// 			}elseif ($fd->type == 'image') {
	// 				array_push($rules[$fd->field_key], 'image');
	// 				array_push($rules[$fd->field_key], 'mimes:jpeg,png,jpg,gif,svg');
	// 				array_push($rules[$fd->field_key], 'max:2048');

    //                 try{
    //                     if($request->hasFile($input_name)){
    //                         $file = $request->file($input_name);

    //                         $customFileName = time().'.' . $file->getClientOriginalExtension();
    //                         $path = $file->storeAs('single-page/image-single/'.$input_name, $customFileName,'public');
    //                         $data[$fd->field_key]=$path;
    //                     }else{
    //                         if(isset($saved_data->$input_name) && !empty($saved_data->$input_name)){
    //                             $data[$fd->field_key]=$saved_data->$input_name;
    //                         }
    //                     }

    //                 }catch (\Exception $exp) {
    //                     session()->flash('error', 'Could not upload your ' . $fd->field_name);
    //                     return back()->withInput();
    //                 }
	// 			}elseif ($fd->type == 'image_multiple') {
    //                 $image_paths=[];
    //                 if(isset($saved_data->$input_name) && !empty($saved_data->$input_name)){
    //                     $image_paths = $saved_data->$input_name;
    //                 }

    //                 try{
    //                     if (is_array($request->$input_name)) {
    //                         foreach($request->$input_name as $key=>$file){
    //                             if ($file->isFile()) {
    //                                 $customFileName = time().rand(100000, 999999).'.' . $file->getClientOriginalExtension();
    //                                 $image_path = $file->storeAs('single-page/image-multiple/'.$input_name, $customFileName,'public');
    //                                 $image_paths = json_decode(json_encode($image_paths), true);
    //                                 $image_paths = array_values($image_paths);
    //                                 array_push($image_paths, $image_path);
    //                             }
    //                         }
    //                     }
    //                     $data[$fd->field_key]=$image_paths;
    //                 }catch (\Exception $exp) {
    //                     session()->flash('status', 'Could not upload ' . $fd->field_name);
    //                     return back()->withInput();
    //                 }
	// 			}elseif ($fd->type == 'file_single') {
    //                 if (isset($request->$input_name['url']) && Storage::exists($request->$input_name['url'])) {

    //                     if(isset($saved_data->$input_name) && !empty($saved_data->$input_name)){
    //                         if(Storage::exists('public/' . $saved_data->$input_name)){
    //                             Storage::delete('public/' . $saved_data->$input_name);
    //                         }
    //                     }

    //                     $file_path = $request->$input_name['url'];
    //                     $directoryPath = 'public/single-page/single-uploads';
    //                     if (!Storage::exists($directoryPath)) {
    //                         Storage::makeDirectory($directoryPath, 0755, true);
    //                     }

    //                     $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
    //                     $new_filename = Str::slug($request->$input_name['title'] ?? 'single-file') . '.' . $file_extension;


    //                     $sourceFilePath = $file_path;
    //                     $destinationFilePath = $directoryPath . '/' . $new_filename;
    //                     $databasePath = 'single-page/single-uploads/' . $new_filename;
    //                     $moveSuccessful = Storage::move($sourceFilePath, $destinationFilePath);

    //                     $data[$fd->field_key]=$databasePath;
    //                 }else{
    //                     if(isset($saved_data->$input_name) && !empty($saved_data->$input_name)){
    //                         $data[$fd->field_key]=$saved_data->$input_name;
    //                     }
    //                 }
	// 			}elseif ($fd->type == 'file_multiple') {
    //                 $paths = [];

    //                 if (isset($request->$input_name) && !empty($request->$input_name)) {
    //                     if (isset($saved_data->$input_name) && !empty($saved_data->$input_name)) {
    //                         if (is_array($saved_data->$input_name)) {
    //                             $paths = $saved_data->$input_name;
    //                         } elseif (is_object($saved_data->$input_name)) {
    //                             $paths = (array)$saved_data->$input_name;
    //                         }
    //                     }

    //                     foreach ($request->$input_name as $key => $input_data) {
    //                         $file_path = $input_data['url'];
    //                         $directoryPath = 'public/single-page/multiple-uploads';

    //                         if (!Storage::exists($directoryPath)) {
    //                             $path = Storage::makeDirectory($directoryPath, 0755, true);
    //                             array_push($paths, $path);
    //                         }

    //                         $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
    //                         $new_filename = Str::slug($input_data['title'] ?? 'multiple-file') . '.' . $file_extension;

    //                         $sourceFilePath = $file_path;
    //                         $destinationFilePath = $directoryPath . '/' . $new_filename;
    //                         $databasePath = 'single-page/multiple-uploads/' . $new_filename;

    //                         $moveSuccessful = Storage::move($sourceFilePath, $destinationFilePath);
    //                         if ($moveSuccessful) {
    //                             array_push($paths, $databasePath);
    //                         }
    //                     }
    //                     $data[$fd->field_key] = $paths;
    //                 } else {
    //                     if (isset($saved_data->$input_name) && !empty($saved_data->$input_name)) {
    //                         if (is_array($saved_data->$input_name)) {
    //                             $data[$fd->field_key] = $saved_data->$input_name;
    //                         } elseif (is_object($saved_data->$input_name)) {
    //                             $data[$fd->field_key] = (array)$saved_data->$input_name;
    //                         }
    //                     }
    //                 }
    //             }elseif ($fd->type == 'email'){
	// 				array_push($rules[$fd->field_key], 'email');

	// 				$data[$fd->field_key]=$request->$input_name;
    //             }elseif ($fd->type == 'option'){
    //                 $values = implode(',', array_keys((array)$fd->option_data));
	// 				array_push($rules[$fd->field_key], 'in:'.$values);
	// 				$data[$fd->field_key]=$request->$input_name;
    //             }
	// 		}
	// 	}
	// 	$this->validate($request, $rules);
    //     $single_page->saved_data = json_encode($data);
    //     $single_page->save();
    //     return redirect()->back()->withStatus(__('Data has been saved successfully.'));

    // }

    // private function convertOptionDataToArray($optionData)
    // {
    //     $optionsArray = [];
    //     $options = explode(';', $optionData);

    //     foreach ($options as $option) {
    //         $parts = explode('=', $option);
    //         if (count($parts) === 2) {
    //             $key = trim($parts[0]);
    //             $value = trim($parts[1]);
    //             $optionsArray[$key] = $value;
    //         }
    //     }

    //     return $optionsArray;
    // }

    // public function file_upload(Request $request){
    //     if ($request->hasFile('file')) {
    //         $file = $request->file('file');
    //         $originalFileName = $file->getClientOriginalName();

    //         $filePath = $file->store('public/uploads');
    //         $ext = pathinfo($filePath, PATHINFO_EXTENSION);
    //         $title = pathinfo($originalFileName, PATHINFO_FILENAME);
    //         return response()->json(['success' => true, 'file_path' => $filePath, 'title' => $title, 'extension' => $ext, 'url' => base64_encode($filePath)]);
    //     }

    //     return response()->json(['success' => false, 'message' => 'File upload failed.']);
    // }

    // public function delete($id = null, $key = null, $file_path = null){
    //     if($file_path){
    //         $acc_file_path = base64_decode($file_path);

    //         if (!Str::startsWith($acc_file_path, 'public/')) {
    //             $file_path = 'public/' . $acc_file_path;
    //         }
    //     }
    //     if($file_path != null){
    //         if(Storage::exists($file_path)){
    //             Storage::delete($file_path);
    //         }
    //         if($id != null && $key != null){
    //             $sp = SinglePages::findOrFail($id);
    //             $saved_data = json_decode($sp->saved_data, true);
    //             if (isset($saved_data[$key])) {
    //                 if(is_array($saved_data)){
    //                     $array = $saved_data[$key];
    //                     $index = array_search($acc_file_path, $array);
    //                     unset($array[$index]);
    //                     $saved_data[$key] = $array;

    //                 }else{
    //                     unset($saved_data[$key]);
    //                 }
    //                 $sp->saved_data = json_encode($saved_data);
    //                 $sp->save();
    //             }
    //         }
    //     }else{
    //         if($id != null && $key != null){
    //             $singlePage = SinglePages::where('id', $id)->firstOrFail();
    //             $saved_data = json_decode($singlePage->saved_data, true);
    //             if (isset($saved_data[$key])) {
    //                 if(Storage::exists('public/'.$saved_data[$key])){
    //                     Storage::delete('public/'.$saved_data[$key]);
    //                 }
    //                 unset($saved_data[$key]);
    //                 $singlePage->saved_data = json_encode($saved_data);
    //                 $singlePage->save();
    //             }
    //         }
    //     }
    //     return redirect()->back()->withInput()->withStatus(__('File deleted successfully.'));
    // }
}
