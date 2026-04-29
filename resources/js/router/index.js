import { createRouter, createWebHistory } from 'vue-router';

// Importar las páginas/vistas
import Home from '../pages/Home.vue';
import About from '../pages/About.vue';
import Contact from '../pages/Contact.vue';
import ProductList from '../pages/ProductList.vue';
import ProductDetail from '../pages/ProductDetail.vue';
import Cart from '../pages/Cart.vue';
import Checkout from '../pages/Checkout.vue';
import PaymentSuccess from '../pages/PaymentSuccess.vue';
import PaymentPending from '../pages/PaymentPending.vue';
import PaymentFailure from '../pages/PaymentFailure.vue';
import CustomerOrders from '../pages/CustomerOrders.vue';
import OrderTracking from '../pages/OrderTracking.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/productos',
    name: 'ProductList',
    component: ProductList
  },
  {
    path: '/nosotros',
    name: 'About',
    component: About
  },
  {
    path: '/contacto',
    name: 'Contact',
    component: Contact
  },
  {
    path: '/producto/:id',
    name: 'ProductDetail',
    component: ProductDetail
  },
  {
    path: '/carrito',
    name: 'Cart',
    component: Cart
  },
  {
    path: '/checkout',
    name: 'Checkout',
    component: Checkout
  },
  {
    path: '/checkout/exito',
    name: 'PaymentSuccess',
    component: PaymentSuccess
  },
  {
    path: '/checkout/pendiente',
    name: 'PaymentPending',
    component: PaymentPending
  },
  {
    path: '/checkout/error',
    name: 'PaymentFailure',
    component: PaymentFailure
  },
  {
    path: '/mis-pedidos',
    name: 'CustomerOrders',
    component: CustomerOrders
  },
  {
    path: '/seguimiento-pedido/:orderNumber',
    name: 'OrderTracking',
    component: OrderTracking,
    props: true
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    // Si hay una posición guardada (navegación hacia atrás/adelante)
    if (savedPosition) {
      return savedPosition;
    }
    // Siempre volver al inicio en navegación nueva
    return { top: 0, behavior: 'smooth' };
  }
});

export default router;
