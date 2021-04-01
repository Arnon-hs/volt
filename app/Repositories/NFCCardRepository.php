<?php

namespace App\Repositories;

use App\Models\NFCCard;

class NFCCardRepository
{
    /**
     * @var NFCCard
     */
    protected $nfc_card;

    /**
     * NFCCardRepository constructor.
     * @param NFCCard $nfc_card
     */
    public function __construct(NFCCard $nfc_card)
    {
        $this->nfc_card = $nfc_card;
    }

    /**
     * Show nfc_card by id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->nfc_card->where('id', $id)->get();
    }

    /**
     * Save NFCCard
     * @param $data
     * @return mixed
     */
    public function save($data)
    {
        $nfc_card = new $this->nfc_card;

        $nfc_card->sak = $data['sak'];
        $nfc_card->uid = $data['uid'];
        $nfc_card->user_id = $data['user_id'];

        $nfc_card->save();

        return $nfc_card->fresh();
    }

    /**
     * Update NFCCard
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        $nfc_card = $this->nfc_card->find($id);

        $nfc_card->sak = $data['sak'];
        $nfc_card->uid = $data['uid'];
        $nfc_card->user_id = $data['user_id'];

        $nfc_card->update();

        return $nfc_card->fresh();
    }

    /**
     * Delete nfc_card
     * @param $id
     * @return mixed
     */
    public function deleteNFCCardById($id)
    {
        $nfc_card = $this->nfc_card->find($id);
        $nfc_card->delete();

        return $nfc_card;
    }
}