{{-- detail menu untuk admin --}}
<table class="table table-hover table-bordered" style="width: 80%;">
    <thead class="table-primary">
        <tr>
            <th scope="col">#</th>
            <th scope="col">image</th>
            <th scope="col">nama menu</th>
            <th scope="col">deskripsi</th>
            <th scope="col">kategori</th>
            <th scope="col">harga</th>
            <th scope="col">aksi</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($menu as $data)
        <tr scope="row">
            <td>{{ $data->id }}</td>
            <td>
                <img src="{{ asset('fotofile/'.$data->foto) }}" style="width: 50px;">
            </td>
            <td>{{ $data->nama_menu }}</td>
            <td>{{ $data->deskripsi }}</td>
            <td>{{ $data->kategori }}</td>
            <td>{{ $data->harga }}</td>
            <td style="padding: 5px; display: flex; align-items: center; gap: 5px;">
                <a href="/tampildata/{{ $data->id }}" class="btn btn-primary">edit</a>
                <a href="/deletemenu/{{ $data->id }}" class="btn btn-danger">hapus</a>
            </td>
        </tr>
    @empty
        <div class="alert alert-danger">
            Data Products belum Tersedia.
        </div>
    @endforelse
    </tbody>
</table>
{{ $menu->links() }}
