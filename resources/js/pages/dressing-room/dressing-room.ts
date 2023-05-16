import {createApp} from 'vue';
import Vue3TouchEvents from 'vue3-touch-events';

import DressingRoom from './DressingRoom.vue';

if (document.querySelector('#dressing-room')) {
    createApp(DressingRoom).use(Vue3TouchEvents).mount('#dressing-room');
}
