 <div class="main-sidebar sidebar-style-2">
     <aside id="sidebar-wrapper">
         <div class="sidebar-brand" style="padding: 25px 20px 20px 20px;">
             <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 12px;">
                 <img alt="image" src="{{ asset('assets/img/logo.svg') }}" style="width: 50px !important; height: 50px !important; min-width: 50px; min-height: 50px; object-fit: contain; flex-shrink: 0;" />
                 <span style="font-size: 16px; font-weight: 700; color: #191d21; line-height: 1.3;">Toqtarbay<br>Tours</span>
             </a>
         </div>
         <ul class="sidebar-menu">
             <li class="menu-header">Главное меню</li>
             <li class="dropdown {{ Request::is('dashboard') ? 'active' : '' }}">
                 <a href="{{ route('dashboard') }}" class="nav-link"><i data-feather="monitor"></i><span>Панель управления</span></a>
             </li>
             <li class="dropdown {{ Request::is('tours') ? 'active' : '' }}">
                 <a href="{{ route('tours.index') }}" class="nav-link"><i data-feather="map"></i><span>Туры</span></a>
             </li>
             <li class="dropdown {{ Request::is('features') ? 'active' : '' }}">
                 <a href="{{ route('features.index') }}" class="nav-link"><i data-feather="list"></i><span>Функции</span></a>
             </li>
             <li class="dropdown {{ Request::is('categories') ? 'active' : '' }}">
                 <a href="{{ route('categories.index') }}" class="nav-link"><i data-feather="folder"></i><span>Категории туров</span></a>
             </li>
             <li class="dropdown {{ Request::is('reviews*') ? 'active' : '' }}">
                 <a href="#" class="menu-toggle nav-link has-dropdown" style="display: flex; justify-content: space-between; align-items: center; gap: 10px;">
                     <span style="display: flex; align-items: center; gap: 8px;">
                         <i data-feather="star"></i>
                         <span>Отзывы</span>
                     </span>
                     @php
                     $pendingReviewsCount = \App\Models\Review::where('client_created', true)->where('is_checked', false)->count();
                     @endphp
                     @if($pendingReviewsCount > 0)
                     <span class="badge badge-warning" style="width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; padding: 0; font-size: 10px; font-weight: 600; margin-right: 5px; flex-shrink: 0;">{{ $pendingReviewsCount }}</span>
                     @endif
                 </a>
                 <ul class="dropdown-menu">
                     <li>
                         <a class="nav-link" href="{{ route('reviews.admin') }}">
                             <i data-feather="user"></i> Админ отзывы
                         </a>
                     </li>
                     <li>
                         <a class="nav-link" href="{{ route('reviews.client') }}">
                             <i data-feather="users"></i> Отзывы клиентов
                             @if($pendingReviewsCount > 0)
                             <span class="badge badge-warning" style="width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; padding: 0; font-size: 10px; font-weight: 600; margin-left: 5px;">{{ $pendingReviewsCount }}</span>
                             @endif
                         </a>
                     </li>
                 </ul>
             </li>
             <li class="dropdown {{ Request::is('bookings') ? 'active' : '' }}">
                 <a href="{{ route('bookings.index') }}" class="nav-link">
                     <i data-feather="calendar"></i>
                     <span>Бронирования</span>
                     @if(isset($pendingBookingsCount) && $pendingBookingsCount > 0)
                     <span class="badge badge-warning" style="width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; padding: 0; font-size: 10px; font-weight: 600; margin-left: 5px;">{{ $pendingBookingsCount }}</span>
                     @endif
                 </a>
             </li>
             <li class="dropdown {{ Request::is('questions') ? 'active' : '' }}">
                 <a href="{{ route('questions.index') }}" class="nav-link">
                     <i data-feather="message-circle"></i>
                     <span>Вопросы</span>
                     @php
                     $pendingQuestionsCount = \App\Models\Question::where('status', 'pending')->count();
                     @endphp
                     @if($pendingQuestionsCount > 0)
                     <span class="badge badge-warning" style="width: 22px; height: 22px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center; padding: 0; font-size: 10px; font-weight: 600; margin-left: 5px;">{{ $pendingQuestionsCount }}</span>
                     @endif
                 </a>
             </li>
             <li class="dropdown {{ Request::is('hero-slides') ? 'active' : '' }}">
                 <a href="{{ route('hero-slides.index') }}" class="nav-link"><i data-feather="image"></i><span>Слайды Баннера</span></a>
             </li>
             <li class="dropdown {{ Request::is('faqs') ? 'active' : '' }}">
                 <a href="{{ route('faqs.index') }}" class="nav-link"><i data-feather="help-circle"></i><span>Вопросы и ответы</span></a>
             </li>
             <li class="dropdown {{ Request::is('faq-categories') ? 'active' : '' }}">
                 <a href="{{ route('faq-categories.index') }}" class="nav-link"><i data-feather="layers"></i><span>Категории FAQ</span></a>
             </li>
             <li class="dropdown {{ Request::is('contacts') ? 'active' : '' }}">
                 <a href="{{ route('contacts.index') }}" class="nav-link"><i data-feather="phone"></i><span>Контакты</span></a>
             </li>
             <li class="dropdown {{ Request::is('abouts') ? 'active' : '' }}">
                 <a href="{{ route('abouts.index') }}" class="nav-link"><i data-feather="info"></i><span>О нас</span></a>
             </li>
             <li class="dropdown {{ Request::is('languages') ? 'active' : '' }}">
                 <a href="{{ route('languages.index') }}" class="nav-link"><i data-feather="globe"></i><span>Языки</span></a>
             </li>
         </ul>
     </aside>
 </div>