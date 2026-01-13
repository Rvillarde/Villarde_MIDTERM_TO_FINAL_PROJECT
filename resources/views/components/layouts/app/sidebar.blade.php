<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
<flux:navlist.group :heading="__('Platform')" class="grid">
    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
    <flux:navlist.item icon="book-open-text" :href="route('categories.index')" :current="request()->routeIs('categories*')" wire:navigate>{{ __('Categories') }}</flux:navlist.item>
    <flux:navlist.item icon="trash" :href="route('trash.index')" :current="request()->routeIs('trash*')" wire:navigate>{{ __('Trash') }}</flux:navlist.item>
</flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
<flux:dropdown class="hidden lg:block" position="bottom" align="start">
    <flux:profile
        :name="auth()->user()->name"
        :initials="auth()->user()->initials()"
        icon:trailing="chevrons-up-down"
        class="text-[#66c0f4] font-semibold drop-shadow-[0_0_6px_rgba(102,192,244,0.8)]"
    />

    <flux:menu
        class="w-[220px]
        bg-[#1b2838]/95
        border border-[#2a475e]
        shadow-[0_0_15px_rgba(102,192,244,0.25)]
        text-white"
    >
        <flux:menu.radio.group>
            <div class="p-0 text-sm font-normal">
                <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">

                    <!-- Avatar -->
                    <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                        <span
                            class="flex h-full w-full items-center justify-center rounded-lg
                            bg-[#2a475e] text-[#66c0f4]
                            drop-shadow-[0_0_4px_rgba(102,192,244,0.8)]"
                        >
                            {{ auth()->user()->initials() }}
                        </span>
                    </span>

                    <!-- User Info -->
                    <div class="grid flex-1 text-start text-sm leading-tight">
                        <span class="truncate font-semibold
                            text-white drop-shadow-[0_0_4px_rgba(255,255,255,0.6)]">
                            {{ auth()->user()->name }}
                        </span>

                        <span class="truncate text-xs text-[#66c0f4]
                            drop-shadow-[0_0_3px_rgba(102,192,244,0.7)]">
                            {{ auth()->user()->email }}
                        </span>
                    </div>
                </div>
            </div>
        </flux:menu.radio.group>

        <!-- Divider -->
        <flux:menu.separator class="border-[#2a475e]" />

        <flux:menu.radio.group>
            <flux:menu.item
                :href="route('profile.edit')"
                icon="cog"
                wire:navigate
                class="hover:bg-[#2a475e]/50 hover:text-[#66c0f4] transition"
            >
                {{ __('Settings') }}
            </flux:menu.item>
        </flux:menu.radio.group>

        <flux:menu.separator class="border-[#2a475e]" />

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="w-full">
            @csrf
            <flux:menu.item
                as="button"
                type="submit"
                icon="arrow-right-start-on-rectangle"
                class="w-full hover:bg-red-600/20 hover:text-red-400 transition"
            >
                {{ __('Log Out') }}
            </flux:menu.item>
        </form>
    </flux:menu>
</flux:dropdown>

        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
