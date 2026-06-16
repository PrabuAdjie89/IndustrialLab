<div>
    <select name="perPage" id="perPage" class="form-control" onchange="window.location.href='?perPage=' + this.value" style="width: 100px">
        <option value="">Page</option>
        @foreach ($PageOptions as $item )
        <option value="{{ $item }}">{{ $item }}</option>
        @endforeach
    </select>
</div>