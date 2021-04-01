<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PharIo\Manifest\ElementCollectionException;

class UserService
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * UserService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get user by id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->userRepository->getById($id);
    }

    /**
     * Save User Data
     * @param $data
     * @return mixed
     */
    public function saveUserData($data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:2',
            'email' => 'required|email|unique:users',
            'balance_eur' => 'nullable|regex:/^\d*(\.\d{2})?$/',
            'balance_kv' => 'nullable|regex:/^\d*(\.\d{2})?$/',
            'password' => 'required|min:6'
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->userRepository->save($data);

        return $result;
    }

    /**
     * Update User data
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updateUserData($data, $id)
    {
        $validator = Validator::make($data, [
            'name' => 'required|min:2',
            'email' => 'required|email',//пока так, костыль |unique:users
            'balance_eur' => 'nullable|regex:/^\d*(\.\d{2})?$/',
            'balance_kv' => 'nullable|regex:/^\d*(\.\d{2})?$/',
            'id' => 'required'
//            'password' => 'required|min:6'
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try{
            $user = $this->userRepository->update($data, $id);
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error($e->getMessage());

            throw new InvalidArgumentException('Unable to update user data');
        }

        DB::commit();

        return $user;
    }

    /**
     * Delete User by id
     * @param $id
     * @return mixed
     */
    public function deleteUserById($id)
    {
        DB::beginTransaction();

        try{
            $user = $this->userRepository->deleteUserById($id);
        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());

            throw new InvalidArgumentException('Unable to delete user');
        }

        DB::commit();

        return $user;
    }
}