<!-- detail menu untuk user -->
<div class="container d-flex align-items-center justify-content-center">
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($menu as $data)
        <div class="col">
            <div class="card" style="width: 150px;">
                <img src="{{ asset('fotofile/'.$data->foto) }}" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">{{ $data->nama_menu }}</h5>
                    <p class="card-text">{{ $data->harga }}</p>
                    <button type="button" value="{{ $data->id}}" class="btn btn-primary lihatBtn">
                        lihat
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Pagination -->
<div class="container mt-4 d-flex flex-column align-items-center justify-content-center">
    <div class="row">
        <div class="col text-center">
            {{ $menu->links() }}
        </div>
    </div>
</div>
