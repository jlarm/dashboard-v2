import './bootstrap';
import focus from '@alpinejs/focus';
import mask from '@alpinejs/mask';
import persist from '@alpinejs/persist';
import AlpineFloatingUI from '@awcodes/alpine-floating-ui';
import collapse from '@alpinejs/collapse';
import Clipboard from '@ryangjchandler/alpine-clipboard';
import Autosize from '@marcreichel/alpine-autosize';
import './datepicker';

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(focus);
    window.Alpine.plugin(mask);
    window.Alpine.plugin(persist);
    window.Alpine.plugin(AlpineFloatingUI);
    window.Alpine.plugin(collapse);
    window.Alpine.plugin(Clipboard);
    window.Alpine.plugin(Autosize);
});
