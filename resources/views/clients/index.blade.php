<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clients') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-scroll shadow-xl sm:rounded-lg p-2">
                <table class="table table-hover" id="data-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Address</th>
                            <th scope="col">Country</th>
                            <th scope="col">EUR for 1 kW</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <th scope="col">{{$client->id}}</th>
                                <td scope="col">{{$client->address}}</td>
                                <td scope="col">{{$client->country}}</td>
                                <td scope="col">0</td>
                                <td scope="col">
                                    <a href="" class="btn btn-sm btn-success">Update</a>
                                    <a href="" class="btn btn-sm btn-danger">Delete</a>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editModal" id="open-update-modal">Open modal for @mdo</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $clients->links() }}
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/bootstrap-table@1.18.3/dist/bootstrap-table.min.js"></script>
    @include('clients.modal.update')
</x-app-layout>
