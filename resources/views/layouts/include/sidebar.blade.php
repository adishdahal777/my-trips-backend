@php
    $navItems = [
        ['title' => 'Dashboard', 'icon' => 'lucide:layout-dashboard', 'route' => 'admin.dashboard'],
        ['title' => 'Trips', 'icon' => 'lucide:map', 'route' => 'admin.trips.index'],
        ['title' => 'Users', 'icon' => 'lucide:users', 'route' => 'admin.users.index'],
        ['title' => 'Destinations', 'icon' => 'lucide:globe', 'route' => 'admin.destinations.index'],
        ['title' => 'Ratings', 'icon' => 'lucide:star', 'route' => 'admin.ratings.index'],
        ['title' => 'Landing Page', 'icon' => 'lucide:layout', 'route' => 'admin.landing.index'],
    ];
@endphp

<aside id="appSidebar" role="navigation" aria-label="Main navigation"
    class="fixed left-0 top-0 h-screen w-[260px] bg-sidebar text-sidebar-foreground border-r border-sidebar-border
           flex flex-col z-40 overflow-hidden transition-transform lg:translate-x-0 -translate-x-full">

    <div class="flex items-center h-16 px-4 border-b border-sidebar-border flex-shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 w-full min-w-0">
            <div class="w-8 h-8 bg-nepal-blue rounded-md flex items-center justify-center flex-shrink-0">
                <span class="iconify w-4 h-4 text-white" data-icon="lucide:map"></span>
            </div>
            <div class="min-w-0">
                <p class="text-sm font-bold leading-none truncate">MyTrips</p>
                <p class="text-[10px] text-sidebar-foreground/60 mt-0.5">Super Admin</p>
            </div>
        </a>
    </div>

    <nav class="flex-1 overflow-y-auto py-3 custom-scrollbar">
        <ul class="px-3 space-y-0.5">
            @foreach ($navItems as $item)
                @php $isActive = request()->routeIs($item['route'].'*'); @endphp
                <li>
                    <a href="{{ route($item['route']) }}"
                       @if($isActive) aria-current="page" @endif
                       class="flex items-center gap-3 px-3 py-2 rounded-md text-sm transition-colors
                              {{ $isActive
                                  ? 'bg-sidebar-accent text-sidebar-accent-foreground font-medium'
                                  : 'text-sidebar-foreground/70 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground' }}">
                        <span class="iconify w-[18px] h-[18px] flex-shrink-0"
                              data-icon="{{ $item['icon'] }}"></span>
                        <span class="truncate">{{ $item['title'] }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </nav>

    <div class="border-t border-sidebar-border p-3">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="w-full flex items-center gap-3 px-3 py-2 rounded-md text-sm text-sidebar-foreground/70 hover:bg-sidebar-accent hover:text-sidebar-accent-foreground transition-colors">
                <span class="iconify w-[18px] h-[18px] flex-shrink-0" data-icon="lucide:log-out"></span>
                Sign out
            </button>
        </form>
    </div>
</aside>
