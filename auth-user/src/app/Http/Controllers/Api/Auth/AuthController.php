<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Http\Services\UserService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(
        protected UserService $userService,
    ) {
        $this->userService = $userService;
    }
    public function register(RegisterRequest $request)
    {
        $response = $this->userService->create($request->validated());
        return  $this->setCode($response['code'])->setMessages($response['messages'])->setData($response['data'])->customResponse();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function login(LoginRequest $request)
    {
        $response = $this->userService->login($request->validated());
        return  $this->setCode($response['code'])->setErrors($response['errors'])->setMessages($response['messages'])->setData($response['data'])->customResponse();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
