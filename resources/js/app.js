import "./bootstrap";
import { createApp } from "vue";
import Footer from "./components/layout/Footer.vue";
import Header from "./components/layout/Header.vue";
import HomeBody from "./components/home/Body.vue";
import ProductForm from "./components/products/ProductForm.vue";
import ProductsBody from "./components/products/ProductsBody.vue";
const app = createApp();

app.component("header-component", Header);
app.component("footer-component", Footer);
app.component("home-body", HomeBody);
app.component("product-form", ProductForm);
app.component("products-body", ProductsBody);

app.mount("#app");
