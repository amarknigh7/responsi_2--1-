<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>

</head>
<body>
    {{-- header admin --}}
    <nav class="navbar fixed-top navbar-expand-lg" style="background-color: grey">
        <div class="container-fluid">
          <a class="navbar-brand text-white">Admin Cafe</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pesananBtn" href="#">pesanan</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="{{ route('logout') }}" > logout </a>
              </li>
            </ul>
            <form class="d-flex" role="search">
              <input type="text "class="form-control me-2" name="searching" id="searching" placeholder="Search here">
              <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
    {{-- end header admin --}}

    {{-- content --}}
      <div class="container d-flex flex-column align-items-center justify-content-start"  style="height: 80vh; gap: 10px; margin-top: 100px;">
            @include('_message')
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Tambah
            </button>

            {{-- tabel body --}}
            <div class="data-table" style="width: 90%; display: flex; flex-direction: column; align-items: center;">
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
            </div>
            {{-- end tabel body --}}

            <!-- Modal insert-->
            <div class="modal fade" id="exampleModal"  aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <form action="{{ route('insertmenu') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">foto</label>
                          <input type="file" name="foto" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">nama menu</label>
                          <input type="text" name="nama_menu" class="form-control" id="exampleInputPassword1">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">deskripsi</label>
                          <input type="text" name="deskripsi" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">kategori</label>
                          <input type="text" name="kategori" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">harga</label>
                          <input type="number" name="harga" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                      </form>
                    </div>
                </div>
                </div>
            </div>
            {{-- end Modal insert--}}

      </div>
    {{-- end content --}}

    <script>
        // {{-- script ajax ke pesanan --}}
        $(document).ready(function() {
          // Ketika tombol "pesanan" ditekan
          $("#pesananBtn").click(function(e) {
            e.preventDefault(); // Mencegah perilaku default dari link

            // Kirim permintaan Ajax
            $.ajax({
              url: "/pesanan", // Ganti dengan URL atau rute yang sesuai
              type: "GET", // Metode permintaan
              success: function(response) {
                // Jika permintaan berhasil, perbarui konten halaman dengan hasil respons
                $("body").html(response);
              },
              error: function(xhr, status, error) {
                // Jika ada kesalahan, tampilkan pesan kesalahan
                console.error(xhr.responseText);
              }
            });
          });
        });
        // {{-- end script ajax ke pesanan --}}

        //pagination ajax
$(document).on('click', '.pagination a', function(e){
    e.preventDefault();
    let page = $(this).attr('href').split('page=')[1]; // Mengambil bagian kedua setelah 'page='
    product(page);
})

function product(page) {
    $.ajax({
        url:"/paginated?page="+page,
        success:function(res) {
            $('.data-table').html(res);
        }
    })
}
//end pagination ajax

        // search menu
        $(document).on('keyup', function(e) {
            e.preventDefault();
            let search_string = $('#searching').val();
            $.ajax({
                url :"{{ route('searchproduct') }}",
                method:'GET',
                data:{search_string:search_string},
                success:function(res){
                    $('.data-table').html(res);
                    if(res.status=='not_found'){
                        $('.data-table').html('<span class="text-danger">'+ 'data tidak ditemukan' +'</span>');
                    }
                }
            })
        })
         // end search menu
      </script>
</body>
</html>
