<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use Input;
use Validator;
use File;
use DB;

use App\User;
use App\School;
use App\Soal;
use App\Jawab;
use App\Detailsoal;
use App\Distribusisoal;
use App\Countexamtime;

class SiswaController extends Controller
{
  public function __construct()
  {
      $this->middleware('auth');
  }

  public function index()
  {
    if (Auth::user()->status == "S" or Auth::user()->status =="C") {
      $user = User::join('kelas', 'users.id_kelas', '=', 'kelas.id')
                      ->select('kelas.nama as nama_kelas', 'users.*')
                      ->where('users.id', Auth::user()->id)->first();
      $sekolah = School::where('id', 1)->first();
      return view('siswa.index', compact('user', 'sekolah'));
    }else{
      return redirect('guru');
    }
  }

  public function profil()
  {
    if (Auth::user()->status == "S" or Auth::user()->status =="C") {
      $user = User::join('kelas', 'users.id_kelas', '=', 'kelas.id')
                  ->select('kelas.nama as nama_kelas', 'users.*')
                  ->where('users.id', Auth::user()->id)->first();
      $school = School::first();
      return view('siswa.profil', compact('user', 'school'));
    }else{
      return redirect('guru');
    }
  }

  public function updateprofil()
  {
      if(Request::ajax()){
          $nama = Input::get('nama');
          $nis = Input::get('nis');
          $jk = Input::get('jk');
          $password = Input::get('password');
          $passwordsimpan = bcrypt(Input::get('password'));
          if($password != ""){
              $user = User::where('id', '=', Auth::user()->id)->first();
              $user->nama = Input::get('nama');
              $user->no_induk = Input::get('nis');
              $user->jk = Input::get('jk');
              $user->password = $passwordsimpan;
              $user->save();
              return ('berhasil');
          }else{
              $user = User::where('id', '=', Auth::user()->id)->first();
              $user->nama = Input::get('nama');
              $user->no_induk = Input::get('nis');
              $user->jk = Input::get('jk');
              $user->save();
              return ('berhasil');
          }
      }
  }

  public function updateprofilfoto()
  {
      if(Request::ajax()){
          if(isset($_FILES["file"]["type"])){
              $validextensions = array("jpeg", "jpg", "png");
              $temporary = explode(".", $_FILES["file"]["name"]);
              $file_extension = end($temporary);

              if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
              ) && ($_FILES["file"]["size"] < 1000000)//Approx. 1000kb files can be uploaded.
              && in_array($file_extension, $validextensions)) {
                  if ($_FILES["file"]["error"] > 0){
                      echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
                  }else{
                      if (file_exists(url('/img/') . $_FILES["file"]["name"])) {
                          echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
                      }else{
                          $uniqname = date('ymdhis').rand(00000,99999);
                          $sourcePath = $_FILES['file']['tmp_name'];
                          $targetPath = "img/".$uniqname.$_FILES['file']['name'];
                          move_uploaded_file($sourcePath,$targetPath);

                          $user = User::where('id', '=', Auth::user()->id)->first();
                          File::delete('img/'.$user->gambar);
                          $user->gambar = $uniqname.$_FILES["file"]["name"];

                          $user->save();

                          echo "<span id='success'>Foto berhasil di upload...!! <i>Refresh</i> halaman untuk melihat hasilnya...</span><br/>";
                          echo "<br/><b>File Name:</b> " . $_FILES["file"]["name"] . "<br>";
                          echo "<b>Type:</b> " . $_FILES["file"]["type"] . "<br>";
                          echo "<b>Size:</b> " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
                      }
                  }
              }else{
                  echo "<span id='invalid'>***Terdapat kesalahan dalam hal jenis file maupun ukuran yang melebihi batas. Maksimal ukuran file yang diterima adalah 1Mb***<span>";
              }
          }
      }
  }

  public function soal()
  {
      if (Auth::user()->status == "S" or Auth::user()->status =="C") {
          $user = User::where('email', '=', Auth::user()->email)->first();
          $school = School::first();
          $distribusisoal = Distribusisoal::join('soals', 'distribusisoals.id_soal', '=', 'soals.id')
                                        ->select('soals.paket', 'soals.deskripsi', 'soals.kkm', 'soals.id as id_soal', 'distribusisoals.*')
                                        ->where('distribusisoals.id_kelas', Auth::user()->id_kelas)->get();
          $soals = Soal::all();
          return view('siswa.soal', compact('user', 'school', 'soals', 'distribusisoal'));
      }else{
          return redirect('guru');
      }
  }

  public function detailsoal($id)
  {
  if (Auth::user()->status == "S" or Auth::user()->status == "C") {
      $idsoal = $id;
      $soals = Detailsoal::where('id_soal', $id)
              ->orderBy(DB::raw('RAND()'))
              ->get();
      $firstSoalId = $soals->count() ? $soals->first()->id : 0;
      $user = User::where('id', Auth::user()->id)->first();
      $school = School::first();

      $detailsoal = Detailsoal::join('soals', 'detailsoals.id_soal', '=', 'soals.id')
                    ->select('soals.paket', 'soals.waktu', 'detailsoals.*')
                    ->where('detailsoals.id_soal', $id)
                    ->where('detailsoals.id', $firstSoalId)
                    ->first();
      $jumlah_soal = Detailsoal::where('id_soal', $id)->get();
      $soal = Soal::where('id', $id)->first();
      $countexamtime = Countexamtime::where('id_soal', $id)->where('id_user', Auth::user()->id)->first();
      return view('siswa.detail_soal', compact('idsoal', 'soals', 'user', 'school', 'soal', 'detailsoal', 'jumlah_soal', 'countexamtime'));
    }else{
        return redirect('guru');
    }
  }
  public function get_soal($id)
  {
    $detailsoal = Detailsoal::join('soals', 'detailsoals.id_soal', '=', 'soals.id')
                                      ->select('soals.paket', 'soals.deskripsi', 'soals.kkm', 'soals.id as id_soal', 'detailsoals.*')
                                      ->where('detailsoals.id', $id)->first();
    $cek_jawaban = Jawab::where('no_soal_id', $id)->where('id_user', Auth::user()->id)->first();
    return view('siswa.ajax.get_soal', compact('detailsoal', 'cek_jawaban'));
  }


  public function simpanjawabankliksiswa()
  {
    $pilihan = Input::get('pilihan');
    $id_soal = Input::get('id_soal');
    $no_soal_id = Input::get('no_soal_id');

    $q_user = User::where('id', Auth::user()->id)->first();
    $q_detail_soal = Detailsoal::where('id', $no_soal_id)->first();
    $q_cek_jawaban = Detailsoal::where('id', $no_soal_id)->where('kunci', $pilihan)->first();
    if ($q_cek_jawaban != "") {
      $score = $q_cek_jawaban->score;
    }else{
      $score = 0;
    }
    $q_jawab = Jawab::where('no_soal_id', $no_soal_id)
                      ->where('id_soal', $id_soal)
                      ->where('id_user', Auth::user()->id)->first();
    if ($q_jawab != '') {
      $q_jawab->no_soal_id = $no_soal_id;
      $q_jawab->id_soal = $id_soal;
      $q_jawab->id_user = Auth::user()->id;
      $q_jawab->id_kelas = $q_user->id_kelas;
      $q_jawab->nama = $q_user->nama;
      $q_jawab->pilihan = $pilihan;
      $q_jawab->score = $score;
      $q_jawab->status = 'N';
      $q_jawab->save();
      return $pilihan;
    }else{
      $query = new Jawab;
      $query->no_soal_id = $no_soal_id;
      $query->id_soal = $id_soal;
      $query->id_user = Auth::user()->id;
      $query->id_kelas = $q_user->id_kelas;
      $query->nama = $q_user->nama;
      $query->pilihan = $pilihan;
      $query->score = $score;
      $query->status = 'N';
      $query->save();
      return $pilihan;
    }
  }



  public function simpanjawabankliksiswas()
  {
    $no_soal_id = Input::get('no_soal_id');
    $id_soal = Input::get('id_soal');
    $id_user = Input::get('id_user');
    $pilihan = Input::get('pilihan');

    $users = User::where('id', '=', Input::get('id_user'))->first();
    //cek kebenaran jawaban
    $soals = Detailsoal::where('id', '=', $no_soal_id)->where('kunci', '=', $pilihan)->get();
    $hasil = count($soals);

    //cek pernah jawab
    $cekjawabs = Jawab::where('no_soal_id', '=', $no_soal_id)->where('id_user', '=', $id_user)->get();
    $hasilcekjawab = count($cekjawabs);

    if ($hasilcekjawab == 1) {
      $ceksoals = Detailsoal::where('id', '=', $no_soal_id)->get();
      foreach ($ceksoals as $soal) {
        $score = $soal->score;
        if($hasil==1){
          $simpanjawab = Jawab::where('no_soal_id', '=', $no_soal_id)->where('id_user', '=', $id_user)->first();
          $simpanjawab->no_soal_id = Input::get('no_soal_id');
          $simpanjawab->id_soal = Input::get('id_soal');
          $simpanjawab->id_user = Input::get('id_user');
          
          $simpanjawab->id_kelas = $users->id_kelas;
          $simpanjawab->nama = $users->nama;

          $simpanjawab->pilihan = Input::get('pilihan');
          $simpanjawab->score = $score;
          $simpanjawab->status = 'N';
          $simpanjawab->save();
        }else{
          $simpanjawab = Jawab::where('no_soal_id', '=', $no_soal_id)->where('id_user', '=', $id_user)->first();
          $simpanjawab->no_soal_id = Input::get('no_soal_id');
          $simpanjawab->id_soal = Input::get('id_soal');
          $simpanjawab->id_user = Input::get('id_user');

          $simpanjawab->id_kelas = $users->id_kelas;
          $simpanjawab->nama = $users->nama;
          
          $simpanjawab->pilihan = Input::get('pilihan');
          $simpanjawab->score = 0;
          $simpanjawab->status = 'N';
          $simpanjawab->save();
        }
      }
    }else{
      $ceksoals = Detailsoal::where('id', '=', $no_soal_id)->get();
      foreach ($ceksoals as $soal) {
        $score = $soal->score;
        if($hasil==1){
          $simpanjawab = new Jawab;
          $simpanjawab->no_soal_id = Input::get('no_soal_id');
          $simpanjawab->id_soal = Input::get('id_soal');
          $simpanjawab->id_user = Input::get('id_user');

          $simpanjawab->id_kelas = $users->id_kelas;
          $simpanjawab->nama = $users->nama;

          $simpanjawab->pilihan = Input::get('pilihan');
          $simpanjawab->score = $score;
          $simpanjawab->status = 'N';
          $simpanjawab->save();
        }else{
          $simpanjawab = new Jawab;
          $simpanjawab->no_soal_id = Input::get('no_soal_id');
          $simpanjawab->id_soal = Input::get('id_soal');
          $simpanjawab->id_user = Input::get('id_user');

          $simpanjawab->id_kelas = $users->id_kelas;
          $simpanjawab->nama = $users->nama;
          
          $simpanjawab->pilihan = Input::get('pilihan');
          $simpanjawab->score = 0;
          $simpanjawab->status = 'N';
          $simpanjawab->save();
        }
      }
    }
    return ($pilihan);
  }

  public function kirimjawaban()
  {
    $id_soal = Input::get('id_soal');
    $cek_jawaban = Jawab::where('id_soal', $id_soal)
                          ->where('id_user', Auth::user()->id)
                          ->get();

    $jumlahJawaban = 0;

    foreach ($cek_jawaban as $value) {
      $value->status = 'Y';
      $value->save();
      $jumlahJawaban++;
    }

    \Log::info('exam.finished', array(
      'user_id' => Auth::user()->id,
      'id_soal' => $id_soal,
      'answered_questions' => $jumlahJawaban,
      'ip' => Request::ip()
    ));

    return 'OK';
  }

  public function hasil_siswa()
  {
    $school = School::first();
    $user = User::where('id', '=', Auth::user()->id)->first();
    $jawabs = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')
            ->select(['jawabs.id', 'jawabs.id_user', 'soals.id as id_soal', 'soals.paket', 'soals.deskripsi', 'soals.kkm', 'soals.jenis as jenis_soal', 'jawabs.created_at', 'jawabs.updated_at',
              \DB::raw('sum(jawabs.score) as count')])
            ->where('jawabs.id_user', Auth::user()->id)
            ->where('jawabs.status', 'Y')
            ->orderby('jawabs.id', 'desc')
            ->groupby('id_soal')->paginate(10);
    return view('siswa.hasil', compact('user', 'school', 'jawabs'));
  }

  public function get_hasil()
  {
    $q = Input::get('q');
    $jawabs = Jawab::join('soals', 'jawabs.id_soal', '=', 'soals.id')
            ->select(['jawabs.id', 'jawabs.id_user', 'soals.id as id_soal', 'soals.paket', 'soals.deskripsi', 'soals.kkm', 'soals.jenis as jenis_soal', 'jawabs.created_at', 'jawabs.updated_at',
              \DB::raw('sum(jawabs.score) as count')])
            ->where('jawabs.id_user', Auth::user()->id)
            ->where('jawabs.status', 'Y')
            ->where('soals.paket', 'LIKE', '%'.$q.'%')
            ->orderby('jawabs.id', 'desc')
            ->groupby('jawabs.id_soal')->paginate(10);
    return view('siswa.ajax.get_hasil', compact('jawabs'));
  }

  public function detail_hasil_siswa($id)
  {
    if (Auth::user()->status == "S" or Auth::user()->status == "C") {
      $userId = Auth::user()->id;
      $user = User::where('id', $userId)->first();
      $soal = Soal::where('id', $id)->first();

      if (!$soal) {
        abort(404);
      }

      /*
       * Review hanya boleh dibuka setelah submission selesai.
       * Jika masih ada jawaban berstatus N, berarti ujian/latihan sedang dikerjakan
       * atau sedang dalam proses retake, sehingga kunci tidak boleh ditampilkan.
       */
      $adaJawabanSelesai = Jawab::where('id_soal', $id)
                              ->where('id_user', $userId)
                              ->where('status', 'Y')
                              ->exists();

      $adaJawabanDraft = Jawab::where('id_soal', $id)
                              ->where('id_user', $userId)
                              ->where('status', 'N')
                              ->exists();

      if (!$adaJawabanSelesai || $adaJawabanDraft) {
        \Log::warning('exam.review.denied', array(
          'user_id' => $userId,
          'id_soal' => $id,
          'has_finished_answer' => $adaJawabanSelesai,
          'has_draft_answer' => $adaJawabanDraft,
          'ip' => Request::ip()
        ));

        return redirect('hasil-siswa')
              ->with('error', 'Review jawaban hanya tersedia setelah ujian selesai.');
      }

      /*
       * Master query dimulai dari detailsoals, lalu LEFT JOIN ke jawabs.
       * Dengan cara ini soal yang tidak dijawab tetap muncul pada halaman review.
       * Filter user/id_soal/status diletakkan pada JOIN agar tidak mengubah LEFT JOIN
       * menjadi INNER JOIN secara tidak sengaja.
       */
      $jawabs = Detailsoal::leftJoin('jawabs', function($join) use ($id, $userId) {
                        $join->on('detailsoals.id', '=', 'jawabs.no_soal_id')
                             ->where('jawabs.id_soal', '=', $id)
                             ->where('jawabs.id_user', '=', $userId)
                             ->where('jawabs.status', '=', 'Y');
                      })
                      ->select(
                        'detailsoals.id as detail_id',
                        'detailsoals.soal',
                        'detailsoals.pila',
                        'detailsoals.pilb',
                        'detailsoals.pilc',
                        'detailsoals.pild',
                        'detailsoals.pile',
                        'detailsoals.kunci',
                        'detailsoals.score as max_score',
                        'jawabs.pilihan as jawaban',
                        'jawabs.score as score_diperoleh',
                        'jawabs.created_at as dijawab_pada',
                        'jawabs.updated_at as diubah_pada'
                      )
                      ->where('detailsoals.id_soal', $id)
                      ->orderBy('detailsoals.id', 'asc')
                      ->get();

      $jumlahSoal = $jawabs->count();
      $benar = 0;
      $salah = 0;
      $tidakDijawab = 0;
      $nilai = 0;

      foreach ($jawabs as $jawab) {
        $pilihan = strtoupper(trim((string) $jawab->jawaban));
        $kunci = strtoupper(trim((string) $jawab->kunci));
        $nilai += (float) $jawab->score_diperoleh;

        if ($pilihan === '') {
          $tidakDijawab++;
        } elseif ($pilihan === $kunci) {
          $benar++;
        } else {
          $salah++;
        }
      }

      $lulus = ((float) $nilai >= (float) $soal->kkm);
      $jenis = ((int) $soal->jenis === 1) ? 'Ujian' : 'Latihan';

      \Log::info('exam.review.opened', array(
        'user_id' => $userId,
        'id_soal' => $id,
        'score' => $nilai,
        'correct' => $benar,
        'wrong' => $salah,
        'unanswered' => $tidakDijawab,
        'ip' => Request::ip()
      ));

      return view('siswa.detail', compact(
        'user',
        'soal',
        'jawabs',
        'jumlahSoal',
        'benar',
        'salah',
        'tidakDijawab',
        'nilai',
        'lulus',
        'jenis'
      ));
    }else{
      return redirect('guru');
    }
  }

  public function detailujian($id)
  {
    if (Auth::user()->status == "S" or Auth::user()->status =="C") {
      $user = User::where('email', Auth::user()->email)->first();
      $soal = Soal::where('id', '$id')->first();
      $soals = Soal::where('id', '!=', '$id')->get();
      $idsoal = $id;
      /*$users = join('jawabs', 'users.id_user', '=', 'jawabs.id')
                ->select('ja')*/
      return view('siswa.detail', compact('user', 'idsoal', 'soal', 'soals'));
    }else{
        return redirect('guru');
    }
  }
  

  public function test()
  {
    $user = User::first();
    $users = User::where('id', '!=', $user->id)->get();

    return view('siswa.test', compact('user', 'users'));
  }

  public function nilai()
  {
    $users = User::paginate(10);
    return view('siswa.nilai', compact('users'));
  }

  public function countexamtime()
  {
    $id_soal = Input::get('id_soal');
    $soal = Soal::where('id', $id_soal)->first();
    $cek = Countexamtime::where('id_soal', $id_soal)->where('id_user', Auth::user()->id)->first();
    if ($cek == '') {
      $query = new Countexamtime;
      $query->id_soal = $id_soal;
      $query->id_user = Auth::user()->id;
      $query->waktu = $soal->waktu;
      $query->save();

      return 'Baru';
    }else{
      $cek->waktu = ($cek->waktu - 5);
      $cek->save();
      return 'Ubah';
    }
  }
}
