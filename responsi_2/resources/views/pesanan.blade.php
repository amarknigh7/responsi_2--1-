<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>pesanan</title>
</head>
<body>
    {{-- header pesanan --}}
    <nav class="navbar fixed-top navbar-expand-lg" style="background-color: grey">
        <div class="container-fluid">
          <a class="navbar-brand text-white">Admin Cafe</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" id="homeBtn" aria-current="page" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link"  href="#">pesanan</a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#" > logout </a>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    {{-- end header pesanan --}}

    {{-- content --}}
    <div class="container d-flex flex-column justify-content-start"  style="height: 80vh; margin-top: 100px;">
        {{-- daftar pesanan --}}
        @foreach($pesanan as $row)
        <div class="card mb-3" style="max-width: 90%;">
            <div class="row g-0">
              <div class="col-md-3">
                <img src="icon_pesan.png" class="img-fluid rounded-start" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                  <h5 class="card-title">Nama Menu: {{ $row->nama_menu }}</h5>
                  <p class="card-text">Pemesan: {{ $row->name }}</p>
                  <p class="card-text">Meja: {{ $row->meja }}</p>
                  <button type="button" class="btn btn-primary tandaiSelesaiBtn" data-pesanan-id="{{ $row->id }}">Tandai Selesai</button>
                </div>
              </div>
            </div>
          </div>
          @endforeach
          {{-- end daftar pesanan --}}
    </div>
    {{-- end content --}}

    <script>
        // {{-- script ajax ke admin --}}
        $(document).ready(function() {
          // Ketika tombol "pesanan" ditekan
          $("#homeBtn").click(function(e) {
            e.preventDefault(); // Mencegah perilaku default dari link

            // Kirim permintaan Ajax
            $.ajax({
              url: "/admin", // Ganti dengan URL atau rute yang sesuai
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
        // {{-- end script ajax ke admin --}}

        // script untuk mengubah status pesanan
        $(document).ready(function() {
            $(document).on('click', '.tandaiSelesaiBtn', function() {
                var pesananId = $(this).data('pesanan-id');
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Kirim permintaan AJAX untuk menandai pesanan sebagai selesai
                $.ajax({
                    url: '/tandaipesanan/'+ pesananId,
                    type: 'PUT',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken // Menambahkan token CSRF ke header permintaan
                    },
                    success: function(response) {
                        // Jika permintaan berhasil, hapus tombol "tandai selesai"
                        $('.tandaiSelesaiBtn[data-pesanan-id="' + pesananId + '"]').remove();
                    },
                    error: function(xhr, status, error) {
                        // Jika ada kesalahan, tampilkan pesan kesalahan
                        console.error(xhr.responseText);
                    }
                });
            });
        });
        // end script untuk mengubah status pesanan

      </script>
</body>
</html>
