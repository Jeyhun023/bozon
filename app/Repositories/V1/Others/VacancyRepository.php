<?php


namespace App\Repositories\V1\Others;


use App\Models\Banner;
use App\Models\Blog;
use App\Models\Stores;
use App\Models\User;
use App\Models\Vacancy;
use App\Repositories\V1\Contracts\BannerRepositoryInterface;
use App\Repositories\V1\Contracts\BlogRepositoryInterface;
use App\Repositories\V1\Contracts\CrudInterface;
use App\Repositories\V1\Contracts\VacancyRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class VacancyRepository implements VacancyRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        $vacancy = Vacancy::query()->orderBy('created_at', 'desc');

        $vacancy = app(Pipeline::class)
            ->send($vacancy)
            ->through([
                \App\QueryFilters\Position::class
            ])
            ->thenReturn()
            ->paginate(getPaginationLimit());
        return $vacancy;
    }

    public function store(array $data)
    {
        $vacancy = new Vacancy();
        $data = request()->except('_token');

        $data['slug'] = Str::slug($data['position']);
        $data['active'] = isset($data['active']) ? ($data['active'] == 'on' ? true : false) : false;
        $vacancy->fill($data);
        $vacancy->save();
        return ['success' => "Ugurla Elave olundu"];
    }

    public function show($slug)
    {
        $vacancy = Vacancy::firstWhere('slug',$slug);

        if ($vacancy){
            $this->data = $vacancy;
        } else {
            $this->status = JsonResponse::HTTP_NOT_FOUND;
            $this->message = trans('messages.model_not_found');
        }

        return $this->returnData();
    }

    public function update(int $id, array $data)
    {
        $vacancy = Vacancy::where('id', $id)->first();
        abort_if(!$vacancy, 404);
        $data['active'] = isset($data['active']) ? ($data['active'] == 'on' ? true : false) : false;
        $data['slug'] = Str::slug($data['position']);
        $vacancy->fill($data);
        $vacancy->save();
        return response()->json(['success' => "Ugurla Redacte olundu"]);
    }

    public function destroy(int $id)
    {
        $vacancy = Vacancy::where('id', $id)->first();
        abort_if(!$vacancy, 404);
        $vacancy->delete();
    }

    public function getAllActiveVacancies()
    {
       $vacancies = Vacancy::where('active',1)->orderBy('sira','asc')->paginate(getPaginationLimit());
       $this->data = $vacancies;

       return $this->returnData();
    }
}
