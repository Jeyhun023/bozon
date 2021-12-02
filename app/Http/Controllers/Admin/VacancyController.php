<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\V1\BlogRequest;
use App\Http\Requests\Admin\V1\VacancyRequest;
use App\Models\Blog;
use App\Models\Vacancy;
use App\Repositories\V1\Others\BlogRepository;
use App\Repositories\V1\Others\VacancyRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VacancyController extends Controller
{
    private $auhtRepository;

    public function __construct(VacancyRepository $auhtRepository)
    {
        $this->auhtRepository = $auhtRepository;
    }

    public function index()
    {
        $vacancies = $this->auhtRepository->index();
        return view('admin.vacancy.index', compact('vacancies'));
    }

    public function create()
    {
        return view('admin.vacancy.create');
    }

    public function store(VacancyRequest $request)
    {
        $result = $this->auhtRepository->store($request->all());
        if (array_key_exists('success', $result)) {
            return Redirect::route('vacancies.index');
        } else {
            \redirect()->back()->withErrors(['danger' => "Xeta bas verdi"]);
        }
    }

    public function show($id)
    {
        //
    }

    public function edit(Vacancy $vacancy)
    {
        return view('admin.vacancy.edit', compact('vacancy'));
    }

    public function update(VacancyRequest $request, $vacancy)
    {
        $this->auhtRepository->update($vacancy, $request->all());
        return Redirect::route('vacancies.index');
    }

    public function destroy($vacancy)
    {
        $this->auhtRepository->destroy($vacancy);
        return Redirect::route('vacancies.index');
    }

    public function destroyAllSelections(Request $request)
    {
        $request->validate(['keys' => 'present']);
        if ($request->keys) {
            $array = explode(',', $request->keys);
            foreach (Vacancy::whereIn('id', $array)->get() as $item) {
                $this->auhtRepository->destroy($item->id);
            }
        }
        return response()->json(['message' => 'Əməliyyat uğurla tamamlandı.'], 200);
    }

    public function update_vacancy_visibility(Vacancy $vacancy)
    {
        $vacancy->update([
            'active' => !$vacancy->active
        ]);
        return Redirect::route('vacancies.index');
    }
}
