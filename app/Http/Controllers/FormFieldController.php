<?php

namespace App\Http\Controllers;

use App\Models\FormField;
use Illuminate\Http\Request;
use App\Jobs\SendFormCreationNotification;
use Illuminate\Support\Facades\Mail;
use App\Mail\NotificationEmail;

class FormFieldController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fields = FormField::all();
        return view('home', compact('fields'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fields.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'label' => 'required|string',
            'type' => 'required|string',
            'options.*' => 'nullable|string',
        ]);

        $field = new FormField();
        $field->label = $validatedData['label'];
        $field->type = $validatedData['type'];
        if ($validatedData['type'] == 'select') {
            $field->options = json_encode($validatedData['options']);
        }
        $field->save();

        try {
            SendFormCreationNotification::dispatch()->onQueue('emails');
            return redirect()->route('home')->with('success', 'Field created successfully.');
        } catch (\Exception $e) {
            dd($e);
            return redirect()->back()->with('error', 'Failed to send email. ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(FormField $formField)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $field = FormField::find($id);
        return view('fields.edit', compact('field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,number,select',
            'options.*' => 'nullable|string',
        ]);

        $field = FormField::findOrFail($id);
        $field->label = $request->input('label');
        $field->type = $request->input('type');
        if ($validatedData['type'] == 'select') {
            $field->options = $request->input('options') ? json_encode($request->input('options')) : null;
        }
        $field->save();

        return redirect()->route('home')->with('success', 'Field updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $formField = FormField::find($id);
        $formField->delete();
        return response()->json(['success' => true, 'message' => 'Field deleted successfully']);
    }
}
