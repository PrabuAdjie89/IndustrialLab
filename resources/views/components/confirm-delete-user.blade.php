<form action="{{ route($route, $id) }}"
      method="POST"
      class="d-inline delete-form">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="btn btn-danger btn-sm">
        Hapus Akun
    </button>

</form>