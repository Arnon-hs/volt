<?php

namespace App\Services;

use App\Repositories\NFCCardRepository;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class NFCCardService
{
    /**
     * @var NFCCardRepository
     */
    protected $nfc_cardRepository;

    /**
     * NFCCardService constructor.
     * @param NFCCardRepository $nfc_cardRepository
     */
    public function __construct(NFCCardRepository $nfc_cardRepository)
    {
        $this->nfc_cardRepository = $nfc_cardRepository;
    }

    /**
     * Get nfc_card by id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->nfc_cardRepository->getById($id);
    }

    /**
     * Save NFCCard Data
     * @param $data
     * @return mixed
     */
    public function saveNFCCardData($data)
    {
        $validator = Validator::make($data, [
            'sak' => 'required|integer|digits:2',
            'uid' => 'required|max:14|unique:nfc_cards',
            'user_id' => 'required|integer|numeric|exists:App\Models\User,id'
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        $result = $this->nfc_cardRepository->save($data);

        return $result;
    }

    /**
     * Update NFCCard data
     * @param $data
     * @param $id
     * @return mixed
     */
    public function updateNFCCardData($data, $id)
    {
        $validator = Validator::make($data, [
            'sak' => 'required|integer|digits:2',
            'uid' => 'required|max:14',//|unique:nfc_cards
            'user_id' => 'required|integer|numeric|exists:App\Models\User,id',
            'id' => 'required|integer|numeric|exists:nfc_cards,id'
        ]);

        if($validator->fails()) {
            throw new InvalidArgumentException($validator->errors()->first());
        }

        DB::beginTransaction();

        try{
            $nfc_card = $this->nfc_cardRepository->update($data, $id);
        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error($e->getMessage());

            throw new InvalidArgumentException('Unable to update nfc_card data');
        }

        DB::commit();

        return $nfc_card;
    }

    /**
     * Delete NFCCard by id
     * @param $id
     * @return mixed
     */
    public function deleteNFCCardById($id)
    {
        DB::beginTransaction();

        try{
            $nfc_card = $this->nfc_cardRepository->deleteNFCCardById($id);
        } catch (\Exception $e){
            DB::rollBack();
            Log::error($e->getMessage());

            throw new InvalidArgumentException('Unable to delete nfc_card');
        }

        DB::commit();

        return $nfc_card;
    }
}