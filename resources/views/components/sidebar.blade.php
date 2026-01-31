 <div class="main-sidebar sidebar-style-2">
     <aside id="sidebar-wrapper">
         <div class="sidebar-brand">
             <a href="{{ route('dashboard') }}">
                 <img alt="image" src="{{ asset('assets/img/logo.svg') }}" class="header-logo" />
                 <span class="logo-name"></span>
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
             <li class="dropdown {{ Request::is('contacts') ? 'active' : '' }}">
                 <a href="{{ route('contacts.index') }}" class="nav-link"><i data-feather="phone"></i><span>Контакты</span></a>
             </li>
             <li class="dropdown {{ Request::is('categories') ? 'active' : '' }}">
                 <a href="{{ route('categories.index') }}" class="nav-link"><i data-feather="folder"></i><span>Категории</span></a>
             </li>
             <li class="dropdown {{ Request::is('reviews') ? 'active' : '' }}">
                 <a href="{{ route('reviews.index') }}" class="nav-link"><i data-feather="star"></i><span>Отзывы</span></a>
             </li>
         </ul>
     </aside>
 </div>