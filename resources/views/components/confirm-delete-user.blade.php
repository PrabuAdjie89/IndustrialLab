<form action="{{ route($route, $id) }}" method="POST" class="d-inline">
    @csrf
    @method('DELETE')

    <button
        type="submit"
        class="btn btn-danger btn-sm"
        data-confirm-delete="true">
        Hapus Akun
    </button>
</form>