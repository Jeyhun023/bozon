<?php


namespace App\Repositories\V1\User;


use App\Models\Banner;
use App\Models\RoleUser;
use App\Models\Token;
use App\Models\User;
use App\Repositories\V1\Contracts\AuthRepositoryInterface;
use App\Traits\ApiResponder;
use Illuminate\Http\JsonResponse;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{
    use ApiResponder;

    /**
     * @param array $credentials
     * @return array
     */
    public function login(array $credentials): array
    {
        if (auth()->attempt($credentials)) {
            $token = auth()->user()->createToken('user-token')->accessToken;
            $this->data['user'] = auth()->user();
            $this->data['token'] = $token;
        } else {
            $this->status = JsonResponse::HTTP_UNAUTHORIZED;
            $this->message = trans('auth.failed');
        }
        return $this->returnData();
    }

    /**
     * Create user and generate new access token for show dashboard
     * @param array $data
     * @return array
     */
    public function register(array $data): array
    {
        $phoneVerify = Token::where(['phone' => $data['phone_number'], 'used' => 1, 'token_type' => 0])->count();

        if ($phoneVerify) {
            $user = new User;
            $user->fill($data);
            if ($user->save()) {
                $data['user_type'] == "buyer" ? $user->assignRole('buyer') : $user->assignRole('seller');
                $this->status = JsonResponse::HTTP_CREATED;
                $this->message = trans('messages.created');
                $this->data['user'] = $user;
                $this->data['token'] = $user->createToken('user-token')->accessToken;
            } else {
                $this->status = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
                $this->message = trans('messages.failed');
            }
        } else {
            $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            $this->message = trans('auth.verification_code_time', ['phone' => $data['phone_number']]);
        }

        return $this->returnData();
    }

    /**
     *  Send verification code to user number
     * @param string $phone_number
     * @return array
     * @todo create new method and add sms service.
     */
    public function sendCode(string $phone_number,int $tokenType): array
    {
//        date_default_timezone_set('Asia/Baku');
        $verificationCode = Token::select('token', 'created_at')->where(['phone' => $phone_number, 'token_type' => $tokenType])->latest()->first();
        $code = mt_rand(100000, 999999);
        if (!is_null($verificationCode)) {
            if (now()->diffInMinutes($verificationCode->created_at) > 2) {
                Token::create(['phone' => $phone_number, 'token_type' => $tokenType, 'token' => $code]);
                $this->data['code'] = $code;
                $this->data['phone'] = $phone_number;
            } else {
                $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
                $this->message = trans('auth.verification_code_time', ['phone' => $phone_number]);
            }
        } else {
            Token::create(['phone' => $phone_number, 'token_type' => $tokenType, 'token' => $code]);
            $this->data['code'] = $code;
            $this->data['phone'] = $phone_number;
        }

        return $this->returnData();
    }

    /**
     *  Check verification code and update used column if code is correct
     *
     * @param string $phone_number
     * @param string $code
     * @return array
     */
    public function checkVerificationCode(string $phone_number, string $code,int $tokenType): array
    {
        $verificationCode = Token::where(['phone' => $phone_number, 'token_type' => $tokenType, 'used' => 0, 'token' => $code])->first();
        if (!is_null($verificationCode)) {
            $verificationCode->update(['used' => 1]);
            $this->message = trans('auth.phone_verified');
        } else {
            $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            $this->message = trans('auth.verification_code_failed');
        }
        return $this->returnData();
    }


    public function index()
    {
        $users = User::query()->whereHas('roles', function ($query) {
            $query->where('role_id', 2);
        })->orderBy('created_at', 'desc');

        $users = app(Pipeline::class)
            ->send($users)
            ->through([
                \App\QueryFilters\FullName::class,
                \App\QueryFilters\PhoneNumber::class,
                \App\QueryFilters\CreateDate::class,
            ])
            ->thenReturn()
            ->paginate(getPaginationLimit());
        return $users;
    }

    public function store(array $data)
    {
        $user = new User();
        $data = request()->except('_token');
        $data['password'] = Hash::make($data['password']);
        $data['customer_code'] = "BZN" . randString(9);
        $data['ip_address'] = request()->ip();
        $user->fill($data);
        $user->save();
        $user->assignRole('buyer');
        return response()->json(['success' => "Ugurla Elave olundu"]);
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update(int $id, array $data)
    {
        $user = User::where('id', $id)->first();
        abort_if(!$user, 404);
        if (!$data['phone_number']) {
            $data['phone_number'] = $user['phone_number'];
        }
        if ($data['password']) {
            $data['password'] = Hash::make($data['password']);
        } else {
            $data['password'] = $user['password'];
        }
        $user->fill($data);
        $user->save();
        return response()->json(['success' => "Ugurla Elave olundu"]);
    }

    public function destroy(int $id)
    {
        $user = User::where('id', $id)->first();
        abort_if(!$user, 404);
        $user->removeRole('buyer');
        $user->delete();
    }

    public function resetPassword(array $data): array
    {
//        date_default_timezone_set('Asia/Baku');
        $verificationCode = Token::where(['phone' => $data['phone_number'], 'token_type' => 1, 'used' => 1])->latest()->first();
        if (!is_null($verificationCode)) {
//            if (now()->diffInMinutes($verificationCode->created_at) <= 10) {
                $user = User::firstWhere('phone_number',$data['phone_number']);
                if ($user){
                    $user->password = $data['password'];
                    $user->update();

                    $this->message = trans('messages.updated');

                } else {
                    $this->status = JsonResponse::HTTP_NOT_FOUND;
                    $this->message = trans('messages.model_not_found');
                }
//            } else {
//                $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
//                $this->message = trans('auth.verification_code_time', ['phone' => $data['phone_number']]);
//            }
        } else {
            $this->status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
            $this->message = trans('auth.verification_code_failed');
        }

        return $this->returnData();
    }
}
