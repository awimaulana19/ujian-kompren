 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
     <div class="app-brand demo">
         <a href="" class="app-brand-link">
            <h1>Admin</h1>
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
         <li class="menu-item {{ request()->is('dashboard*') ? 'active' : '' }}">
             <a href="/dashboard" class="menu-link">
                 <i class="menu-icon tf-icons bx bxs-home-circle"></i>
                 <div data-i18n="Analytics">Dashboard</div>
             </a>
         </li>
         <li class="menu-header small text-uppercase">
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
 </script>
