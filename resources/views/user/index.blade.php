@extends('layouts.main')
@section('page_title', $pageTitle)

@section('content')
<div class="card">
    <div class="card-body">

        <h5 class="mb-4">Manajemen User</h5>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th style="width: 300px">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $index => $user)
                <tr>
                    <td>{{ $users->firstItem() + $index }}</td>

                    <td>{{ $user->name }}</td>

                    <td>{{ $user->email }}</td>

                    <td>
                        <span class="badge bg-info">
                            {{ $user->role }}
                        </span>
                    </td>

                    <td>
                        <div class="d-flex flex-column gap-2">

                            {{-- Update Role --}}
                            <form action="{{ route('user.updateRole', $user->id) }}"
                                  method="POST">
                                @csrf
                                @method('PUT')

                                <div class="d-flex gap-2">

                                    <select name="role" class="form-select">
                                        <option value="user"
                                            {{ $user->role == 'user' ? 'selected' : '' }}>
                                            User
                                        </option>

                                        <option value="asisten"
                                            {{ $user->role == 'asisten' ? 'selected' : '' }}>
                                            Asisten
                                        </option>

                                        <option value="laboran"
                                            {{ $user->role == 'laboran' ? 'selected' : '' }}>
                                            Laboran
                                        </option>

                                        <option value="kalab"
                                            {{ $user->role == 'kalab' ? 'selected' : '' }}>
                                            Kalab
                                        </option>
                                    </select>

                                    <button type="submit"
                                            class="btn btn-primary btn-sm">
                                        Save
                                    </button>

                                </div>
                            </form>

                            {{-- Hapus User --}}
                            <div>
                                <x-confirm-delete-user :id="$user->id" route="user.destroy" />
                            </div>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">
                        Tidak ada data user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $users->links() }}
        </div>

    </div>
</div>
@endsection