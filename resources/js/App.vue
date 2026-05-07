<template>
  <v-app>
    <!-- Navbar -->
    <v-app-bar
      ref="navbar"
      elevation="0"
      height="auto"
      class="py-0 main-navbar"
    >
      <v-container class="navbar-container">
        <v-app-bar-title class="pa-0">
          <router-link to="/" class="brand-logo text-decoration-none">
            <div class="brand-lockup">
              <div class="brand-mark">
                <img :src="logo" alt="IzaguirreQu Logo" />
              </div>
              <div class="brand-copy">
                <span class="brand-wordmark">IzaguirreQu</span>
                <span class="brand-note">joyeria artesanal mexicana</span>
              </div>
            </div>
          </router-link>
        </v-app-bar-title>

        <v-spacer></v-spacer>

        <div class="nav-links d-none d-md-flex align-center">
          <v-btn
            :to="{ name: 'Home' }"
            variant="text"
            class="nav-link"
          >
            Inicio
          </v-btn>
          <v-btn
            :to="{ name: 'About' }"
            variant="text"
            class="nav-link"
          >
            Nosotros
          </v-btn>
          <v-btn
            :to="{ name: 'ProductList' }"
            variant="text"
            class="nav-link"
          >
            Colección
          </v-btn>
          <v-btn
            :to="{ name: 'Contact' }"
            variant="text"
            class="nav-link"
          >
            Contacto
          </v-btn>
          <v-btn
            :to="{ name: 'CustomerOrders' }"
            variant="text"
            class="nav-link"
          >
            Mis pedidos
          </v-btn>
          <v-btn
            :to="{ name: 'Cart' }"
            icon
            variant="text"
            class="nav-cart"
            size="large"
          >
            <v-badge
              v-if="itemCount > 0"
              :content="itemCount"
              color="#8c745f"
              text-color="white"
            >
              <v-icon>mdi-shopping</v-icon>
            </v-badge>
            <v-icon v-else>mdi-shopping-outline</v-icon>
          </v-btn>
        </div>

        <!-- Mobile Menu -->
        <v-app-bar-nav-icon
          class="d-md-none mobile-nav-toggle"
          @click="drawer = !drawer"
        ></v-app-bar-nav-icon>
      </v-container>
    </v-app-bar>

    <!-- Mobile Drawer -->
    <v-navigation-drawer
      v-model="drawer"
      temporary
      location="right"
      class="drawerapp"
    >
      <v-list>
        <v-list-item
          :to="{ name: 'Home' }"
          prepend-icon="mdi-home"
          title="Inicio"
        ></v-list-item>
        <v-list-item
          :to="{ name: 'About' }"
          prepend-icon="mdi-heart-outline"
          title="Nosotros"
        ></v-list-item>
        <v-list-item
          :to="{ name: 'ProductList' }"
          prepend-icon="mdi-shopping"
          title="Colección"
        ></v-list-item>
        <v-list-item
          :to="{ name: 'Contact' }"
          prepend-icon="mdi-email-outline"
          title="Contacto"
        ></v-list-item>
        <v-list-item
          :to="{ name: 'CustomerOrders' }"
          prepend-icon="mdi-package-variant-closed"
          title="Mis pedidos"
        ></v-list-item>
        <v-list-item
          :to="{ name: 'Cart' }"
          prepend-icon="mdi-cart"
        >
          <template v-slot:title>
            Carrito
            <v-chip v-if="itemCount > 0" size="small" class="ml-2">{{ itemCount }}</v-chip>
          </template>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>

    <!-- Contenido principal -->
    <v-main>
      <router-view></router-view>
    </v-main>

    <!-- Botón flotante de WhatsApp -->
    <v-btn
      class="whatsapp-float"
      color="#25D366"
      size="x-large"
      icon
      elevation="8"
      href="https://wa.me/5580091558?text=Hola,%20me%20interesan%20sus%20productos"
      target="_blank"
    >
      <v-icon size="32">mdi-whatsapp</v-icon>
    </v-btn>

    <!-- Footer -->
    <v-footer class="footer">
      <v-container>
        <v-row class="py-8">
          <v-col cols="12" md="4" class="mb-6 mb-md-0">
            <div class="footer-brand mb-4">
              <div class="footer-brand-block">
                <div class="footer-mark">
                  <img :src="logo" alt="IzaguirreQu Logo" />
                </div>
                <div class="footer-brand-copy">
                  <strong>IzaguirreQu</strong>
                  <span>hecho con detalle y calma</span>
                </div>
              </div>
            </div>
            <p class="footer-desc">
              Joyería con tonos suaves, materiales nobles y una mirada contemporánea desde México.
            </p>
            <div class="social-links mt-4">
              <v-btn icon variant="text" class="footer-social" size="small" href="https://www.instagram.com/izaguirre.qu/" target="_blank">
                <v-icon>mdi-instagram</v-icon>
              </v-btn>
              <v-btn icon variant="text" class="footer-social" size="small" href="https://www.facebook.com/IzaguirreQu" target="_blank">
                <v-icon>mdi-facebook</v-icon>
              </v-btn>
            </div>
          </v-col>
          <v-col cols="12" md="4">
            <h4 class="footer-title mb-4">Explora</h4>
            <div class="footer-links">
              <router-link to="/" class="footer-link">Inicio</router-link>
              <router-link :to="{ name: 'About' }" class="footer-link">Nosotros</router-link>
              <router-link :to="{ name: 'ProductList' }" class="footer-link">Colección</router-link>
              <router-link :to="{ name: 'Contact' }" class="footer-link">Contacto</router-link>
              <router-link :to="{ name: 'CustomerOrders' }" class="footer-link">Mis pedidos</router-link>
            </div>
          </v-col>
          <!-- <v-col cols="12" md="3">
            <h4 class="footer-title mb-4">Información</h4>
            <div class="footer-links">
              <a href="#" class="footer-link">Sobre Nosotros</a>
              <a href="#" class="footer-link">Envíos y Devoluciones</a>
              <a href="#" class="footer-link">Términos y Condiciones</a>
              <a href="#" class="footer-link">Política de Privacidad</a>
            </div>
          </v-col> -->
          <v-col cols="12" md="4">
            <h4 class="footer-title mb-4">Contacto</h4>
            <div class="footer-contact">
              <div class="contact-item">
                <v-icon size="small" class="contact-icon">mdi-whatsapp</v-icon>
                <span>+52 558 009 1558</span>
              </div>
              <div class="contact-item">
                <v-icon size="small" class="contact-icon">mdi-email</v-icon>
                <span>Atencionaclientes@izaguirrequ.com</span>
              </div>
              <div class="contact-item">
                <v-icon size="small" class="contact-icon">mdi-map-marker</v-icon>
                <span>México</span>
              </div>
            </div>
          </v-col>
        </v-row>
        <v-divider class="footer-divider"></v-divider>
        <div class="text-center py-6">
          <p class="footer-copy text-body-2">
            © {{ new Date().getFullYear() }} IzaguirreQu. Todos los derechos reservados.
          </p>
        </div>
      </v-container>
    </v-footer>
  </v-app>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { useCart } from './composables/useCart';

const { itemCount } = useCart();
const drawer = ref(false);
const navbar = ref(null);
let lastScrollTop = 0;
let ticking = false;
const scrollThreshold = 5;
const logo = '/images/logo.webp';

// Scroll behavior with requestAnimationFrame for smooth performance
const handleScroll = () => {
  if (!navbar.value) return;

  const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
  const scrollDifference = Math.abs(scrollTop - lastScrollTop);

  // Only process if we've scrolled enough
  if (scrollDifference < scrollThreshold) {
    ticking = false;
    return;
  }

  // Don't hide navbar if drawer is open
  if (drawer.value) {
    navbar.value.$el.classList.remove('hidden');
    ticking = false;
    return;
  }

  // Hide/show navbar based on scroll direction
  if (scrollTop > lastScrollTop && scrollTop > 150) {
    // Scrolling down & past threshold -> hide navbar
    navbar.value.$el.classList.add('hidden');
  } else if (scrollTop < lastScrollTop || scrollTop <= 100) {
    // Scrolling up OR at top -> show navbar
    navbar.value.$el.classList.remove('hidden');
  }

  lastScrollTop = scrollTop <= 0 ? 0 : scrollTop;
  ticking = false;
};

const onScroll = () => {
  if (!ticking) {
    requestAnimationFrame(handleScroll);
    ticking = true;
  }
};

onMounted(() => {
  window.addEventListener('scroll', onScroll, { passive: true });
});

onUnmounted(() => {
  window.removeEventListener('scroll', onScroll);
});
</script>

<style>
/* Brand Logo */


html,
body,
* {
  font-family: var(--font-brand), serif;
  margin: 0;
  padding: 0;
  scroll-behavior: smooth;
}

header {
  font-family: var(--font-brand), serif;
  margin: 0;
  padding: 0;
  font-size: 16px;
  scroll-behavior: smooth;
}

/* WhatsApp Float Button */
.whatsapp-float {
  position: fixed !important;
  bottom: 20px;
  right: 20px;
  z-index: 1000;
  box-shadow: 0 4px 20px rgba(37, 211, 102, 0.4) !important;
  transition: all 0.3s ease !important;
}

.whatsapp-float:hover {
  transform: scale(1.1);
  box-shadow: 0 6px 30px rgba(37, 211, 102, 0.6) !important;
}

@media (max-width: 600px) {
  .whatsapp-float {
    bottom: 80px;
    right: 16px;
  }
}

.brand-logo {
  display: flex;
  align-items: center;
  color: #6b5b47;

}

/* Navbar hide animation */
.main-navbar {
  background: rgba(250, 247, 244, 0.92) !important;
  border-bottom: 1px solid rgba(184, 151, 120, 0.18);
  backdrop-filter: blur(18px);
  box-shadow: 0 10px 35px rgba(140, 116, 95, 0.08);
  transition: transform 0.3s ease-in-out !important;
  will-change: transform;
}

.navbar-container {
  display: flex !important;
  align-items: center !important;
  justify-content: space-between !important;
}

.main-navbar.hidden {
  transform: translateY(-100%) !important;
}

.drawerapp {
  background: linear-gradient(180deg, #f9f7f4 0%, #efe8e0 100%) !important;
  font-family: var(--font-brand), serif;
  padding-top: 100px;

}

.brand-lockup {
  display: flex;
  align-items: center;
  gap: 14px;
}

.brand-mark,
.footer-mark {
  width: 46px;
  height: 46px;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 10%;
  margin: auto;
  color: #fffaf4;
  font-size: 1rem;
  letter-spacing: 0.12em;
  box-shadow: 0 8px 20px rgba(239, 213, 190, 0.18);
  object-fit: contain;
  overflow: hidden;
}

.brand-mark img,
.footer-mark img {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.brand-copy,
.footer-brand-copy {
  display: flex;
  flex-direction: column;
  padding-top: 10px;
}

.brand-wordmark {
  color: #6b5b47;
  font-size: 1.45rem;
  letter-spacing: 0.06em;
  line-height: 1;
}

.brand-note {
  color: #9a866f;
  font-size: 0.72rem;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  margin-top: 0.3rem;
}

@media (min-width: 600px) and (max-width: 959px) {
  .drawerapp {
    padding-top: 70px;
  }
}

@media (min-width: 960px) {
  .drawerapp {
    padding-top: 80px;
  }
}
@media (max-width: 600px) {
  .brand-lockup {
    gap: 8px;
  }

  .brand-mark,
  .footer-mark {
    width: 42px;
    height: 42px;
    min-width: 42px;
    min-height: 42px;
    flex-shrink: 0;
  }

  .brand-wordmark {
    font-size: 1.05rem;
  }

  .brand-note {
    font-size: 0.58rem;
  }

  .v-toolbar__content {
    padding: 8px 16px !important;
  }

  .navbar-container {
    flex-wrap: nowrap !important;
  }

  .v-app-bar-title {
    flex: 0 1 auto !important;
    max-width: calc(100% - 60px) !important;
    overflow: hidden;
  }

  .brand-logo {
    display: block;
    width: 100%;
  }

  .nav-links {
    display: none !important;
  }
}

.brand-icon {
  font-size: 32px;
  line-height: 1;
}

.brand-text {
  display: flex;
  flex-direction: column;
  line-height: 1;
}

.brand-name {
  color: white;
  font-size: 18px;
  font-weight: 900;
  letter-spacing: 2px;
}

.brand-subtitle {
  color: rgba(255, 255, 255, 0.7);
  font-size: 11px;
  font-weight: 600;
  letter-spacing: 3px;
}

.nav-link {
  color: #6b5b47 !important;
  font-weight: 600;
  letter-spacing: 0.08em;
  margin: 0 4px;
  border-radius: 999px !important;
  padding-inline: 1rem !important;
}

.nav-link:hover {
  background: rgba(184, 151, 120, 0.12) !important;
}

.nav-cart,
.mobile-nav-toggle {
  color: #6b5b47 !important;
}

/* Footer */
.footer {
  color: #6b5b47;
  background:
    radial-gradient(circle at top left, rgba(217, 200, 181, 0.4), transparent 30%),
    linear-gradient(180deg, #f5f1ec 0%, #ebe4dc 100%) !important;
  border-top: 1px solid rgba(184, 151, 120, 0.18);
}

.footer-brand {
  display: flex;
  align-items: center;
}

.footer-brand-block {
  display: flex;
  align-items: center;
  gap: 14px;
}

.brand-icon-footer {
  font-size: 40px;
}

.footer-brand-text {
  display: flex;
  flex-direction: column;
  line-height: 1.2;
}

.footer-brand-name {
  font-size: 20px;
  font-weight: 900;
  letter-spacing: 2px;
  color: #6b5b47;
}

.footer-brand-subtitle {
  font-size: 12px;
  font-weight: 600;
  letter-spacing: 3px;
  color: #9a866f;
}

.footer-desc {
  font-size: 14px;
  line-height: 1.6;
  max-width: 300px;
  color: #8b7762;
}

.footer-title {
  color: #6b5b47;
  font-size: 16px;
  font-weight: 700;
  letter-spacing: 0.12em;
  text-transform: uppercase;
}

.footer-links {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.footer-link {
  color: #8b7762;
  text-decoration: none;
  font-size: 14px;
  transition: color 0.3s ease;
}

.footer-link:hover {
  color: #6b5b47;
}

.footer-contact {
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.contact-item {
  display: flex;
  align-items: center;
  gap: 12px;
  color: #8b7762;
  font-size: 14px;
}

.social-links {
  display: flex;
  gap: 8px;
}

.footer-social {
  color: #8c745f !important;
  background: rgba(255, 255, 255, 0.6) !important;
}

.footer-social:hover {
  background: rgba(184, 151, 120, 0.16) !important;
}

.contact-icon {
  color: #8c745f !important;
}

.footer-divider {
  border-color: rgba(140, 116, 95, 0.16) !important;
}

.footer-copy {
  color: #9a866f;
}
</style>
