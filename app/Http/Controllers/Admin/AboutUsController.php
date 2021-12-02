<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\MagazaUserRequest;
use App\Models\AboutUs;
use App\Repositories\V1\Contracts\MagazaUserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AboutUsController extends Controller
{
    public function edit()
    {
        $about = AboutUs::first();
        return view('admin.about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $about = AboutUs::first();
        $about->update([
            'title1' => $request->title1,
            'title2' => $request->title2,
            'title3' => $request->title3,
            'view_text' => $request->view_text,
            'mission_text' => $request->mission_text,
        ]);
        return Redirect::route('about.edit')->with(['success' => true]);
    }
}
