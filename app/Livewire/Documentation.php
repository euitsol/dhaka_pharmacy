<?php

namespace App\Livewire;

use App\Models\Documentation as ModelsDocumentation;
use Livewire\Component;
class Documentation extends Component
{


    protected $paginationTheme = 'bootstrap';

    public $datas, $module_key, $documentation, $did, $created_user, $creation_date, $updated_user, $updated_date;
    public $updateMode = false;
    public $createMode = false;


    protected $rules = [
        'module_key' => 'required',
        'documentation' => 'required',
    ];

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function validateField($field)
    {
        $this->validateOnly($field);
    }


    public function render()
    {
        $this->datas = ModelsDocumentation::all();
        return view('livewire.documentation.main');
    }
    private function resetInputFields(){
        $this->module_key = '';
        $this->documentation = '';
    }
    public function create()
    {
        $this->createMode = true;
    }
    public function store()
    {

        $validatedData = $this->validate();
  
        ModelsDocumentation::create([
            'module_key' => $validatedData['module_key'],
            'documentation' => $validatedData['documentation'],
            'created_by' => admin()->id,
        ]);

        $this->createMode = false;
        session()->flash('message', 'Documentation Created Successfully.');
        $this->resetInputFields();
    }

    public function show(int $did)
    {
        $data = ModelsDocumentation::find($did);
        if($data){

            $this->did = $data->did;
            $this->module_key = $data->module_key;
            $this->documentation = $data->documentation;
            $this->created_user = $data->created_user->name ?? 'System';
            $this->updated_user = $data->updated_user->name ?? 'N/A';
            $this->creation_date = $data->created_at;
            $this->updated_date = $data->updated_at ?? 'N/A';
        }else{
            $this->resetInputFields();
            $this->dispatchBrowserEvent('close-modal');
        }
    }
    public function closeModal()
    {
        $this->resetInputFields();
    }


    public function edit($id)
    {
        $data = ModelsDocumentation::findOrFail($id);
        $this->did = $id;
        $this->module_key = $data->module_key;
        $this->documentation = $data->documentation;
  
        $this->updateMode = true;
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->createMode = false;
        $this->resetInputFields();
    }
    public function update()
    {
        $validatedData = $this->validate();
  
        $data = ModelsDocumentation::find($this->did);
        $data->update([
            'module_key' => $validatedData['module_key'],
            'documentation' => $validatedData['documentation'],
            'updated_by' => admin()->id,
        ]);

        $this->updateMode = false;
  
        session()->flash('message', 'Documentation Updated Successfully.');
        $this->resetInputFields();
    }
    public function delete($id)
    {
        ModelsDocumentation::find($id)->delete();
        session()->flash('message', 'Documentation Deleted Successfully.');
    }
}
