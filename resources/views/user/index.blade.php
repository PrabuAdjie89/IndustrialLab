@extends('layouts.main')
@section('page_title', $pageTitle)

@section('content')
<div class="card">
    <div class="card-body">

        <h5 class="mb-4">Manajemen User</h5>

        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:70px;">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th style="width:120px;">Role</th>
                        <th style="min-width:280px;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($users as $index => $user)
                    <tr>
                        <td>{{ $users->firstItem() + $index }}</td>

                        <td>{{ $user->name }}</td>

                        <td class="text-break">
                            {{ $user->email }}
                        </td>

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

                                    <div class="row g-2">
                                        <div class="col-12 col-md">
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
                                                
                                                <option value="kaprodi"
                                                    {{ $user->role == 'kaprodi' ? 'selected' : '' }}>
                                                    kaprodi
                                                </option>
                                            </select>
                                        </div>

                                        <div class="col-12 col-md-auto">
                                            <button type="submit"
                                                class="btn btn-primary w-100">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>

                                {{-- Hapus User --}}
                                <div class="d-grid">
                                    <x-confirm-delete-user
                                        :id="$user->id"
                                        route="user.destroy" />
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
        </div>

        <div class="mt-3">
            {{ $users->links() }}
        </div>

    </div>
</div>
@endsection