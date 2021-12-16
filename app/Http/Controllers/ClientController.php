<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Services\ClientService;
use Inertia\Inertia;

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

    public function index()
    {
        $clients = Client::all();
        return Inertia::render('Clients/Index', compact('clients'));
    }

    public function show($id)
    {
        $client = $this->clientService->getById($id);

        if(empty($client->id))
            abort(404);

        $stats = \App\Models\Statistic::select(['client_id', 'temperature', 'mains_voltage', 'timestamp'])->where('client_id','=', $id)->getRows();
        return Inertia::render('Clients/Show', compact('client', 'stats'));
    }
}
