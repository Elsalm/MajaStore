import "./bootstrap";
import { createApp } from "vue";
import Footer from "./components/layout/Footer.vue";
import Header from "./components/layout/Header.vue";
import HomeBody from "./components/home/Body.vue";
import ProductForm from "./components/products/ProductForm.vue";
import ProductsBody from "./components/products/ProductsBody.vue";
import Login from "./pages/login.vue";
import Register from "./pages/register.vue";
import Cart from "./pages/cart.vue";
import Product from "./pages/product.vue";
const app = createApp();

app.component("header-component", Header);
app.component("footer-component", Footer);
app.component("home-body", HomeBody);
app.component("product-form", ProductForm);
app.component("products-body", ProductsBody);
app.component("login", Login);
app.component("register", Register);
app.component("cart", Cart);
app.component("product", Product);

app.mount("#app");
