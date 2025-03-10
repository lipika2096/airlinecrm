<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DelayCodeCategory;
use App\Models\Destination;
use App\Models\Origin;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function delaycategory()
    {
        $ddcategories = DelayCodeCategory::all();
        return view('admin.delay-code-category', compact('ddcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'delay_code' => 'required|string|max:255',
            'delay_type' => 'required|string|max:255',
        ]);

        DelayCodeCategory::create($request->all());

        return redirect()->route('admin.delay.code.category')
            ->with('success', 'Delay Code Category created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'delay_code' => 'required|string|max:255',
            'delay_type' => 'required|string|max:255',
        ]);

        $category = DelayCodeCategory::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.delay.code.category')
            ->with('success', 'Delay Code Category updated successfully.');
    }

    public function destroy($id)
    {
        $category = DelayCodeCategory::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.delay.code.category')
            ->with('success', 'Delay Code Category deleted successfully.');
    }

    public function origin()
    {

        $origins = Origin::all();
        return view('admin.origin', compact('origins'));

    }


    public function originstore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Origin::create($request->all());
        return redirect()->route('admin.origin')->with('success', 'Destination added successfully.');
    }

    public function originupdate(Request $request, Origin $origin)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $origin->update($request->all());
        return redirect()->route('admin.origin')->with('success', 'Destination updated successfully.');
    }

    public function origindestroy(Origin $origin)
    {
        $origin->delete();
        return redirect()->route('admin.origin')->with('success', 'Destination deleted successfully.');
    }


    public function destination()
    {
        $destinations = Destination::all();
        return view('admin.destination', compact('destinations'));

    }
    public function destinationstore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Destination::create($request->all());
        return redirect()->route('admin.destination')->with('success', 'Destination added successfully.');
    }


    public function destinationupdate(Request $request, Destination $destination)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $destination->update($request->all());
        return redirect()->route('admin.destination')->with('success', 'Destination updated successfully.');
    }

    public function destinationdestroy(Destination $destination)
    {
        $destination->delete();
        return redirect()->route('admin.destination')->with('success', 'Destination deleted successfully.');
    }

    public function categoriesIndex()
    {
        // Add your logic for categories view
        $categories = Category::where('created_by', auth('admin')->user()->id)->latest()->get();

        return view('admin.categories', compact('categories')); // Example view path, adjust as per your structure
    }

    public function storeCategory(Request $request)
    {
        // Add your logic for categories store
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|max:255'
        ]);

        $category = new Category();
        $category->name = $request->name;
        $category->created_by = auth('admin')->user()->id;
        $category->save();

        return redirect()->route('admin.categories.view')->with('success', 'Category created successfully.');
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::findorFail($id);
        $category->name = $request->name;
        $category->updated_by = auth('admin')->user()->id;
        $category->save();

        return redirect()->route('admin.categories.view')->with('success', 'Category updated successfully.');
    }

    public function updateStatus(Request $request)
    {
        $category = Category::find($request->id);
        if ($category) {
            $category->status = $request->status;
            $category->save();
            return response()->json(['success' => 'Status updated successfully.']);
        }
        return response()->json(['error' => 'Category not found.'], 404);
    }

}
