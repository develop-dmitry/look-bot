import {createApp} from "vue";

import Welcome from "./Welcome.vue";

if (document.querySelector('#welcome')) {
    createApp(Welcome).mount('#welcome');
}
