 <div class="main-sidebar sidebar-style-2">
     <aside id="sidebar-wrapper">
         <div class="sidebar-brand">
             <a href="{{ route('dashboard') }}"> <img alt="image" src="{{ asset('assets/img/logo.png') }}" class="header-logo" /> <span
                     class="logo-name">Otika</span>
             </a>
         </div>
         <ul class="sidebar-menu">
             <li class="menu-header">Главное меню</li>
             <li class="dropdown {{ Request::is('dashboard') ? 'active' : '' }}">
                 <a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="monitor"></i><span>Панель управления</span></a>
             </li>
             <li class="dropdown {{ Request::is('hero-slides') ? 'active' : '' }}">
                 <a href="{{ route('hero-slides.index') }}" class="nav-link"><i data-feather="image"></i><span>Слайды Баннера</span></a>
             </li>
             <li class="dropdown {{ Request::is('faqs') ? 'active' : '' }}">
                 <a href="{{ route('faqs.index') }}" class="nav-link"><i data-feather="help-circle"></i><span>Вопросы и ответы</span></a>
             </li>
             <li class="dropdown {{ Request::is('abouts') ? 'active' : '' }}">
                 <a href="{{ route('abouts.index') }}" class="nav-link"><i data-feather="info"></i><span>О нас</span></a>
             </li>
         </ul>
     </aside>
 </div>