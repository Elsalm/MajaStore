import "./bootstrap";
import { createApp } from "vue";
import Footer from "./components/Footer.vue";
import Header from "./components/Header.vue";

const app = createApp();

app.component("header-component", Header);
app.component("footer-component", Footer);

app.mount("#app");
