<?php


namespace App\Repositories\V1\Others;


use App\Models\File;
use App\Repositories\V1\Contracts\FileRepositoryInterface;
use App\Traits\ApiResponder;
use App\Traits\FileUpload;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class FileRepository implements FileRepositoryInterface
{
    use FileUpload, ApiResponder;

    public function uploadFile($type, $data)
    {
        $type = $type == 'product' ? 'App\Models\Product' : $type;
        $file = $data['file'];
        $path = $this->upload('products',$file,false);
        if (Session::has('uid')) {
            $uuid = Session::get('uuid');
        } else {
            $uuid = Str::uuid();
            Session::put('uuid', $uuid);
        }
        $f = File::query()->create([
            'model_id' => null,
            'model_type' => $type,
            'name' =>  $path,
        ]);
        $this->data = $f->id;
        return $this->returnData();
    }
}
