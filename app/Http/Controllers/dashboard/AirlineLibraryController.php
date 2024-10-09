<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Airline;
use App\Models\AirlineLibrary;
use App\Models\LibraryDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File; // Add this import
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;



class AirlineLibraryController extends Controller
{
    public function library()
    {
        $airlines = Airline::all();
        $libraries = AirlineLibrary::with('airline')->get(); // Fetch libraries with related airlines
        return view('admin.library', compact('airlines', 'libraries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
        ]);


        $fileNames = []; // Array to hold the filenames

        if ($request->hasFile('documents')) {
            $docFiles = $request->file('documents');

            foreach ($docFiles as $docFile) {
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

        $library = AirlineLibrary::create([
            'airline_id' => $request->input('airline_id'),
            'doc_name' => $fileNamesString,
            'edition_no' => $request->input('edition_no'),
            'issue_date' => $request->input('issue_date'),
            'attachment' => $fileNamesString,
            'uploaded_by' => auth()->user()->id,
        ]);


        return redirect()->back();
    }

     public function viewstore(Request $request)
    {
        $request->validate([
            'airline_id' => 'required|exists:airlines,id',
        ]);


        $fileNames = []; // Array to hold the filenames

        if ($request->hasFile('documents')) {
            $docFile = $request->file('documents');

            // foreach ($docFiles as $docFile) {
                // Generate a unique file name with extension
                $fileName = Str::uuid() . '.' . $docFile->getClientOriginalExtension();

                // Define the storage path
                $storagePath = ('public/assets/docs/');

                // Check if the directory exists, if not create it
                if (!File::exists($storagePath)) {
                    File::makeDirectory($storagePath, 0755, true, true);
                }

                // Move the file to the defined path
                $docFile->move($storagePath, $fileName);

                // Add the filename to the array
                $fileNames[] = asset('public/assets/docs/')."/".$fileName;
            // }
        }
        // Convert array to a JSON string or comma-separated string
        $fileNamesString = json_encode($fileNames); // Use this if you prefer JSON format

        $library = AirlineLibrary::create([
            'airline_id' => $request->input('airline_id'),
            'doc_name' => $request->input('doc_name'),
            'edition_no' => $request->input('edition_no'),
            'issue_date' => $request->input('issue_date'),
            'attachment' => $fileNamesString,
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
