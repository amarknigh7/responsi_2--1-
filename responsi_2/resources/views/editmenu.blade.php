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
    <div class="container d-flex flex-column align-items-center justify-content-center" id="image-container" style="height: 80vh; gap: 10px; margin-top: 100px;">
        <div class="card mb-3" style="max-width: 90%;">
            <div class="row g-0">
              <div class="col-md-4">
                <img src="{{ asset('fotofile/'.$menu->foto) }}" class="img-fluid rounded-center" alt="...">
              </div>
              <div class="col-md-8">
                <div class="card-body">
                    <form action="/updatemenu/{{ $menu->id }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">foto</label>
                            <input type="file" name="foto" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="{{ $menu->foto }}">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">nama menu : {{ $menu->nama_menu }}</label>
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputEmail1" class="form-label">deskripsi</label>
                          <input type="text" name="deskripsi" value="{{ $menu->deskripsi }}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                          <label for="exampleInputPassword1" class="form-label">kategori : {{ $menu->kategori }}</label>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">harga</label>
                            <input type="number" name="harga" value="{{ $menu->harga }}" class="form-control" id="exampleInputPassword1">
                          </div>
                        <button type="submit" class="btn btn-primary">edit</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
    </div>
    {{-- end content detail menu by id --}}
</body>
</html>

