<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentLibrary;
use App\Models\LibraryDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Add this import
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;


class AgentLibraryController extends Controller
{
    public function index()
    {
        $agents = Agent::all();
        $libraries = AgentLibrary::with('agent')->get(); // Fetch libraries with related airlines
        return view('admin.agent-library', compact('agents', 'libraries'));
    }

    public function store(Request $request)
    {

        $fileNames = []; // Array to hold the filenames

        if ($request->hasFile('documents')) {
            $docFiles = $request->file('documents');

            foreach ($docFiles as $docFile) {
                // Generate a unique file name with extension
                $fileName = Str::uuid() . '.' . $docFile->getClientOriginalExtension();

                $storagePath = ('public/assets/docs/');

                // Check if the directory exists, if not create it
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true, true);
                }

                // Move the file to the defined path
                $docFile->move($storagePath, $fileName);

                // Add the filename to the array
                $fileNames[] = asset('public/assets/docs/')."/".$fileName;
            }
        }
        // Convert array to a JSON string or comma-separated string
        $fileNamesString = json_encode($fileNames); // Use this if you prefer JSON format

        $library = AgentLibrary::create([
            'agent_id' => $request->input('agent_id'),
            'doc_name' => 'null',
            'attachment' => $fileNamesString, // Store filenames as JSON string
            'uploaded_by' => auth()->user()->id,
        ]);

        return redirect()->back();
    }

    public function viewDocuments($libraryId)
    {
        $library = AirlineLibrary::with('documents')->findOrFail($libraryId);
        return view('admin.view-documents', compact('library'));
    }
}
