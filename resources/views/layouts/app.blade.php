<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        function toggleSidebar() {
            document.getElementById('logo-sidebar').classList.toggle('-translate-x-full');
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-gray-100">

<!-- Navbar dengan hanya logo -->
<nav class="fixed top-0 z-50 w-full lg:w-64 bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700 h-14">
  <div class="flex items-center h-full px-4 lg:px-6">
    <button onclick="toggleSidebar()" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none dark:text-gray-400 dark:hover:bg-gray-700">
      <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
        <path fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z" clip-rule="evenodd" />
      </svg>
    </button>
    <span class="ml-3 text-xl font-semibold text-gray-800 dark:text-white">
        @if (Auth::user()->role == 'admin')
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-semibold py-3">
                <i class="fas fa-star"></i> IgapinRate <i class="fas fa-star"></i>
            </a>
        @elseif (Auth::user()->role == 'karyawan')
            <a href="{{ route('karyawan.dashboard') }}" class="text-gray-800 dark:text-white flex items-center">
                <img class="w-8 h-8 mr-2 rounded-full border border-gray-200" src="{{ asset('storage/images/foto_profil/' . Auth::user()->karyawan->foto_profil) }}" alt="Foto Profil">
                <p>{{ Auth::user()->nama }}</p>
            </a>
        @elseif(Auth::user()->role == 'kepala sekolah')
            <a href="{{ route('kepala.dashboard') }}" class="text-2xl font-semibold py-3">
                 <i class="fas fa-star"></i> IgapinRate <i class="fas fa-star"></i>
            </a>
        @elseif(Auth::user()->role == 'penilai')
            <a href="{{ route('penilai.dashboard') }}" class="text-2xl font-semibold py-3">
                 <i class="fas fa-star"></i> IgapinRate <i class="fas fa-star"></i>
            </a>
        @endif
    </span>
  </div>
</nav>

<!-- Sidebar -->
<aside id="logo-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full sm:translate-x-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700" aria-label="Sidebar">
  <div class="h-full flex flex-col justify-between px-3 pb-4 overflow-y-auto bg-white dark:bg-gray-800">
    @if (Auth::user()->role == 'karyawan')
         <ul class="space-y-2 font-medium">
      <li>
        <a href="{{ route('karyawan.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 22 21">
            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066Z"/>
            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
          </svg>
          <span class="ms-3">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="{{ route('karyawan.jurnal.show', Auth::user()->karyawan->id_karyawan) }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-flag"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Jurnal</span>
        </a>
      </li>
      <li>
        <a href="{{ route('karyawan.jurnal.histori', Auth::user()->karyawan->id_karyawan) }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-flag"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Histori</span>
        </a>
      </li>
    </ul>
    @elseif (Auth::user()->role == 'admin')
         <ul class="space-y-2 font-medium">
      <li>
        <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 22 21">
            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066Z"/>
            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
          </svg>
          <span class="ms-3">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.user.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-users"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Users</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.karyawan.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-users"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Karyawan</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.kategori-penilaian.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-list"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Kategori Penilaian</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.laporan.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-flag"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Laporan</span>
        </a>
      </li>
      <li>
        <a href="{{ route('admin.divisi.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-hotel"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Divisi</span>
        </a>
      </li>
    </ul>

    @elseif (Auth::user()->role == 'penilai')
       <ul class="space-y-2 font-medium">
      <li>
        <a href="{{ route('penilai.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 22 21">
            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066Z"/>
            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
          </svg>
          <span class="ms-3">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="{{ route('penilai.kategori-penilaian.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-users"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Kategori Penilaian</span>
        </a>
        <a href="{{ route('penilai.penilaian.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-book"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Penilaian</span>
        </a>
      </li>
       </ul>
    @else
         <ul class="space-y-2 font-medium">
      <li>
        <a href="{{ route('kepala.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 22 21">
            <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066Z"/>
            <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
          </svg>
          <span class="ms-3">Dashboard</span>
        </a>
      </li>
      <li>
        <a href="{{ route('kepala.penilaian.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-book"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Penilaian</span>
        </a>
        <a href="{{ route('kepala.laporan.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
          <i class="fas fa-flag"></i>
          <span class="flex-1 ms-3 whitespace-nowrap">Laporan</span>
        </a>
      </li>
    </ul>
    @endif

    <!-- Tombol Logout -->
    <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
        <form id="logoutForm" action="{{ route('logout') }}" method="POST" class="w-full">
            @csrf
            <button type="button" id="logoutBtn" class="flex items-center p-2 text-red-600 rounded-lg hover:bg-red-500 hover:text-white border border-red-500 cursor-pointer dark:hover:bg-red-600 dark:hover:text-gray-900 group w-full">
                <i class="fas fa-sign-out-alt"></i>
                <span class="flex-1 ms-3 whitespace-nowrap">Logout</span>
            </button>
        </form>
    </div>

  </div>
</aside>

<main class="flex-1 mt-5 p-4 transition-all duration-300 lg:ml-64 md:ml-0">
    @yield('content')
</main>

@yield('scripts')
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="https://kit.fontawesome.com/6942f8f905.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    document.getElementById('logoutBtn').addEventListener('click', function (e) {
        Swal.fire({
            title: 'Yakin ingin logout?',
            text: "Sesi Anda akan dihentikan.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e3342f',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, logout!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logoutForm').submit();
            }
        });
    });
</script>
</body>
</html>
