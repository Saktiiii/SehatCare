@extends('app')
@section('breadcrumb')
Data Users
@endsection
@section('content')
<div class="content">
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Data User
        </h2>
    
        <a href="{{ route('user.create') }}"
           class="button text-white bg-theme-1 shadow-md">
            + Tambah User
        </a>
    </div>
    
    <!-- BEGIN: Datatable -->
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        <div class="font-medium">{{ $user->name }}</div>
                        <div class="text-gray-600 text-xs">{{ $user->email }}</div>
                    </td>

                    <td>{{ $user->email }}</td>

                    <td class="text-center">
                        <span class="px-2 py-1 rounded text-xs
                            {{ $user->role == 'admin' ? 'bg-theme-9 text-white' : 'bg-gray-200' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>

                    <td class="text-center">
                        <span class="text-theme-9">
                            Active
                        </span>
                    </td>

                    <td class="text-center">
                        <div class="flex justify-center items-center gap-4">
                    
                            <a href="{{ route('user.edit', $user->id) }}"
                               class="text-theme-1 font-medium leading-none">
                                Edit
                            </a>
                    
                            <form action="{{ route('user.destroy', $user->id) }}"
                                  method="POST"
                                  class="m-0 p-0"
                                  onsubmit="return confirm('Yakin hapus user ini?')">
                                @csrf
                                @method('DELETE')
                    
                                <button type="submit"
                                        class="text-theme-6 font-medium leading-none bg-transparent p-0 border-0">
                                    Delete
                                </button>
                            </form>
                    
                        </div>
                    </td>
                    
                    
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Datatable -->
</div>


@endsection