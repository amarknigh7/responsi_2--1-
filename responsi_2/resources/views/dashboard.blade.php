<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
     {{-- header dashboard --}}
     <nav class="navbar fixed-top navbar-expand-lg" style="background-color: grey">
        <div class="container-fluid">
          <a class="navbar-brand text-white">Cafe</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pemesananSaya" href="#">pesanan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pembelianSaya" aria-current="page" href="#">transaksi</a>
              </li>
              <li class="nav-item">
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                      profil
                    </button>
                    <ul class="dropdown-menu">
                        @if(Auth::check())
                            <li><a class="dropdown-item" href="#">{{ Auth::user()->name }}</a></li>
                        @endif
                    </ul>
                  </div>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="{{ route('logout') }}" > logout </a>
              </li>
            </ul>
            <form class="d-flex" role="search">
              <input class="form-control me-2" id="searching" type="text" placeholder="Search" aria-label="Search">
              <button class="btn btn-outline-light" type="submit">Search</button>
            </form>
          </div>
        </div>
      </nav>
    {{-- end header dashboard --}}

    {{-- content --}}
    <div class="container d-flex flex-column align-items-center justify-content-start"  style="height: 80vh; gap: 10px; margin-top: 100px;">
        @include('_message')
        {{-- filter kategori --}}
        <div class="dropdown">
            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
              kategori
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item filter-btn" href="#" data-category="makanan">makanan</a></li>
              <li><a class="dropdown-item filter-btn" href="#" data-category="minuman">minuman</a></li>
            </ul>
          </div>
        {{-- end filter kategori --}}

        {{-- menu --}}
        <div class="container Umenu d-flex align-items-center justify-content-start text-center">
            <div class="row">
                @foreach ($menu as $data)
                <div class="col mx-1">
                    <div class="card" style="width: 150px;">
                        <img src="{{ asset('fotofile/'.$data->foto) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $data->nama_menu }}</h5>
                            <p class="card-text">Rp.{{ $data->harga }}</p>
                            <button type="button" value="{{ $data->id}}" class="btn btn-primary lihatBtn mb-1">
                                lihat
                            </button>
                            <a href="/ambilpesanan/{{ $data->id }}" class="btn btn-warning">pesan</a>
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
        {{-- end menu --}}

        <!-- Modal data menu-->
        <div class="modal fade" id="lihatModal"  aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="${response.gambar_url}" id="menuImage" class="img-fluid rounded-center">
                            </div>
                            <div class="col-md-6">
                                <h5 class="modal-title" id="menuTitle">${response.nama_menu}</h5>
                                <p class="modal-text" id="menuDescription">${response.deskripsi}</p>
                                <p class="modal-text" id="menuCategory">${response.kategori}</p>
                                <p class="modal-text" id="menuPrice">${response.harga}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- end Modal data menu--}}

    </div>
    {{-- end content --}}

    <script>
        // {{-- script ajax ke pemesanan saya --}}
        $(document).ready(function() {
          // Ketika tombol "pesanan" ditekan
          $("#pemesananSaya").click(function(e) {
            e.preventDefault(); // Mencegah perilaku default dari link

            // Kirim permintaan Ajax
            $.ajax({
              url: "/pemesan", // Ganti dengan URL atau rute yang sesuai
              type: "GET", // Metode permintaan
              success: function(response) {
                // Jika permintaan berhasil, perbarui konten halaman dengan hasil respons
                $("body").html(response);
                hitungTotalHarga();

              },
              error: function(xhr, status, error) {
                // Jika ada kesalahan, tampilkan pesan kesalahan
                console.error(xhr.responseText);
              }
            });
          });
        });
        // {{-- end script ajax ke pemesanan saya --}}

        // {{-- script ajax ke pembelian saya --}}
        $(document).ready(function() {
          // Ketika tombol "pesanan" ditekan
          $("#pembelianSaya").click(function(e) {
            e.preventDefault(); // Mencegah perilaku default dari link

            // Kirim permintaan Ajax
            $.ajax({
              url: "/transaksi", // Ganti dengan URL atau rute yang sesuai
              type: "GET", // Metode permintaan
              success: function(response) {
                // Jika permintaan berhasil, perbarui konten halaman dengan hasil respons
                $("body").html(response);
                hitungTotalHarga();

              },
              error: function(xhr, status, error) {
                // Jika ada kesalahan, tampilkan pesan kesalahan
                console.error(xhr.responseText);
              }
            });
          });
        });
        // {{-- end script ajax ke pembelian saya --}}

        // script menampilkan detail menu
        $(document).ready(function() {
            $(document).on('click', '.lihatBtn', function() {
                var menu_id = $(this).val();

                // Kirim permintaan Ajax untuk mendapatkan detail menu berdasarkan ID
                $.ajax({
                    url: "/get-menu-details/" + menu_id, // Ganti dengan URL atau rute yang sesuai
                    type: "GET", // Metode permintaan
                    success: function(response) {
                        // Isi modal dengan detail menu yang diterima dari respons
                        $('#menuImage').attr('src', response.gambar_url);
                        $('#menuTitle').text(response.nama_menu);
                        $('#menuDescription').text(response.deskripsi);
                        $('#menuCategory').text(response.kategori);
                        $('#menuPrice').text(response.harga);

                        // Tampilkan modal
                        $('#lihatModal').modal('show');
                    },
                    error: function(xhr, status, error) {
                        // Jika ada kesalahan, tampilkan pesan kesalahan
                        console.error(xhr.responseText);
                    }
                });
            });
        });
        // end script menampilkan detail menu

        //pagination ajax untuk data menu
        $(document).on('click', '.pagination a', function(e){
                e.preventDefault();
                let page = $(this).attr('href').split('page=')[1]
                product(page)
           })

           function product(page) {
                $.ajax({
                    url:"/paginatedU?page="+page,
                    success:function(res) {
                        $('.Umenu').html(res);
                    }
                })
           }
        //end pagination ajax untuk data menu

        // search menu
        $(document).on('keyup', function(e) {
            e.preventDefault();
            let search_string = $('#searching').val();
            $.ajax({
                url :"{{ route('searchproductU') }}",
                method:'GET',
                data:{search_string:search_string},
                success:function(res){
                    $('.Umenu').html(res);
                    if(res.status=='not_found'){
                        $('.Umenu').html('<span class="text-danger">'+ 'data tidak ditemukan' +'</span>');
                    }
                }
            })
        })
         // end search menu

        // script filter category
        $(document).on('click', '.filter-btn', function() {
            var category = $(this).data('category');

            // Kirim permintaan Ajax untuk memfilter menu berdasarkan kategori
            $.ajax({
                url: "/filtermenu", // Ganti dengan URL atau rute yang sesuai
                type: "GET", // Metode permintaan
                data: { category: category },
                success: function(response) {
                    // Perbarui daftar menu dengan hasil filter
                    $('.Umenu').html(response);
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        });
        // end script filter category

    </script>
</body>
</html>
