import './bootstrap';
import AlpineFloatingUI from '@awcodes/alpine-floating-ui';
import Clipboard from '@ryangjchandler/alpine-clipboard';
import Autosize from '@marcreichel/alpine-autosize';
import './datepicker';

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(AlpineFloatingUI);
    window.Alpine.plugin(Clipboard);
    window.Alpine.plugin(Autosize);
});
