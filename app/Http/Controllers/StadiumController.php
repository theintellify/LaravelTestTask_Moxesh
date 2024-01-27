<?php

// app/Http/Controllers/StadiumController.php
namespace App\Http\Controllers;

use App\Http\Requests\StadiumRequest;
use App\Http\Requests\StadiumUpdateRequest;
use App\Models\AdvertisingSection;
use App\Models\Stadium;
use Illuminate\Http\Request;

class StadiumController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $stadiums = Stadium::where('user_id', $user_id)->get();
//        $stadiums = Stadium::where('user_id', $user_id)->paginate(1);
        return view('stadiums.index', compact('stadiums'));
    }

    public function create()
    {
        return view('stadiums.create');
    }

    public function store(StadiumRequest $request)
    {
        $user_id = auth()->user()->id;
        $data = $request->validated();
        $data['user_id'] = $user_id;

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName); // Assuming uploads directory in public folder
            $data['file'] = $fileName;
        }

        Stadium::create($data);

        return redirect()->route('stadiums.index')->with('success', 'Stadium created successfully');
    }

    public function edit(Stadium $stadium)
    {
        $user_id = auth()->user()->id;
        // Check if the authenticated user is the owner of the stadium
        if ($user_id !== $stadium->user_id) {
            // Redirect or show an error message as appropriate
            return redirect()->route('stadiums.index')->with('error', 'You do not have permission to edit this stadium.');
        }

        return view('stadiums.edit', compact('stadium'));
    }

    public function update(StadiumUpdateRequest $request, $id)
    {
        $stadium = Stadium::findOrFail($id);

        $data = $request->validated();

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName); // Assuming uploads directory in public folder
            $data['file'] = $fileName;
            if ($stadium->file) {
                unlink("uploads/$stadium->file");
            }
        } else {
            $data['file'] = $stadium->file;
        }

        $stadium->update($data);

        return redirect()->route('stadiums.index')->with('success', 'Stadium updated successfully');
    }

    public function destroy(Stadium $stadium)
    {
        $stadium->delete();

        return redirect()->route('stadiums.index')->with('success', 'Stadium deleted successfully');
    }

    public function show($id)
    {
        $user_id = auth()->user()->id;
        $stadium = Stadium::find($id);

        // Check if the authenticated user is the owner of the stadium
        if ($user_id !== $stadium->user_id) {
            // Redirect or show an error message as appropriate
            return redirect()->route('stadiums.index')->with('error', 'You do not have permission to edit this stadium.');
        }

        $advertisingSections = AdvertisingSection::where(['user_id' => $user_id, 'stadium_id' => $id])->get();

        return view('advertising-sections.index', compact('advertisingSections'));
    }
}
