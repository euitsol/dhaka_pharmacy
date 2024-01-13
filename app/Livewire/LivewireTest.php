<?php

namespace App\Livewire;

use App\Http\Requests\LivewireTestRequest;
use Livewire\Component;
use App\Models\LivewireTest as Test;

class LivewireTest extends Component
{
    protected $paginationTheme = 'bootstrap';

    public $datas, $name, $roll, $id, $created_user, $creation_date, $updated_user, $updated_date;
    public $updateMode = false;
    public $createMode = false;


    protected function rules()
    {
        if ($this->createMode) {
            return (new LivewireTestRequest())->storeRules();
        } else {
            return (new LivewireTestRequest())->updateRules($this->id);
        }
    }

    public function validateField($field)
    {
        $this->validateOnly($field);
    }


    public function render()
    {
        $this->datas = Test::all();
        return view('livewire.test.main');
    }
    public function refresh()
    {
        $this->datas = Test::all();
    }


    private function resetInputFields(){
        $this->name = '';
        $this->roll = '';
    }
    public function create()
    {
        $this->createMode = true;
    }
    public function store()
    {

        $validatedData = $this->validate();
  
        Test::create([
            'name' => $validatedData['name'],
            'roll' => $validatedData['roll'],
            'created_by' => admin()->id,
        ]);

        $this->createMode = false;
        session()->flash('message', 'Documentation Created Successfully.');
        $this->resetInputFields();
    }

    public function show(int $id)
    {
        $data = Test::find($id);
        if($data){

            $this->id = $data->id;
            $this->name = $data->name;
            $this->roll = $data->roll;
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
        $data = Test::findOrFail($id);
        $this->id = $data->id;
        $this->name = $data->name;
        $this->roll = $data->roll;
  
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
  

        Test::find($this->id)->fill([
            'name'=>$validatedData['name'],
            'roll'=>$validatedData['roll'],
            'updated_by' => admin()->id,
        ])->save();

        $this->updateMode = false;
  
        session()->flash('message', 'Test Updated Successfully.');
        $this->resetInputFields();
    }
    public function delete($id)
    {
        Test::find($id)->delete();
        session()->flash('message', 'Test Deleted Successfully.');
    }
    
}
