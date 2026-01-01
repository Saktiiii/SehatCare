@extends('app')
@section('breadcrumb')
Create Users 
@endsection
@section('content')
<div class="content">

    <h2 class="text-lg font-medium mt-8">Tambah User</h2>

    <div class="box p-5 mt-5">

        <form action="{{ route('user.store') }}" method="POST">
            @csrf

            <!-- Nama -->
            <div>
                <label>Nama</label>
                <input type="text"
                       name="name"
                       class="input w-full border mt-2"
                       placeholder="Nama lengkap"
                       required>
            </div>

            <!-- Email -->
            <div class="mt-3">
                <label>Email</label>
                <input type="email"
                       name="email"
                       class="input w-full border mt-2"
                       placeholder="example@gmail.com"
                       required>
            </div>

            <!-- Password -->
            <div class="mt-3">
                <label>Password</label>
                <input type="password"
                       name="password"
                       class="input w-full border mt-2"
                       placeholder="******"
                       required>
            </div>

            <!-- Role -->
            <div class="mt-3">
                <label>Role</label>
                <select name="role"
                        class="input w-full border mt-2"
                        required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="petugas">Petugas</option>
                    <option value="nakes">Nakes</option>
                </select>
            </div>

            <!-- Button -->
            <div class="mt-5">
                <button type="submit" class="button bg-theme-1 text-white w-full">
                    Simpan
                </button>
            </div>

        </form>
    </div>

</div>
@endsection