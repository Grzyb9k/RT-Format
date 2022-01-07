require("./bootstrap");

import { createApp } from "vue";

import Home from "./components/Home.vue";
import  DeleteIcon  from 'vue-material-design-icons/Delete.vue';
import  EditIcon  from 'vue-material-design-icons/pencil.vue';
import LitepieDatepicker from 'litepie-datepicker';
import { createRouter, createWebHistory } from "vue-router";
const app = createApp({
    components: {
        Home,
    }
});
const routes = [
    { path: "/", component: Home },
];
const router = createRouter({
    history: createWebHistory(),
    routes
});
app.use(LitepieDatepicker);
app.use(router);
app.component('edit-icon', EditIcon);
app.component('delete-icon', DeleteIcon);
app.mount("#app");
