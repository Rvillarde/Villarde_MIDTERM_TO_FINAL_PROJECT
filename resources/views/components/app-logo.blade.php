<style>
    .steam-title {
        font-family: "Orbitron", "Segoe UI", sans-serif;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #00c8ff;
        text-shadow:
            0 0 4px #00c8ff,
            0 0 8px #00c8ff,
            0 0 12px #0090c7;
        transition: text-shadow 0.3s ease, color 0.3s ease;
        white-space: nowrap;
    }

    .steam-title .white {
        color: #ffffff;
        text-shadow:
            0 0 4px #ffffff,
            0 0 8px #cfcfcf,
            0 0 14px #b3b3b3;
    }
</style>

<div class="flex aspect-square size-8 items-center justify-center rounded-md steam-icon"> 
    <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
</div>

<div class="ms-1 grid flex-1 text-start text-sm">
    <span class="steam-title mb-0.5 truncate leading-tight">
        <span class="blue">FAKE</span> <span class="white">STEAM</span>
    </span>
</div>


