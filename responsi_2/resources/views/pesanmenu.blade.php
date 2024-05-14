<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>update menu</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            background-image: url('cafe.jpg');
            background-size: cover;
        }

        #image-container {
             /* Mengatur ukuran gambar agar menutupi seluruh area container */
            height: 80vh;
            width: 100%;
        }
    </style>
</head>
<body>
    {{-- navbar detail menu --}}
    <nav class="navbar bg-dark fixed-top border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="{{ asset('logo-cafe.jpg') }}" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
            Cafe
          </a>
        </div>
      </nav>
    {{--end  navbar detail menu --}}

    {{-- content detail menu by id --}}
    <div class="container d-flex flex-column align-items-center justify-content-center" id="image-container" style="gap: 10px">
        <div class="card mb-3" style="max-width: 90%;">
            <div class="row g-0">
              <div class="col-md-8">
                <div class="card-body">
                    <form action="/tambahpesanan/{{ $menu->id }}" method="POST">
                        @csrf
                        <label for="nama_menu">Nama_menu: {{ $menu->nama_menu }}</label><br>
                        <label for="harga">Harga : Rp.{{ $menu->harga }}</label><br>
                        <label for="nomor_meja">Jumlah:</label><br>
                        <input type="number" id="jumlah" name="jumlah"><br>
                        <label for="nomor_meja">Nomor Meja:</label><br>
                        <input type="number" id="nomor_meja" name="meja"><br><br>
                        <button type="submit" class="btn btn-warning">Pesan</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
    </div>
    {{-- end content detail menu by id --}}
</body>
</html>

