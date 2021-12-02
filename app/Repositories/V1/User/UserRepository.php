<?php


namespace App\Repositories\V1\User;


use App\Repositories\V1\Contracts\UserRepositoryInterface;
use App\Traits\ApiResponder;
use App\Traits\FileUpload;
use Illuminate\Http\JsonResponse;

class UserRepository implements UserRepositoryInterface
{
    use ApiResponder,FileUpload;

    /**
     * @param array $data
     * @return array
     */
    public function update(array $data): array
    {
        $user = auth()->user();
        if (isset($data['photo'])) {
            if (!is_null($user->photo)){
                $this->deleteImage('users',$user->photo,false);
            }
            $data['photo'] = $this->upload('users',$data['photo'],false);
        }
        $user->fill($data);
        if ($user->isDirty()){
            $this->data = $user;
            $user->update();
            $this->message = trans('messages.updated');
        } else {
            $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            $this->message = trans('messages.not_updated');
        }
        return $this->returnData();
    }


    /**
     * Get Authenticated User
     * @return array
     */
    public function getAuthenticatedUser(): array
    {
        $this->data['user'] = auth()->user();
        return $this->returnData();
    }
}
