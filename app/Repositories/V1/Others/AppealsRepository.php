<?php


namespace App\Repositories\V1\Others;


use App\Models\Appeals;
use App\Models\ContactForm;
use App\Repositories\V1\Contracts\AppealsRepositoryInterface;
use App\Repositories\V1\Contracts\ContactFormRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Pipeline\Pipeline;

class AppealsRepository implements AppealsRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        $con = Appeals::query()->orderBy('created_at', 'desc');

        $con = app(Pipeline::class)
            ->send($con)
            ->through([
                \App\QueryFilters\FullName::class
            ])
            ->thenReturn()
            ->paginate(getPaginationLimit());
        return $con;
    }

    public function store(array $data)
    {
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
    }

    public function destroy(int $id)
    {
        $con = Appeals::where('id', $id)->first();
        abort_if(!$con, 404);
        $con->delete();
    }
}
