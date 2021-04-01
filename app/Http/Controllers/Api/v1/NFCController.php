<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NFCCardService;

class NFCController extends Controller
{
    /**
     * @var NFCCardService
     */
    protected $nfc_cardService;

    /**
     * NFCCardController constructor.
     * @param NFCCardService $nfc_cardService
     */
    public function __construct(NFCCardService $nfc_cardService)
    {
        $this->nfc_cardService = $nfc_cardService;
    }

    /**
     * Show nfc_card by id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $result = ['status' => 200];

        try {
            $result['data'] = $this->nfc_cardService->getById($id);
        } catch (\Exception $e){
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Store NFCCard
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = $request->only([
//            'id',
            'uid',
            'sak',
            'user_id'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->nfc_cardService->saveNFCCardData($data);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Update NFCCard
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $data = $request->only([
            'id',
            'uid',
            'sak',
            'user_id'
        ]);

        $result = ['status' => 200];

        try {
            $result['data'] = $this->nfc_cardService->updateNFCCardData($data, $data['id']);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }

    /**
     * Delete nfc_card
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete($id)
    {
        $result = ['status' => 201];

        try {
            $result['data'] = $this->nfc_cardService->deleteNFCCardById($id);
        } catch (\Exception $e) {
            $result = [
                'status' => 500,
                'error' => $e->getMessage()
            ];
        }

        return response()->json($result, $result['status']);
    }
}
