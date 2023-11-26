 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
     <div class="app-brand demo">
         <a href="" class="app-brand-link">
             <span>
                 <h6 class="mb-2">{{ auth()->user()->nama }}</h6>
                 <p class="mb-0 text-muted">{{ auth()->user()->username }}</p>
             </span>
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
             <i class="bx bx-chevron-left bx-sm align-middle"></i>
         </a>
     </div>

     <div class="menu-inner-shadow"></div>
     @if (auth()->user()->roles == 'admin')
         <ul class="menu-inner py-1">
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Dashboard</span>
             </li>
             <li class="menu-item {{ request()->is('dashboard-admin*') ? 'active' : '' }}">
                 <a href="/dashboard-admin" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-home-circle"></i>
                     <div data-i18n="Analytics">Dashboard</div>
                 </a>
             </li>
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Pengguna</span>
             </li>
             <li id="dosen" class="menu-item">
                 <a href="/admin/dosen" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-user-badge"></i>
                     <div data-i18n="Analytics">Data Dosen</div>
                 </a>
             </li>
             <li id="mahasiswa" class="menu-item">
                 <a href="/admin/mahasiswa" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-user"></i>
                     <div data-i18n="Analytics">Data Mahasiswa</div>
                 </a>
             </li>
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Pengujian</span>
             </li>
             <li id="matkul" class="menu-item">
                 <a href="/admin/matkul" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-book"></i>
                     <div data-i18n="Analytics">Mata Kuliah</div>
                 </a>
             </li>
         </ul>
     @endif
     @if (auth()->user()->roles == 'dosen')
         <ul class="menu-inner py-1">
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Dashboard</span>
             </li>
             <li class="menu-item {{ request()->is('dashboard-dosen*') ? 'active' : '' }}">
                 <a href="/dashboard-dosen" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-home-circle"></i>
                     <div data-i18n="Analytics">Dashboard</div>
                 </a>
             </li>
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Pengujian</span>
             </li>
             @foreach (auth()->user()->matkul as $item)
                 <li class="menu-item {{ isset($matkul) && $matkul->id === $item->id ? 'active' : '' }}">
                     <a href="/dosen/matkul/{{ $item->id }}" class="menu-link">
                         <i class="menu-icon tf-icons bx bxs-book"></i>
                         <div data-i18n="Analytics">{{ $item->nama }}</div>
                     </a>
                 </li>
             @endforeach
             {{-- <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Data Soal</span>
             </li>
             <li id="soalMudah" class="menu-item">
                 <a href="/soal-mudah" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-book"></i>
                     <div data-i18n="Analytics">Soal Mudah</div>
                 </a>
             </li>
             <li id="soalMenengah" class="menu-item">
                 <a href="/soal-menengah" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-book"></i>
                     <div data-i18n="Analytics">Soal Menengah</div>
                 </a>
             </li>
             <li id="soalSulit" class="menu-item">
                 <a href="/soal-sulit" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-book"></i>
                     <div data-i18n="Analytics">Soal Sulit</div>
                 </a>
             </li> --}}
         </ul>
     @endif
     @if (auth()->user()->roles == 'mahasiswa')
         @php
             $penguji = json_decode(auth()->user()->penguji, true);

             $data_lengkap_penguji = [];

             foreach ($penguji as $key => $value) {
                 $user = app(\App\Models\User::class)::find($value['user_id']);

                 $matkul = app(\App\Models\Matkul::class)::find($value['matkul_id']);

                 $data_lengkap_penguji[$key] = [
                     'user_id' => $value['user_id'],
                     'nama' => $user->nama,
                     'matkul_id' => $value['matkul_id'],
                     'matkul_nama' => $matkul->nama,
                 ];
             }

             $penguji = $data_lengkap_penguji;
         @endphp
         <ul class="menu-inner py-1">
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Dashboard</span>
             </li>
             <li class="menu-item {{ request()->is('dashboard-mahasiswa*') ? 'active' : '' }}">
                 <a href="/dashboard-mahasiswa" class="menu-link">
                     <i class="menu-icon tf-icons bx bxs-home-circle"></i>
                     <div data-i18n="Analytics">Dashboard</div>
                 </a>
             </li>
             <li class="menu-header small text-uppercase">
                 <span class="menu-header-text">Pengujian</span>
             </li>
             @foreach ($penguji as $item)
                 <li class="menu-item {{ isset($matkul) && $matkul->id === $item['matkul_id'] ? 'active' : '' }}">
                     <a href="/mahasiswa/matkul/{{ $item['matkul_id'] }}" class="menu-link">
                         <i class="menu-icon tf-icons bx bxs-book"></i>
                         <div data-i18n="Analytics">{{ $item['matkul_nama'] }}</div>
                     </a>
                 </li>
             @endforeach
         </ul>
     @endif
 </aside>

 <script>
     if (document.title === "Soal Mudah") {
         document.getElementById("soalMudah").classList.add("active");
     }
     if (document.title === "Soal Menengah") {
         document.getElementById("soalMenengah").classList.add("active");
     }
     if (document.title === "Soal Sulit") {
         document.getElementById("soalSulit").classList.add("active");
     }
     if (document.title === "Data Dosen") {
         document.getElementById("dosen").classList.add("active");
     }
     if (document.title === "Data Mahasiswa") {
         document.getElementById("mahasiswa").classList.add("active");
     }
     if (document.title === "Mata Kuliah") {
         document.getElementById("matkul").classList.add("active");
     }
 </script>
