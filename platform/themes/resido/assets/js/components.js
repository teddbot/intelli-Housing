'use strict';
import { createApp } from 'vue';

import PropertyComponent from './components/PropertyComponent.vue';
import RealEstateReviewsComponent from './components/RealEstateReviewsComponent.vue';

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


const app = createApp({});

app.component('property-component', PropertyComponent);
app.component('real-estate-reviews-component', RealEstateReviewsComponent);

app.config.globalProperties.__ = (key) => {
    return window.trans[key] !== 'undefined' ? window.trans[key] : key;
};

app.mount('#app')
