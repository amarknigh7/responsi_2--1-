<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Register</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            background-image: url('cafe.jpg');
            background-size: cover;
        }

        .blur-bg {
            background: rgba(109, 99, 99, 0.7);
            border-radius: 20px;
            padding: 20px;
            backdrop-filter: blur(5px); /* Menambahkan blur */
        }

        #image-container {
             /* Mengatur ukuran gambar agar menutupi seluruh area container */
            height: 80vh;
            width: 100%;
        }


    </style>
</head>
<body>
    {{-- navbar --}}
    <nav class="navbar bg-dark fixed-top border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="#">
            <img src="logo-cafe.jpg" alt="Logo" width="40" height="40" class="d-inline-block align-text-top">
            Cafe
          </a>
        </div>
      </nav>
    {{-- end navbar --}}

    {{-- content --}}
    <span style="color: red; background-color: white; border-radius: 10px;">{{ $errors->first('email') }}<br><br></span>
        <span style="color: red; background-color: white; border-radius: 10px;">{{ $errors->first('password') }}<br></span>
        @include('_message')
    <div class="container d-flex flex-column align-items-center justify-content-center" id="image-container" style="gap: 20px;">
        {{-- form register --}}
        <form action="{{ route('registrasi') }}" method="POST" class="blur-bg">
            @csrf
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Username</label>
                <input type="text" required name="name" value="{{ old('name')}}" class="form-control">
            </div>
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">Email anda</label>
              <input type="email" required name="email" value="{{ old('email')}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
              <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" required name="password" class="form-control" id="exampleInputPassword1">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
          </form>
        {{-- end form register --}}
  </div>
  {{-- end content --}}
</body>
</html>
