<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;
use App\Models\User;
use App\Models\Pesanan;
use App\Models\Pembelian;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;

class HomeController extends Controller
{
    public function admin () {

        $menu=Menu::paginate(5);
        return view('admin', compact('menu'));
    }

    public function pesanan () {

        $pesanan=Pesanan::all();
        return view('pesanan', compact('pesanan'));
    }

    public function pemesan () {

        $pesanan=Pesanan::all();
        return view('pemesan', compact('pesanan'));
    }

    public function transaksi () {

        $pembelian=Pembelian::all();
        return view('transaksi', compact('pembelian'));
    }

    public function dashboard () {
        $users = User::all();
        $menu=Menu::paginate(8);
        return view('dashboard', compact('users','menu'));
    }

    public function insertmenu (Request $request) {

        $menu=Menu::create($request->all());
        if($request->hasFile('foto')) {
            $request->file('foto')->move('fotofile/', $request->file('foto')->getClientOriginalName());
            $menu->foto = $request->file('foto')->getClientOriginalName();
            $menu->save();
        }
        return redirect()->route('admin')->with('success', 'Data berhasil ditambahkan');
    }

    // untuk detail menu di admin
    public function tampildata ($id) {
        $menu = Menu::find($id);
        return view('editmenu', compact('menu'));

    }
    // end untuk detail menu di admin

    // untuk menampilkan detail menu di dashboard
    public function getMenuDetails($id)
    {
        $menu = Menu::find($id); // Ambil menu berdasarkan ID

        if($menu) {
            $menu->gambar_url = asset('fotofile/' . $menu->foto);
            return response()->json($menu); // Mengembalikan menu dalam format JSON
        } else {
            return response()->json(['error' => 'Menu not found'], 404); // Jika menu tidak ditemukan
        }
    }
    // end untuk menampilkan detail menu di dashboard

    public function updatemenu(Request $request, $id)
{
    $menu = Menu::find($id);


if ($request->hasFile('foto')) {
    $filePath = public_path('fotofile');
    $file = $request->file('foto');
    $file_name = time() . $file->getClientOriginalName();
    // Move the uploaded photo to the storage directory
    $file->move($filePath, $file_name);

    // Delete the old photo
    if (!is_null($menu->foto)) {
        $oldImage = public_path('fotofile/' . $menu->foto);
        if (File::exists($oldImage)){
            unlink($oldImage);
        }
    }

    $menu->foto = $file_name;
}

// Update menu
$menu->deskripsi = $request->deskripsi;
$menu->harga = $request->harga;
$menu->save();

return redirect()->route('admin')->with('success', 'Data berhasil diupdate');
}



    public function deletemenu ($id) {
        $menu = Menu::find($id);

        // Hapus file gambar terkait jika ada
        if ($menu->foto) {
            // Dapatkan path lengkap ke file gambar
            $imagePath = public_path('fotofile/' . $menu->foto);

            // Periksa apakah file gambar ada sebelum menghapusnya
            if (file_exists($imagePath)) {
                // Hapus file gambar dari sistem file
                unlink($imagePath);
            }
        }

        $menu->delete();

        return redirect()->route('admin')->with('success', 'Data berhasil dihapus');

    }

    // live search untuk admin
    public function searchproduct (Request $request) {
        $menu = Menu::where('nama_menu', 'like', '%'.$request->search_string.'%')->orderBy('id')->paginate(5);

        if($menu->count() >= 1) {
            return view('datamenu', compact('menu'))->render();
        } else {
            return response()->json([
                'status' => 'not_found',
            ]);
        }
    }

    public function paginated(Request $request) {
        $menu=Menu::paginate(5);
        return view('datamenu', compact('menu'))->render();
    }
    // end live search untuk admin

    // untuk koki apabila makanan telah diantar
    public function tandaiSelesai($id)
    {
        // Temukan pesanan berdasarkan ID
        $pesanan = Pesanan::find($id);

        if (!$pesanan) {
            return response()->json(['message' => 'Pesanan tidak ditemukan'], 404);
        }

        // Ubah status pesanan menjadi "sudah"
        $pesanan->status = 'sudah';
        $pesanan->save();

        // Kembalikan respons
        return response()->json(['message' => 'Pesanan berhasil ditandai sebagai selesai'], 200);
    }
    // end untuk koki apabila makanan telah diantar

    // live search untuk user
    public function searchproductU (Request $request) {
        $menu = Menu::where('nama_menu', 'like', '%'.$request->search_string.'%')->orderBy('id')->paginate(8);

        if($menu->count() >= 1) {
            return view('datamenu2', compact('menu'))->render();
        } else {
            return response()->json([
                'status' => 'not_found',
            ]);
        }
    }

    public function paginatedU(Request $request) {
        $menu=Menu::paginate(8);
        return view('datamenu2', compact('menu'))->render();
    }
    // end live search untuk user

    public function filtermenu(Request $request)
    {
        $category = $request->input('category');

        // ambil menu berdasarkan kategori yang dipilih
        $menu = Menu::where('kategori', $category)->paginate(8);

        // Kembalikan view dengan data menu yang difilter
        return view('datamenu2', compact('menu'))->render();
    }

    // untuk detail menu yang dipesan
    public function ambilpesanan ($id) {
        $menu = Menu::find($id);
        return view('pesanmenu', compact('menu'));

    }
    // end untuk detail menu yang dipesan

    // menambahkan pesanan
    public function tambahpesanan(Request $request, $id) {
         // Mendapatkan user yang sedang login
        $user = Auth::user()->name;
        $user_id = Auth::user()->id;

        // Mendapatkan data menu yang dipesan dari request
        $menu = Menu::find($id)->nama_menu; // Sesuaikan dengan nama input dari form

        // Mendapatkan data harga dari menu yang dipesan
        $harga = Menu::find($id)->harga; // Sesuaikan dengan model dan atribut harga yang sesuai

        // Membuat pesanan baru
        $pesanan = Pesanan::create([
            'nama_menu' => $menu,
            'user_id' => $user_id,
            'name' => $user,
            'meja' => $request->meja, // Gunakan inputan meja dari request
            'harga' => $harga,
            'jumlah' => $request->jumlah,
            'status' => 'belum' // Sesuaikan dengan status default
        ]);

        // Redirect ke halaman lain atau tampilkan pesan sukses
        return redirect()->route('dashboard')->with('success', 'Pesanan berhasil disimpan!');
    }
    // end menambah pesanan

    // fungsi untuk membayar
    public function bayar(Request $request) {
        // Membuat entri baru di tabel Pembelian
        $pembelian = Pembelian::create([
            'user_id' => auth()->id(),
            'username' => auth()->user()->name,
            'total_harga' => $request->total_harga,
            'status' => 'sudah_bayar',
        ]);

        // Menghapus pesanan yang dimiliki oleh pengguna yang login
        Pesanan::where('user_id', auth()->id())->delete();

        return redirect()->route('dashboard')->with('success', 'anda telah melakukan pembayaran');
    }
    // end fungsi untuk membayar
}
