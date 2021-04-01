<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\UserService;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Show user by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->userService->getById($id);
        } catch (\Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Store User
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'balance_eur',
            'password'
        ]);
        //todo расчитать цену в киловатах
        $result = ['status' => 200];

        try {
            $result['data'] = $this->userService->saveUserData($data);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Update User
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->only([
            'name',
            'email',
            'balance_eur',
            'balance_kv',
            'id'
//            'password'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->userService->updateUserData($data, $data['id']);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Delete user
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $result = ['status' => 201];

        try {
            $result['data'] = $this->userService->deleteUserById($id);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
