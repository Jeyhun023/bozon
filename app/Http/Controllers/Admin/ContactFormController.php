<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactForm;
use App\Models\Vacancy;
use App\Repositories\V1\Contracts\ContactFormRepositoryInterface;
use App\Repositories\V1\Others\VacancyRepository;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    private $auhtRepository;

    public function __construct(ContactFormRepositoryInterface $auhtRepository)
    {
        $this->auhtRepository = $auhtRepository;
    }

    public function index()
    {
        $contact = $this->auhtRepository->index();
        return view('admin.contact_form.index', compact('contact'));
    }

    public function destroy($con)
    {
        $this->auhtRepository->destroy($con);
        return Redirect::route('con.index');
    }

    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'nullable']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            ContactForm::whereIn('id', $array)->delete();
        }
        return Redirect::route('con.index');
    }
}
