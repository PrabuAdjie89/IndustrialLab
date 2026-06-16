<form method="POST" action="{{ route($route, $id) }}">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-sm btn-danger"><i fas fa-trash></i>
        Hapus
    </button>
</form>
