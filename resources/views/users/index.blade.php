<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-scroll shadow-xl sm:rounded-lg p-2">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Balance EUR</th>
                            <th scope="col">Balance kW</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <th scope="col">{{$user->id}}</th>
                                <th scope="col">{{$user->name}}</th>
                                <th scope="col">{{$user->email}}</th>
                                <th scope="col">{{$user->balance_eur}}</th>
                                <th scope="col">{{$user->balance_kv}}</th>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
