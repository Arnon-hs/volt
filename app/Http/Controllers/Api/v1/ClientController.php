<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Services\ClientService;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * @var ClientService 
     */
    protected $clientService;

    /**
     * ClientController constructor.
     * @param ClientService $clientService
     */
    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    /**
     * Client authorization
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function auth(Request $request)
    {
        //todo clickhouse stat

        $data = $request->only([
            'sa',
            'id',
            'ct'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->clientService->authClient($data);
        } catch (\Exception $e) {
            $result = [
                'status' => 401,
                'data' => [
                    'cc' => 0,
                    'ha' => 'Call 069878787...'
                ]
            ];
        }

        return response()->json($result['data'], $result['status']);
    }

    /**
     * Client statistic
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function stat(Request $request)
    {
        $data = $request->only([
            'vi', // Напряжение в сети
            'id', // ID клиента
            'tc', // Температура
            'ct' // Таймстамп отправки запроса
        ]);

        $result = ['status' => 201];

        try {
            $result['data'] = $this->clientService->statClient($data);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Show client by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->clientService->getById($id);
        } catch (\Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Store Client
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only([
            'address',
            'country',
            'price',
            'id'
        ]);
        //todo расчитать цену в киловатах
        $result = ['status' => 200];

        try {
            $result['data'] = $this->clientService->saveClientData($data);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Update Client
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->only([
            'price',
            'address',
            'country',
            'id'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->clientService->updateClientData($data, $data['id']);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Delete client
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $result = ['status' => 201];

        try {
            $result['data'] = $this->clientService->deleteClientById($id);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
