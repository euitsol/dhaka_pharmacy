<?php

namespace App\Http\Controllers\User\KYC;

use App\Http\Controllers\Controller;
use App\Models\KycSetting;
use App\Models\SubmittedKyc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KycVerificationController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function kyc_verification()
    {
        $query = KycSetting::with('u_submitted_kyc')->where('type', 'user');
        $kyc = $query->first();
        if ($kyc && !$kyc->u_submitted_kyc) {
            $kyc = $query->activated()->first();
        }
        return view('user.kyc_verification_center.index', ['kyc' => $kyc]);
    }
    public function kyc_store(Request $request)
    {
        $query = KycSetting::with('u_submitted_kyc')->where('type', 'user');
        $kyc = $query->first();
        if (!$kyc->u_submitted_kyc) {
            $kyc = $query->activated()->first();
        }
        $submitted_kyc = $kyc->u_submitted_kyc;
        if (!empty($submitted_kyc) && ($submitted_kyc->status === 1 || $submitted_kyc->status === 0)) {
            flash()->addWarning('Your KYC has already been submitted.');
            return redirect()->back();
        }
        $params = json_decode($kyc->form_data);
        if (!empty($submitted_kyc)) {
            $saved_data = json_decode($submitted_kyc->submitted_data);
        }
        $rules = [];
        $data = [];
        if ($params != null) {
            foreach ($params as $key => $fd) {
                $rules[$fd->field_key] = [''];
                $input_name = $fd->field_key;

                if ($fd->type == 'text') {
                    if ($fd->required == 'required') {
                        array_push($rules[$fd->field_key], 'required');
                    } else {
                        array_push($rules[$fd->field_key], 'nullable');
                    }

                    array_push($rules[$fd->field_key], 'string');
                    array_push($rules[$fd->field_key], 'max:255');

                    $data[$fd->field_key] = $request->$input_name;
                } elseif ($fd->type == 'number') {
                    if ($fd->required == 'required') {
                        array_push($rules[$fd->field_key], 'required');
                    } else {
                        array_push($rules[$fd->field_key], 'nullable');
                    }

                    array_push($rules[$fd->field_key], 'numeric');
                    array_push($rules[$fd->field_key], 'max:9999999999');

                    $data[$fd->field_key] = $request->$input_name;
                } elseif ($fd->type == 'url') {
                    if ($fd->required == 'required') {
                        array_push($rules[$fd->field_key], 'required');
                    } else {
                        array_push($rules[$fd->field_key], 'nullable');
                    }

                    array_push($rules[$fd->field_key], 'url');

                    $data[$fd->field_key] = $request->$input_name;
                } elseif ($fd->type == 'date') {
                    if ($fd->required == 'required') {
                        array_push($rules[$fd->field_key], 'required');
                    } else {
                        array_push($rules[$fd->field_key], 'nullable');
                    }
                    array_push($rules[$fd->field_key], 'before:today');
                    array_push($rules[$fd->field_key], 'date');

                    $data[$fd->field_key] = $request->$input_name;
                } elseif ($fd->type == 'textarea') {
                    if ($fd->required == 'required') {
                        array_push($rules[$fd->field_key], 'required');
                    } else {
                        array_push($rules[$fd->field_key], 'nullable');
                    }

                    $data[$fd->field_key] = $request->$input_name;
                } elseif ($fd->type == 'image') {
                    if ($fd->required == 'required') {
                        if (!isset($saved_data->$input_name) || empty($saved_data->$input_name)) {
                            array_push($rules[$fd->field_key], 'required');
                        }
                    } else {
                        array_push($rules[$fd->field_key], 'nullable');
                    }

                    array_push($rules[$fd->field_key], 'image');
                    array_push($rules[$fd->field_key], 'mimes:jpeg,png,jpg,gif,svg');
                    array_push($rules[$fd->field_key], 'max:2048');

                    try {
                        if ($request->hasFile($input_name)) {
                            $file = $request->file($input_name);

                            $customFileName = time() . '.' . $file->getClientOriginalExtension();
                            $path = $file->storeAs('user/kyc/' . user()->id . '/' . 'image-single/' . $input_name, $customFileName, 'public');
                            $data[$fd->field_key] = $path;
                        } else {
                            if (isset($saved_data->$input_name) && !empty($saved_data->$input_name)) {
                                $data[$fd->field_key] = $saved_data->$input_name;
                            }
                        }
                    } catch (\Exception $exp) {
                        session()->flash('error', 'Could not upload your ' . $fd->field_name);
                        return back()->withInput();
                    }
                } elseif ($fd->type == 'image_multiple') {
                    if ($fd->required == 'required') {
                        if (!isset($saved_data->$input_name) || empty($saved_data->$input_name)) {
                            array_push($rules[$fd->field_key], 'required');
                        }
                    } else {
                        array_push($rules[$fd->field_key], 'nullable');
                    }
                    $image_paths = [];
                    if (isset($saved_data->$input_name) && !empty($saved_data->$input_name)) {
                        $image_paths = $saved_data->$input_name;
                    }

                    try {
                        if (is_array($request->$input_name)) {
                            foreach ($request->$input_name as $key => $file) {
                                if ($file->isFile()) {
                                    $customFileName = time() . rand(100000, 999999) . '.' . $file->getClientOriginalExtension();
                                    $image_path = $file->storeAs('user/kyc/' . user()->id . '/' . 'image-multiple/' . $input_name, $customFileName, 'public');
                                    $image_paths = json_decode(json_encode($image_paths), true);
                                    $image_paths = array_values($image_paths);
                                    array_push($image_paths, $image_path);
                                }
                            }
                        }
                        $data[$fd->field_key] = $image_paths;
                    } catch (\Exception $exp) {
                        session()->flash('status', 'Could not upload ' . $fd->field_name);
                        return back()->withInput();
                    }
                } elseif ($fd->type == 'file_single') {
                    if ((isset($saved_data->$input_name) && empty($saved_data->$input_name)) || !isset($saved_data->$input_name)) {
                        $rules[$fd->field_key . '.url'] = [];
                        $rules[$fd->field_key . '.title'] = [];
                        if ($fd->required == 'required') {
                            if (!isset($saved_data->$input_name['url']) || empty($saved_data->$input_name['url'])) {
                                array_push($rules[$fd->field_key . '.url'], 'required');
                            }
                        } else {
                            array_push($rules[$fd->field_key . '.url'], 'nullable');
                        }
                        array_push($rules[$fd->field_key . '.title'], 'nullable');
                        array_push($rules[$fd->field_key . '.title'], 'string');
                    }
                    if (isset($request->$input_name['url']) && Storage::exists($request->$input_name['url'])) {

                        if (isset($saved_data->$input_name) && !empty($saved_data->$input_name)) {
                            if (Storage::exists('public/' . $saved_data->$input_name)) {
                                Storage::delete('public/' . $saved_data->$input_name);
                            }
                        }

                        $file_path = $request->$input_name['url'];
                        $directoryPath = 'public/user/kyc/' . user()->id . '/' . 'single-uploads';
                        if (!Storage::exists($directoryPath)) {
                            Storage::makeDirectory($directoryPath, 0755, true);
                        }

                        $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                        $new_filename = Str::slug($request->$input_name['title'] ?? 'single-file') . '.' . $file_extension;


                        $sourceFilePath = $file_path;
                        $destinationFilePath = $directoryPath . '/' . $new_filename;
                        $databasePath = 'user/kyc/' . user()->id . '/' . 'single-uploads/' . $new_filename;
                        $moveSuccessful = Storage::move($sourceFilePath, $destinationFilePath);

                        $data[$fd->field_key] = $databasePath;
                    } else {
                        if (isset($saved_data->$input_name) && !empty($saved_data->$input_name)) {
                            $data[$fd->field_key] = $saved_data->$input_name;
                        }
                    }
                } elseif ($fd->type == 'email') {
                    if ($fd->required == 'required') {
                        array_push($rules[$fd->field_key], 'required');
                    } else {
                        array_push($rules[$fd->field_key], 'nullable');
                    }

                    array_push($rules[$fd->field_key], 'email');

                    $data[$fd->field_key] = $request->$input_name;
                } elseif ($fd->type == 'option') {
                    if ($fd->required == 'required') {
                        array_push($rules[$fd->field_key], 'required');
                    } else {
                        array_push($rules[$fd->field_key], 'nullable');
                    }
                    $values = implode(',', array_keys((array)$fd->option_data));
                    array_push($rules[$fd->field_key], 'in:' . $values);

                    $data[$fd->field_key] = $request->$input_name;
                } elseif ($fd->type == 'file_multiple') {
                    if ((isset($saved_data->$input_name) && empty($saved_data->$input_name)) || !isset($saved_data->$input_name)) {
                        $rules[$fd->field_key . '.*.url'] = [];
                        $rules[$fd->field_key . '.*.title'] = [];
                        if ($fd->required == 'required') {
                            if (!isset($saved_data->$input_name[1]['url']) || empty($saved_data->$input_name[1]['url'])) {
                                array_push($rules[$fd->field_key . '.*.url'], 'required');
                            }
                        } else {
                            array_push($rules[$fd->field_key . '.*.url'], 'nullable');
                        }
                        array_push($rules[$fd->field_key . '.*.title'], 'nullable');
                        array_push($rules[$fd->field_key . '.*.title'], 'string');
                    }
                    // $this->validate($request, $rules);
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
                            $directoryPath = 'public/user/kyc/' . user()->id . '/' . 'multiple-uploads';

                            if (is_null($file_path) || !Storage::exists($file_path)) {
                                continue;
                            }

                            if (!Storage::exists($directoryPath)) {
                                $path = Storage::makeDirectory($directoryPath, 0755, true);
                                array_push($paths, $path);
                            }

                            $file_extension = pathinfo($file_path, PATHINFO_EXTENSION);
                            $new_filename = Str::slug($input_data['title'] ?? 'multiple-file') . '.' . $file_extension;

                            $sourceFilePath = $file_path;
                            $destinationFilePath = $directoryPath . '/' . $new_filename;
                            $databasePath = 'user/kyc/' . user()->id . '/' . 'multiple-uploads/' . $new_filename;

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
                }
            }
        }
        $this->validate($request, $rules);
        if (!empty($submitted_kyc)) {
            $submitted_kyc->type = 'user';
            $submitted_kyc->creater()->associate(user());
            $submitted_kyc->submitted_data = json_encode($data);
            $submitted_kyc->kyc_id = $kyc->id;
        } else {
            $submitted_kyc = new SubmittedKyc();
            $submitted_kyc->type = 'user';
            $submitted_kyc->creater()->associate(user());
            $submitted_kyc->submitted_data = json_encode($data);
            $submitted_kyc->kyc_id = $kyc->id;
        }
        $submitted_kyc->status = 0;
        $submitted_kyc->save();
        flash()->addSuccess('KYC has been successfully submitted.');
        return redirect()->back();
    }

    public function file_upload(Request $request)
    {
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFileName = $file->getClientOriginalName();

            $filePath = $file->store('public/user/kyc/' . user()->id . '/' . 'uploads');
            $ext = pathinfo($filePath, PATHINFO_EXTENSION);
            $title = pathinfo($originalFileName, PATHINFO_FILENAME);
            return response()->json(['success' => true, 'file_path' => $filePath, 'title' => $title, 'extension' => $ext, 'url' => encrypt($filePath)]);
        }

        return response()->json(['success' => false, 'message' => 'File upload failed.']);
    }
}