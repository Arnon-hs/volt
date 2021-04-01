<?php

namespace App\Repositories;

use App\Models\Client;
use App\Models\NFCCard;
use App\Models\Statistic;
use Carbon\Carbon;

class ClientRepository
{

    /**
     * @var Client
     */
    protected $client;

    /**
     * ClientRepository constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Authentication client
     * @param $data
     * @return array
     */
    public function authClient($data)
    {
        $nfc = NFCCard::where([
            'sak' => $data['sa'],
            'uid' => $data['id']
        ])->get()->first();

        $client = $nfc->client();
        $permission = $client->balance_eur > 0 ? 1 : 0;
        $balance_cent = $client->balance_eur * 100;

        return [
            'cc' => $permission, // Разрешение на заправку
            'bk' => $client->balance_kv, // Остаток баланса в киловатах
            'br' => $balance_cent, // Остаток баланса в EUR cent
            'ha' => $client->name, // Имя клиента
            'st' => time() // Таймстап формирования ответа
        ];
    }

    /**
     * Stat client
     * @param $data
     * @return mixed
     */
    public function statClient($data)
    {
        $stat = new Statistic();

        $stat->fill([
            'client_id' => $data['id'],
            'temperature' => $data['tc'],
            'mains_voltage' => $data['vi'],
            'timestamp' => Carbon::createFromTimestamp($data['ct'])->toDateTimeString()
        ]);

        $stat->save();

        return $stat;
    }

    /**
     * Show client by id
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->client->where('id', $id)->get();
    }

    /**
     * Save Client
     * @param $data
     * @return mixed
     */
    public function save($data)
    {
        $client = new $this->client;

        $client->address = $data['address'];
        $client->id = $data['id'];
        $client->price = $data['price'];
        $client->country = $data['country'];

        $client->save();

        return $client->fresh();
    }

    /**
     * Update Client
     * @param $data
     * @param $id
     * @return mixed
     */
    public function update($data, $id)
    {
        $client = $this->client->find($id);

        $client->address = $data['address'];
        $client->id = $data['id'];
        $client->price = $data['price'];
        $client->country = $data['country'];

        $client->update();
        return $client->fresh();
    }

    /**
     * Delete client
     * @param $id
     * @return mixed
     */
    public function deleteClientById($id)
    {
        $client = $this->client->where('id', $id);
        $client->delete();

        return $client;
    }
}