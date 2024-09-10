<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\LicenseApproval;
use Illuminate\Http\Request;

use App\Models\User;
class LicenseApprovalController extends Controller
{
    public function index()
    {
        $staff = User::where('role_id', 2)->get();
        $licenseApprovals = LicenseApproval::with('staff')->get();
        return view('admin.license-approval', compact('licenseApprovals', 'staff'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $licenseApproval = LicenseApproval::findOrFail($id);
        $licenseApproval->status = $request->status;
        $licenseApproval->save();

        return redirect()->route('admin.license')
            ->with('success', 'Status updated successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'staff_id' => 'required|exists:users,id',
            'file' => 'required|file|mimes:pdf,jpg,png',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $directory = public_path('assets/img/license');
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }

        $filePath = $request->file('file')->store('assets/img/license', 'public');

        LicenseApproval::create([
            'staff_id' => $request->staff_id,
            'file' => $filePath,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.license')
            ->with('success', 'License approval created successfully.');
    }

    public function edit(LicenseApproval $licenseApproval)
    {
        $staff = User::where('role_id', 2)->get();
        return view('admin.license-approval.edit', compact('licenseApproval', 'staff'));
    }

    public function update(Request $request, LicenseApproval $licenseApproval)
    {
        $request->validate([
            'staff_id' => 'required|exists:users,id',
            'file' => 'nullable|file|mimes:pdf,jpg,png',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($request->hasFile('file')) {
            $directory = public_path('assets/img/license');
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            Storage::disk('public')->delete($licenseApproval->file);
            $filePath = $request->file('file')->store('assets/img/license', 'public');
            $licenseApproval->file = $filePath;
        }

        $licenseApproval->update($request->only('staff_id', 'status'));

        return redirect()->route('admin.license')
            ->with('success', 'License approval updated successfully.');
    }

    public function destroy(LicenseApproval $licenseApproval)
    {
        Storage::disk('public')->delete($licenseApproval->file);
        $licenseApproval->delete();

        return redirect()->route('admin.license')
            ->with('success', 'License approval deleted successfully.');
    }
}
