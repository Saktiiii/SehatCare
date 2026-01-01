@extends('app')
@section('breadcrumb')
Edit Users
@endsection
@section('content')
<div class="content">

    <h2 class="text-lg font-medium mt-8">Edit User</h2>

    <div class="box p-5 mt-5">

        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div>
                <label>Nama</label>
                <input type="text"
                       name="name"
                       value="{{ $user->name }}"
                       class="input w-full border mt-2"
                       required>
            </div>

            <!-- Email -->
            <div class="mt-3">
                <label>Email</label>
                <input type="email"
                       name="email"
                       value="{{ $user->email }}"
                       class="input w-full border mt-2"
                       required>
            </div>

            <!-- Password (Opsional) -->
            <div class="mt-3">
                <label>Password (Kosongkan jika tidak diganti)</label>
                <input type="password"
                       name="password"
                       class="input w-full border mt-2"
                       placeholder="******">
            </div>

            <!-- Role -->
            <div class="mt-3">
                <label>Role</label>
                <select name="role"
                        class="input w-full border mt-2"
                        required>
                    <option value="admin" {{ $user->role=='admin'?'selected':'' }}>Admin</option>
                    <option value="dokter" {{ $user->role=='dokter'?'selected':'' }}>Dokter</option>
                    <option value="petugas" {{ $user->role=='petugas'?'selected':'' }}>Petugas</option>
                    <option value="nakes" {{ $user->role=='nakes'?'selected':'' }}>Nakes</option>
                </select>
            </div>

            <!-- Button -->
            <div class="mt-5 flex gap-3">
                <button class="button bg-theme-1 text-white">
                    Update
                </button>

                <a href="{{ route('user.index') }}"
                   class="button bg-gray-200">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>

@endsection