<header class="sticky top-0 z-20 h-16 border-b border-border bg-card/50 backdrop-blur flex items-center justify-between gap-2 px-4 lg:px-6">
    <div class="flex items-center gap-2">
        <button onclick="openMobileSidebar()"
                class="lg:hidden h-9 w-9 rounded-md border border-border inline-flex items-center justify-center hover:bg-accent flex-shrink-0"
                aria-label="Open menu">
            <span class="iconify w-[18px] h-[18px]" data-icon="lucide:menu"></span>
        </button>
        <h2 class="text-sm font-medium text-muted-foreground hidden sm:block">@yield('title', 'Dashboard')</h2>
    </div>

    <div class="flex items-center gap-2">
        <button onclick="toggleTheme()"
                class="h-9 w-9 rounded-md border border-border inline-flex items-center justify-center hover:bg-accent text-muted-foreground"
                title="Toggle theme">
            <span class="theme-light-icon iconify w-[18px] h-[18px]" data-icon="lucide:sun"></span>
            <span class="theme-dark-icon hidden iconify w-[18px] h-[18px]" data-icon="lucide:moon"></span>
        </button>

        <div class="h-5 w-px bg-border"></div>

        <div class="relative" id="userMenuWrapper">
            <button onclick="toggleUserMenu()"
                    class="h-9 flex items-center gap-2 rounded-md border border-border hover:bg-accent px-2.5">
                <div class="h-6 w-6 rounded bg-primary/10 text-primary inline-flex items-center justify-center text-[10px] font-bold shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <span class="text-sm font-medium truncate hidden sm:block">{{ auth()->user()->name }}</span>
                <span class="iconify w-3.5 h-3.5 text-muted-foreground" data-icon="lucide:chevron-down"></span>
            </button>

            <div id="userMenuDropdown"
                 class="hidden absolute right-0 top-full mt-2 w-56 bg-popover border border-border rounded-lg shadow-lg py-1.5 z-50">
                <div class="px-4 py-3 border-b border-border">
                    <p class="text-sm font-semibold text-foreground">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-muted-foreground mt-0.5">{{ auth()->user()->email }}</p>
                </div>
                <div class="py-1">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-2 px-4 py-2 text-sm text-destructive hover:bg-destructive/10 transition-colors">
                            <span class="iconify w-4 h-4" data-icon="lucide:log-out"></span> Sign out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    function toggleUserMenu() {
        document.getElementById('userMenuDropdown').classList.toggle('hidden');
    }
    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('userMenuWrapper');
        if (wrapper && !wrapper.contains(e.target)) {
            document.getElementById('userMenuDropdown')?.classList.add('hidden');
        }
    });
</script>
