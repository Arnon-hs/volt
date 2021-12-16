<?php

namespace App\Services;

use App\Events\ChangePriceAtTheClient;
use App\Repositories\ClientRepository;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ClientService
{
    /**
     * @var ClientRepository
     */
    protected $clientRepository;

    /**
     * ClientService constructor.
     * @param ClientRepository $clientRepository
     */
    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * Authentication client
     * @param $data
     * @return array
     */
    public function authClient($data)
    {
        $validator = Validator::make($data, [
            'sa' => 'required|size:2', // SAK NFC карты
            'id' => 'required|max:20', // UID NFC карты
            'ct' => 'required' // Таймстамп отправки запроса
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        try{
            $result = $this->clientRepository->authClient($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            throw new InvalidArgumentException('Unable to auth client data');
        }

        return $result;
    }

    /**
     * Statistic client
     * @param $data
     * @return array
     */
    public function statClient($data)
    {
        $validator = Validator::make($data, [
            'ct' => 'required', // Таймстамп отправки запроса
            'vi' => 'required|integer|numeric', // Напряжение в сети
            'id' => 'required', // ID клиента
            'tc' => 'required|integer|numeric', //  Температура
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->clientRepository->statClient($data);

        return $result;
    }

    /**
     * Get client by id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->clientRepository->getById($id);
    }

    /**
     * Save Client Data
     * @param $data
     * @return mixed
     */
    public function saveClientData($data)
    {
        $validator = Validator::make($data, [
            'address' => 'required|min:2|max:200',
            'id' => 'required|unique:clients',
            'price' => 'nullable|regex:/^\d*(\.\d{2})?$/',
            'country' => 'required|min:2|max:2'// iso2
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->clientRepository->save($data);

        ChangePriceAtTheClient::dispatch($result);

        return $result;
    }

    /**
     * Update Client data
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updateClientData($data, $id)
    {
        $validator = Validator::make($data, [
            'address' => 'required|min:2|max:200',
            'id' => 'required',//временно |unique:clients
            'price' => 'nullable|regex:/^\d*(\.\d{2})?$/',
            'country' => 'required|min:2|max:2'// iso2
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try{
            $client = $this->clientRepository->update($data, $id);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            throw new InvalidArgumentException('Unable to update client data');
        }

        DB::commit();

        ChangePriceAtTheClient::dispatch($client);

        return $client;
    }

    /**
     * Delete Client by id
     * @param $id
     * @return mixed
     */
    public function deleteClientById($id)
    {
        DB::beginTransaction();

        try{
            $client = $this->clientRepository->deleteClientById($id);
        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());

            throw new InvalidArgumentException('Unable to delete client');
        }

        DB::commit();

        return $client;
    }
}