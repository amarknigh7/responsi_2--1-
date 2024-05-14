<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pembelian anda</title>
</head>
<body>
    {{-- header pemesanan --}}
    <nav class="navbar fixed-top navbar-expand-lg" style="background-color: grey">
        <div class="container-fluid">
          <a class="navbar-brand text-white">Cafe</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                <a class="nav-link active" aria-current="page" id="userBtn" href="#">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pemesananSaya" href="#">pesanan</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" id="pembelianSaya" href="#">transaksi</a>
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
          </div>
        </div>
      </nav>
    {{-- end header pemesanan --}}

    {{-- content --}}
    <div class="container d-flex flex-column justify-content-start"  style="height: 80vh; margin-top: 100px;">
        {{-- daftar pesanan --}}
        <div class="card mb-3" style="max-width: 90%;">
            <div class="row g-0">
                @foreach ($pembelian as $data)
                    @if ($data->user_id == auth()->id())
                    <div class="col-md-3">
                        <img src="transaksi_icon.jpg" class="img-fluid rounded-start" alt="...">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                        <h5 class="card-title">{{ $data->username }}</h5>
                        <label for="Harga">total pesanan : {{ $data->total_harga }}</label>
                        <p class="card-text harga">{{ $data->status }}</p>
                        <p class="card-text harga">{{ $data->created_at }}</p>

                        </div>
                    </div>
                    @endif
                @endforeach
            </div>
        </div>
        {{-- end daftar pesanan --}}

    </div>
    {{-- end content --}}

    <script>
        // {{-- script ajax ke dashboard --}}
        $(document).ready(function() {
          // Ketika tombol "pesanan" ditekan
          $("#userBtn").click(function(e) {
            e.preventDefault(); // Mencegah perilaku default dari link

            // Kirim permintaan Ajax
            $.ajax({
              url: "/dashboard", // Ganti dengan URL atau rute yang sesuai
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
        // {{-- end script ajax ke dashboard --}}

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

        // Fungsi untuk menghitung total harga
        function hitungTotalHarga() {
            // Mendapatkan semua elemen dengan kelas card-body
            var cardBodies = document.querySelectorAll('.card-body');

            // Inisialisasi variabel total harga
            var totalHarga = 0;

            // Iterasi melalui setiap elemen card-body
            cardBodies.forEach(function(cardBody) {
                // Mendapatkan harga dari elemen dengan kelas 'harga' di dalam card-body
                var hargaText = cardBody.querySelector('.harga').textContent;
                // Menghapus "harga :" dari teks harga
                var harga = parseInt(hargaText.replace('harga : Rp ', '').trim());

                // Mendapatkan jumlah dari elemen dengan kelas 'jumlah' di dalam card-body
                var jumlahText = cardBody.querySelector('.jumlah').textContent;
                // Menghapus "jumlah :" dari teks jumlah
                var jumlah = parseInt(jumlahText.replace('jumlah : ', '').trim());

                // Menghitung subtotal untuk item saat ini
                var subtotal = harga * jumlah;

                // Menambahkan subtotal ke total harga
                totalHarga += subtotal;
            });

            // Menampilkan total harga
            document.getElementById('total-harga').textContent = "Rp " + totalHarga.toLocaleString();
        }
        // end fungsi menghitung total harga

        // script ajax untuk pembayaran
        $(document).ready(function() {
            // Ketika tombol "Bayar" ditekan
            $("#btnBayar").click(function() {
                // Mendapatkan data dari atribut data pada tombol
                var totalHarga = $("#total-harga").text().replace('Rp ', '').replace(',', ''); // Menghilangkan 'Rp ' dan titik

                // Kirim permintaan Ajax
                $.ajax({
                    url: "{{ route('bayar') }}",
                    type: "POST",
                    data: {
                        total_harga: totalHarga,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        $("body").html(response);
                    },
                    error: function(xhr, status, error) {
                        // Tampilkan pesan kesalahan jika terjadi kesalahan
                        console.error(xhr.responseText);
                    }
                });
            });
        });

    </script>
</body>
</html>
