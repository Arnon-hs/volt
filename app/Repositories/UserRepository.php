<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    /**
     * @var User
     */
    protected $user;

    /**
     * UserRepository constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Show user by id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->user->where('id', $id)->get();
    }

    /**
     * Save User
     * @param $data
     * @return mixed
     */
    public function save($data)
    {
        $user = new $this->user;

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->balance_eur = $data['balance_eur'];
//        $user->balance_kv = $data['balance_kv'];
        $user->password = Hash::make($data['password']);

        $user->save();

        return $user->fresh();
    }

    /**
     * Update User
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        $user = $this->user->find($id);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->balance_eur = $data['balance_eur'];
        $user->balance_kv = $data['balance_kv'];
//        $user->password = Hash::make($data['password']);

        $user->update();
        return $user->fresh();
    }

    /**
     * Delete user
     * @param $id
     * @return mixed
     */
    public function deleteUserById($id)
    {
        $user = $this->user->find($id);
        $user->delete();

        return $user;
    }
}