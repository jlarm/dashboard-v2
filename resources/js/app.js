import './bootstrap';
import Alpine from 'alpinejs';
import focus from '@alpinejs/focus';
import mask from '@alpinejs/mask';
import persist from '@alpinejs/persist'
import AlpineFloatingUI from '@awcodes/alpine-floating-ui'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import collapse from '@alpinejs/collapse'
import Clipboard from "@ryangjchandler/alpine-clipboard"

Alpine.plugin(focus);
Alpine.plugin(mask);
Alpine.plugin(persist);
Alpine.plugin(AlpineFloatingUI)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.plugin(collapse)
Alpine.plugin(Clipboard)

window.Alpine = Alpine;

Alpine.start();
