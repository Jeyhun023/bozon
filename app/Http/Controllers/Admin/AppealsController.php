<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appeals;
use App\Models\ContactForm;
use App\Models\Vacancy;
use App\Repositories\V1\Contracts\AppealsRepositoryInterface;
use App\Repositories\V1\Contracts\ContactFormRepositoryInterface;
use App\Repositories\V1\Others\VacancyRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class AppealsController extends Controller
{
    private $auhtRepository;

    public function __construct(AppealsRepositoryInterface $auhtRepository)
    {
        $this->auhtRepository = $auhtRepository;
    }

    public function index()
    {
        $contact = $this->auhtRepository->index();
        return view('admin.appeals.index', compact('contact'));
    }

    public function destroy($appeal)
    {
        $this->auhtRepository->destroy($appeal);
        return Redirect::route('appeals.index');
    }

    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'nullable']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            Appeals::whereIn('id', $array)->delete();
        }
        return Redirect::route('appeals.index');
    }

    public function update_status(Appeals $appeal)
    {
        $appeal->update([
            'kept_contact' => !$appeal->kept_contact
        ]);
        return Redirect::route('appeals.index');
    }
}
