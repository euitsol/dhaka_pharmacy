<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DocumentationRequest;
use App\Http\Traits\DetailsCommonDataTrait;
use App\Models\Documentation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DocumentationController extends Controller
{
    use DetailsCommonDataTrait;
    public function __construct()
    {
        return $this->middleware('admin');
    }

    public function index(): View
    {
        $data['docs'] = Documentation::latest()->get();
        return view('admin.documentation.index', $data);
    }
    public function details($id): JsonResponse
    {
        $data = Documentation::with(['created_user', 'updated_user'])->findOrFail($id);
        $data->documentation = html_entity_decode($data->documentation);
        $this->simpleColumnData($data);
        return response()->json($data);
    }
    public function create(): View
    {
        $data['document'] = Documentation::where([['module_key', 'documentation'], ['type', 'create']])->first();
        return view('admin.documentation.create', $data);
    }
    public function store(DocumentationRequest $req): RedirectResponse
    {
        $doc = new Documentation();
        $doc->title = $req->title;
        $doc->module_key = $req->module_key;
        $doc->type = $req->type;
        $doc->documentation = $req->documentation;
        $doc->created_by = admin()->id;
        $doc->save();
        flash()->addSuccess('Documentation created successfully.');
        return redirect()->route('doc.doc_list');
    }
    public function edit($id): View
    {
        $data['document'] = Documentation::where([['module_key', 'documentation'], ['type', 'update']])->first();
        $data['doc'] = Documentation::findOrFail($id);
        return view('admin.documentation.edit', $data);
    }
    public function update(DocumentationRequest $req, $id): RedirectResponse
    {
        $doc = Documentation::findOrFail($id);
        $doc->title = $req->title;
        $doc->module_key = $req->module_key;
        $doc->type = $req->type;
        $doc->documentation = $req->documentation;
        $doc->updated_by = admin()->id;
        $doc->update();
        flash()->addSuccess('Documentation updated successfully.');
        return redirect()->route('doc.doc_list');
    }

    public function delete($id): RedirectResponse
    {
        $doc = Documentation::findOrFail($id);
        $doc->delete();
        flash()->addSuccess('Documentation deleted successfully.');
        return redirect()->route('doc.doc_list');
    }
}
