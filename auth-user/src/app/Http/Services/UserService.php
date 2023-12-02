<?php

namespace App\Http\Services;

use App\Jobs\AuthUserQueueJob;
use App\Jobs\UserRegistered;
use App\Models\Building;
use App\Models\Page;
use App\Models\Album;
use App\Repositories\AlbumRepository;
use App\Repositories\MediaRepository;
use App\Repositories\SeoSectionRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use stdClass;
use Illuminate\Support\Facades\Queue;

class UserService extends _Service
{


    public function __construct(
        protected UserRepository $userRepository,
    ) {
        $this->userRepository = $userRepository;
    }


    protected function create($data)
    {
        try {
            $user = $this->userRepository->create($data->toArray());

            $token = $user->createToken('auth-token');
            $plain_token = $token->plainTextToken;
            $tokenExpiration = $token->accessToken->expires_at;
            UserRegistered::dispatch($user->id,$token->plainTextToken,$tokenExpiration);
            return returnData(
                [],
                Response::HTTP_OK,
                compact('user', 'plain_token'),
                ['Registered Successfully']
            );
        } catch (\Exception $e) {
            dd($e);
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );
        }
    }
    protected function login($data)
    {
        try {
            if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) {
                $user = Auth::user();
                $token =  $user->createToken('auth-token');
                $plain_token = $token->plainTextToken;
                $tokenExpiration = $token->accessToken->expires_at;
                UserRegistered::dispatch($user->id,$token->plainTextToken,$tokenExpiration);

                return returnData(
                    [],
                    Response::HTTP_UNAUTHORIZED,
                    compact('user', 'token'),
                    ['Login Success']
                );
            } else {
                return returnData(
                    ['invalid Credentials'],
                    Response::HTTP_UNAUTHORIZED,
                    [],
                    []
                );
            }
        } catch (\Exception $e) {
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );
        }
    }
    protected function show($album)
    {
        try {
            $album = $this->AlbumRepository->findWith($album->id, ['*'], ['media', 'primary_image_mobile', 'primary_image_desktop', 'seoSection.media']);
            $album->lastAudit = $album->audits()->with('user')->latest()->first();

            return returnData(
                [],
                Response::HTTP_OK,
                compact('album'),
                ['Floor Type']
            );
        } catch (Exception $e) {
            logger(
                [
                    'error' => $e->getMessage(),
                    'code' => $e->getCode(),
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                ]
            );
        }
    }
}
