<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdvertisingSectionUpdateRequest;
use App\Models\AdvertisingSection;
use App\Http\Requests\AdvertisingSectionRequest;
use App\Models\Stadium;
use Illuminate\Http\Request;

class AdvertisingSectionController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
//        $advertisingSections = AdvertisingSection::where('user_id', $user_id)->get();
        $advertisingSections = AdvertisingSection::active()->where('user_id', $user_id)->with('stadium')->get();

        return view('advertising-sections.index', compact('advertisingSections'));
    }

    public function create()
    {
        $user_id = auth()->user()->id;
        $stadiums = Stadium::where('user_id', $user_id)->get();
        return view('advertising-sections.create', compact('stadiums'));
    }

    public function store(AdvertisingSectionRequest $request)
    {
        $user_id = auth()->user()->id;
        $data = $request->validated();
        $data['user_id'] = $user_id;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mime = $request->file('file')->getMimeType();

            if (str_starts_with($mime, 'image')) {
                $fileType = 1; // Image
            } elseif (str_starts_with($mime, 'video')) {
                $fileType = 2; // Video
            } elseif (str_starts_with($mime, 'audio')) {
                $fileType = 3; // Audio
            } else {
                $fileType = 0;
            }

            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('sections'), $fileName); // Assuming uploads directory in public folder
            $data['file'] = $fileName;
            $data['file_type'] = $fileType;
        }
        AdvertisingSection::create($data);

        return redirect()->route('advertising-sections.index')->with('success', 'Advertising Section created successfully');
    }

//    public function edit(AdvertisingSection $section)
//    {
//        $user_id = auth()->user()->id;
//        // Check if the authenticated user is the owner of the section
//        if ($user_id !== $section->user_id) {
//            // Redirect or show an error message as appropriate
//            return redirect()->route('advertising-sections.index')->with('error', 'You do not have permission to edit this advertising section.');
//        }
//
//        return view('advertising-sections.edit', compact('section'));
//    }

    public function edit($id)
    {
        $section = AdvertisingSection::findOrFail($id);
        $user_id = auth()->user()->id;
        // Check if the authenticated user is the owner of the section
        if ($user_id !== $section->user_id) {
            // Redirect or show an error message as appropriate
            return redirect()->route('advertising-sections.index')->with('error', 'You do not have permission to edit this advertising section.');
        }

        $stadiums = Stadium::where('user_id', $user_id)->get();
        return view('advertising-sections.edit', compact('section', 'stadiums'));
    }

    public function update(AdvertisingSectionUpdateRequest $request, $id)
    {
        $section = AdvertisingSection::findOrFail($id);
        // Validate the request
        $data = $request->validated();

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $mime = $file->getMimeType();

            if (str_starts_with($mime, 'image')) {
                $fileType = 1; // Image
            } elseif (str_starts_with($mime, 'video')) {
                $fileType = 2; // Video
            } elseif (str_starts_with($mime, 'audio')) {
                $fileType = 3; // Audio
            } else {
                $fileType = 0;
            }

            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('sections'), $fileName); // Assuming uploads directory in the public folder
            $data['file'] = $fileName;
            $data['file_type'] = $fileType;
            if ($section->file) {
                @unlink("sections/$section->file");
            }
        } else {
            $data['file'] = $section->file;
            $data['file_type'] = $section->file_type;
        }

        // Update the AdvertisingSection
        $section->update($data);

        return redirect()->route('advertising-sections.index')->with('success', 'Advertising Section updated successfully');
    }


    public function updateStatus(Request $request, $id)
    {
        $section = AdvertisingSection::findOrFail($id);

        // Toggle the status based on the current status
        $section->update(['status' => $section->status === 'active' ? 'inactive' : 'active']);

        return redirect()->route('advertising-sections.index')->with('success', 'Advertising Section status updated successfully');
    }

    public function destroy($id)
    {
        $advertisingSection = AdvertisingSection::where('id', $id)->first();
        if ($advertisingSection->file) {
            @unlink("sections/$advertisingSection->file");
        }
        $advertisingSection->delete();
        return redirect()->route('advertising-sections.index')->with('success', 'Advertising Section deleted successfully');
    }
}
