<?php

namespace App\Livewire;

use App\Http\Requests\LivewireTestRequest;
use Livewire\Component;
use App\Models\LivewireTest as Test;
use Livewire\WithPagination;
use App\Exports\FileExports;
use Barryvdh\DomPDF\PDF;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;

class LivewireTest extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $name, $roll, $id, $created_user, $creation_date, $updated_user, $updated_date, $search, $size="10";
    public $updateMode = false;
    public $createMode = false;


    // public function exportPdf()
    // {
    //     $data = Test::all(); // Replace YourModel with the actual model you are using

    //     $pdf = PDF::loadView('path.to.pdf.view', compact('data'));

    //     return $pdf->download('export.pdf');
    // }
    // public function export($format)
    // {
    //     $model = Test::class; // Replace with your actual model class

    //     switch ($format) {
    //         case 'excel':
    //             return Excel::download(new FileExports($model), 'export.xlsx');
    //         case 'csv':
    //             return Excel::download(new FileExports($model), 'export.csv');
    //         // Add more cases for other export formats if needed
    //         default:
    //             abort(404);
    //     }
    // }

    // public function downloadFile($fileId, $format)
    // {
    //     $file = Test::findOrFail($fileId);

    //     switch ($format) {
    //         case 'csv':
    //             return $this->downloadCsv($file);
    //         case 'pdf':
    //             return $this->downloadPdf($file);
    //         case 'excel':
    //             return $this->downloadExcel($file);
    //         default:
    //             // Handle unsupported format
    //             break;
    //     }
    // }

    // private function downloadCsv($file)
    // {
    //     $csvData = []; // Replace this with your CSV data array or logic
    //     $csvFileName = 'file_' . $file->id . '.csv';

    //     $csv = implode(',', array_keys($csvData[0])) . PHP_EOL;
    //     foreach ($csvData as $data) {
    //         $csv .= implode(',', $data) . PHP_EOL;
    //     }

    //     return response($csv)
    //         ->header('Content-Type', 'text/csv')
    //         ->header('Content-Disposition', 'attachment; filename="' . $csvFileName . '"');
    // }

    // private function downloadPdf($file)
    // {
    //     $pdf = PDF::loadView('livewire.file-pdf', compact('file'));

    //     return $pdf->download('file_' . $file->id . '.pdf');
    // }

    // private function downloadExcel($file)
    // {
    //     return Excel::download(new FileExports('Test'), 'file_' . $file->id . '.xlsx');
    // }








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
        $data['datas'] = Test::latest()
        ->where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('roll', 'like', '%' . $this->search . '%');
        })
        ->paginate($this->size);

        $data['total_data'] = Test::count();

        return view('livewire.test.main', $data);
    }
    public function refresh()
    {
        $data['datas'] = Test::latest()
        ->where(function ($query) {
            $query->where('name', 'like', '%' . $this->search . '%')
                ->orWhere('roll', 'like', '%' . $this->search . '%');
        })
        ->paginate($this->size);

        $data['total_data'] = Test::count();

        return view('livewire.test.main', $data);
    }


    private function resetInputFields(){
        $this->name = '';
        $this->roll = '';
        $this->reset(['search', 'size']);
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
