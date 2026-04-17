<flux:sidebar sticky collapsible="mobile" class="bg-zinc-50 dark:bg-zinc-900 border-r border-zinc-200 dark:border-zinc-700">
    <flux:sidebar.header>
        <flux:sidebar.brand
            href="#"
            logo="https://fluxui.dev/img/demo/logo.png"
            logo:dark="https://fluxui.dev/img/demo/dark-mode-logo.png"
            name="ARMP"
        />
        <flux:sidebar.collapse class="lg:hidden" />
    </flux:sidebar.header>

    <flux:sidebar.nav>
        <flux:sidebar.item icon="home" href="#" current>Home</flux:sidebar.item>
        <flux:sidebar.item icon="inbox" badge="12" href="#">Inbox</flux:sidebar.item>
        <flux:sidebar.item icon="document-text" href="#">Documents</flux:sidebar.item>
        <flux:sidebar.item icon="calendar" href="#">Calendar</flux:sidebar.item>
        <flux:sidebar.group expandable heading="Favorites" class="grid">
            <flux:sidebar.item href="#">Marketing site</flux:sidebar.item>
            <flux:sidebar.item href="#">Android app</flux:sidebar.item>
            <flux:sidebar.item href="#">Brand guidelines</flux:sidebar.item>
        </flux:sidebar.group>
    </flux:sidebar.nav>

    <flux:sidebar.spacer />

    <flux:sidebar.nav>
        <flux:sidebar.item icon="cog-6-tooth" href="#">Settings</flux:sidebar.item>
        <flux:sidebar.item icon="information-circle" href="#">Help</flux:sidebar.item>
    </flux:sidebar.nav>

    <flux:dropdown position="top" align="start" class="max-lg:hidden">
        <flux:sidebar.profile avatar="https://fluxui.dev/img/demo/user.png" name="Olivia Martin" />
        <x-central-user-menu />
    </flux:dropdown>
</flux:sidebar>
