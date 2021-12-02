<?php


namespace App\Repositories\V1\Others;


use App\Models\ContactForm;
use App\Repositories\V1\Contracts\ContactFormRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Pipeline\Pipeline;

class ContactFormRepository implements ContactFormRepositoryInterface
{
    use ApiResponder;

    public function index()
    {
        $con = ContactForm::query()->orderBy('created_at', 'desc');

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
        $contact = new ContactForm;
        $contact->fill($data);
        $contact->save();
        $this->message = trans('messages.created');

        return $this->returnData();
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
        $con = ContactForm::where('id', $id)->first();
        abort_if(!$con, 404);
        $con->delete();
    }
}
