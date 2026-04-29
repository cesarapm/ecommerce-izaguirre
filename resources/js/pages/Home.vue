<template>
  <div class="izaguirre-qu-home">
    <!-- Hero Section -->
    <v-container fluid class="hero-section pa-0">
      <div class="hero-backdrop" :style="heroBackdropStyle"></div>
      <div class="hero-overlay"></div>
      
      <v-row no-gutters align="center" justify="center" class="fill-height hero-content hero-grid">
        <v-col cols="12" md="10" lg="8" class="text-center py-16 px-4">
          <div class="hero-copy-shell">
          <!-- Logo emblemático -->
          <div class="brand-emblem mb-8" data-aos="fade-down">
            <div class="elegant-pattern"></div>
            <h1 class="brand-name">IzaguirreQu</h1>
            <div class="brand-line"></div>
          </div>

          <!-- Mensaje principal -->
          <div class="hero-message mb-10" data-aos="fade-up" data-aos-delay="300">
            <h2 class="elegant-title mb-6">
              Joyería Artesanal<br>
              <span class="accent-whisper">con alma mexicana</span>
            </h2>
            <p class="essence-text">
              Diseños únicos que celebran la tradición mexicana<br>
              con técnicas contemporáneas y materiales de primera calidad.
            </p>
          </div>

          <!-- CTA Principal -->
          <div class="hero-actions" data-aos="zoom-in" data-aos-delay="600">
            <v-btn
              class="discover-btn px-12 py-3"
              @click="scrollToCollection"
              elevation="0"
            >
              <span>Ver Colección</span>
              <div class="btn-glow"></div>
            </v-btn>
            <div class="whisper-text mt-4">
              <small>"Cada símbolo guarda un secreto... algunos querrán hablarte"</small>
            </div>
          </div>
          </div>
        </v-col>
      </v-row>
    </v-container>

    <!-- Productos Destacados Section -->
    <v-container class="featured-section py-20">
      <v-row justify="center">
        <v-col cols="12" md="10" class="text-center">
          <h3 class="section-title mb-12" data-aos="fade-up">
            Productos Destacados
          </h3>
          
          <div class="products-grid">
            <div 
              v-if="featuredLoading"
              class="product-card product-card--status"
            >
              <div class="product-info">
                <h4 class="product-name">Cargando destacados...</h4>
                <p class="product-description">Obteniendo productos desde el catálogo.</p>
              </div>
            </div>
            <div 
              v-else-if="featuredProducts.length === 0"
              class="product-card product-card--status"
            >
              <div class="product-info">
                <h4 class="product-name">Aún no hay productos destacados</h4>
                <p class="product-description">Marca productos como destacados en Laravel para mostrarlos aquí.</p>
              </div>
            </div>
            <template v-else>
              <div 
                v-for="product in featuredProducts" 
                :key="product.id" 
                class="product-card" 
                data-aos="fade-up" 
                :data-aos-delay="product.id * 100"
              >
                <div class="product-image">
                  <img
                    v-if="product.image"
                    :src="product.image"
                    :alt="product.name"
                    class="product-photo"
                  >
                  <div v-else class="placeholder-product" :class="`product-${product.id}`">
                    {{ product.name.charAt(0) }}
                  </div>
                  <div class="product-overlay">
                    <v-btn 
                      class="view-btn" 
                      variant="outlined" 
                      @click="viewProduct(product.id)"
                    >
                      Ver Detalles
                    </v-btn>
                  </div>
                </div>
                <div class="product-info">
                  <h4 class="product-name">{{ product.name }}</h4>
                  <p class="product-description">{{ product.description }}</p>
                  <div class="product-price">
                    <span class="price">${{ product.price }}</span>
                    <span class="currency">MXN</span>
                  </div>
                  <p v-if="product.stock === 0" class="product-stock">
                    Agotado
                  </p>
                </div>
              </div>
            </template>
          </div>
        </v-col>
      </v-row>
    </v-container>

    <!-- Valores Breves Section -->
    <v-container class="values-brief py-20">
      <v-row justify="center">
        <v-col cols="12" md="10">
          <div class="values-grid">
            <div class="value-card" data-aos="fade-up">
              <div class="value-icon">✨</div>
              <h4>Artesanal</h4>
              <p>Cada pieza es única, hecha a mano con técnicas tradicionales mexicanas.</p>
            </div>
            
            <div class="value-card" data-aos="fade-up" data-aos-delay="200">
              <div class="value-icon">🌿</div>
              <h4>Sostenible</h4>
              <p>Materiales responsables y procesos que respetan el medio ambiente.</p>
            </div>
            
            <div class="value-card" data-aos="fade-up" data-aos-delay="400">
              <div class="value-icon">💎</div>
              <h4>Calidad</h4>
              <p>Metales nobles y gemas seleccionadas para crear piezas duraderas.</p>
            </div>
          </div>
        </v-col>
      </v-row>
    </v-container>

    <!-- Collections Preview -->
    <v-container fluid class="collections-preview py-20" id="collections">
      <v-container>
        <v-row justify="center">
          <v-col cols="12" class="text-center mb-12">
            <h3 class="section-title" data-aos="fade-up">
              Nuestras Colecciones
            </h3>
            <p class="section-subtitle" data-aos="fade-up" data-aos-delay="200">
              Donde el alma se encuentra con la forma
            </p>
          </v-col>
        </v-row>
        
        <v-row>
          <v-col v-for="collection in collections" :key="collection.id" cols="12" md="4" class="mb-8">
            <div class="collection-card" data-aos="fade-up" :data-aos-delay="collection.id * 100">
              <div class="collection-image">
                <div class="collection-artwork" :class="collection.slug">
                  <span class="collection-kicker">{{ collection.kicker }}</span>
                  <div class="collection-mark">{{ collection.mark }}</div>
                  <span class="collection-motif">{{ collection.motif }}</span>
                </div>
                <div class="collection-overlay">
                  <v-btn class="explore-btn" variant="outlined" @click="exploreCollection(collection.slug)">
                    Explorar
                  </v-btn>
                </div>
              </div>
              <div class="collection-info">
                <h4 class="collection-name">{{ collection.name }}</h4>
                <p class="collection-description">{{ collection.description }}</p>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </v-container>

    <!-- Call to Action -->
    <v-container class="final-cta">
      <v-row justify="center">
        <v-col cols="12" md="12" class="text-center ">
          <div class="cta-content " data-aos="fade-up">
            <h3 class="cta-title mb-6">
              ¿Sientes la llamada?
            </h3>
            <p class="cta-text mb-8">
              Cada joya espera encontrar a su portador. Descubre cuál está destinada para ti 
              y comienza tu viaje hacia una conexión más profunda contigo mismo.
            </p>
            <v-btn 
              class="cta-button px-12 py-3"
              @click="$router.push('/productos')"
              elevation="0"
            >
              Encontrar Mi Joya
            </v-btn>
          </div>
        </v-col>
      </v-row>
    </v-container>
  </div>
</template>

<script setup>
import { ref, onMounted, nextTick } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const heroCoverImage = '/images/home/portada.webp'
const heroBackdropStyle = {
  backgroundImage: `linear-gradient(135deg, rgba(38, 27, 19, 0.56), rgba(78, 53, 36, 0.38)), url(${heroCoverImage})`
}

// Collections data
const collections = ref([
  {
    id: 1,
    name: 'Ancestral',
    description: 'Símbolos prehispánicos en diseños contemporáneos',
    slug: 'ancestral',
    kicker: 'Origen sagrado',
    mark: '⟡',
    motif: 'Códices, memoria y fuerza'
  },
  {
    id: 2,
    name: 'Contemporáneo', 
    description: 'Diseños modernos con alma mexicana',
    slug: 'contemporaneo',
    kicker: 'Presencia actual',
    mark: '◌',
    motif: 'Líneas puras, pulso urbano'
  },
  {
    id: 3,
    name: 'Artesanal',
    description: 'Piezas únicas hechas completamente a mano',
    slug: 'artesanal',
    kicker: 'Hecho a mano',
    mark: '✦',
    motif: 'Textura, oficio y detalle'
  }
])

const featuredProducts = ref([])
const featuredLoading = ref(false)

const scrollToCollection = () => {
  document.getElementById('collections').scrollIntoView({
    behavior: 'smooth'
  })
}

const exploreCollection = (slug) => {
  router.push(`/productos?collection=${slug}`)
}

const viewProduct = (id) => {
  router.push(`/producto/${id}`)
}

const initAos = () => {
  if (typeof AOS !== 'undefined') {
    AOS.init({
      duration: 1000,
      easing: 'ease-in-out-cubic',
      once: true,
      offset: 100
    })
  }
}

const refreshAos = async () => {
  await nextTick()

  if (typeof AOS !== 'undefined') {
    AOS.refresh()
  }
}

const fetchFeaturedProducts = async () => {
  featuredLoading.value = true

  try {
    const response = await fetch('/api/products/featured')

    if (!response.ok) {
      throw new Error('No se pudieron cargar los productos destacados')
    }

    featuredProducts.value = await response.json()
    await refreshAos()
  } catch (error) {
    console.error('Error al cargar productos destacados:', error)
    featuredProducts.value = []
  } finally {
    featuredLoading.value = false
  }
}

onMounted(() => {
  initAos()
  fetchFeaturedProducts()
})
</script>

<style scoped>
.izaguirre-qu-home {
  background: linear-gradient(135deg, #faf9f7 0%, #f5f3f0 100%);
  color: #2c2c2c;
  overflow-x: hidden;
}

/* Hero Section */
.hero-section {
  margin-top: 70px;
  min-height: 100vh;
  position: relative;
  display: flex;
  align-items: center;
}

.hero-backdrop {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #d7c5b3;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;
  transform: scale(1.03);
}

.hero-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: 
    radial-gradient(circle at 20% 50%, rgba(255, 223, 187, 0.18) 0%, transparent 38%),
    radial-gradient(circle at 80% 20%, rgba(255, 243, 228, 0.14) 0%, transparent 34%),
    linear-gradient(180deg, rgba(29, 20, 14, 0.18) 0%, rgba(29, 20, 14, 0.42) 100%);
}

.hero-content {
  position: relative;
  z-index: 2;
}

.hero-grid {
  width: min(1200px, calc(100% - 2rem));
  margin: 0 auto;
}

.hero-copy-shell {
  max-width: 760px;
  margin: 0 auto;
  padding: clamp(2rem, 4vw, 3rem);
  border-radius: 32px;
  background: linear-gradient(180deg, rgba(255, 250, 244, 0.2), rgba(255, 250, 244, 0.08));
  border: 1px solid rgba(255, 245, 234, 0.26);
  box-shadow: 0 24px 60px rgba(26, 17, 11, 0.22);
  backdrop-filter: blur(10px);
}

.brand-emblem {
  position: relative;
}

.elegant-pattern {
  width: 100px;
  height: 2px;
  background: linear-gradient(90deg, transparent, #b8977866, #8c745f, #b89778, transparent);
  margin: 0 auto 24px;
  position: relative;
  border-radius: 1px;
}

.elegant-pattern::before,
.elegant-pattern::after {
  content: '';
  position: absolute;
  top: -4px;
  width: 6px;
  height: 6px;
  background: #8c745f;
  border-radius: 50%;
}

.elegant-pattern::before { left: -3px; }
.elegant-pattern::after { right: -3px; }

.brand-name {
  font-family: var(--font-brand), serif;
  font-size: clamp(3rem, 8vw, 5rem);
  font-weight: 500;
  color: #fff7ef;
  text-shadow: none;
  letter-spacing: 0.05em;
  margin: 0;
  position: relative;
}

.brand-line {
  width: 80px;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255, 239, 221, 0.9), transparent);
  margin: 24px auto 0;
}

.elegant-title {
  font-family: var(--font-brand), serif;
  font-size: clamp(1.8rem, 4vw, 2.8rem);
  font-weight: 300;
  line-height: 1.4;
  color: #fffaf4;
  letter-spacing: -0.02em;
}

.accent-whisper {
  color: #f3d6b6;
  font-style: italic;
  font-weight: 400;
}

.essence-text {
  font-family: var(--font-brand), serif;
  font-size: 1.2rem;
  line-height: 1.7;
  color: rgba(255, 248, 240, 0.9);
  max-width: 700px;
  margin: 0 auto;
  font-weight: 300;
}

.discover-btn {
  background: linear-gradient(135deg, #8c745f, #a68b73) !important;
  color: #ffffff !important;
  font-family: var(--font-brand), serif;
  font-weight: 500;
  font-size: 1rem;
  letter-spacing: 0.02em;
  position: relative;
  overflow: hidden;
  border-radius: 32px !important;
  transition: all 0.3s ease;
  box-shadow: 0 4px 20px rgba(140, 116, 95, 0.25);
}

.discover-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 30px rgba(140, 116, 95, 0.35);
  background: linear-gradient(135deg, #a68b73, #8c745f) !important;
}

.btn-glow {
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s ease;
}

.discover-btn:hover .btn-glow {
  left: 100%;
}

.whisper-text {
  color: rgba(255, 241, 228, 0.76);
  font-family: var(--font-brand), serif;
  font-style: italic;
  font-size: 0.9rem;
  font-weight: 300;
}

/* Featured Products & Values Sections */
.featured-section, .values-brief {
  background: #fbfaf9;
  position: relative;
}

.values-brief {
  background: linear-gradient(135deg, #f7f5f3, #f2efec);
}

.section-title {
  font-family: var(--font-brand), serif;
  font-size: clamp(2rem, 5vw, 3rem);
  font-weight: 500;
  color: #6b5b47;
  text-align: center;
  position: relative;
  margin-bottom: 2rem;
}

.section-title::after {
  content: '';
  position: absolute;
  bottom: -12px;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 1px;
  background: linear-gradient(90deg, transparent, #8c745f, transparent);
}

.products-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
}

.product-card {
  background: #ffffff;
  border: 1px solid rgba(140, 116, 95, 0.1);
  border-radius: 16px;
  transition: all 0.3s ease;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(140, 116, 95, 0.08);
}

.product-card:hover {
  transform: translateY(-8px);
  box-shadow: 0 12px 40px rgba(140, 116, 95, 0.15);
  border-color: rgba(140, 116, 95, 0.2);
}

.product-image {
  position: relative;
  height: 360px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1.25rem;
  background: linear-gradient(180deg, #f7f2ed 0%, #efe6dd 100%);
}

.product-photo {
  width: min(100%, 240px);
  height: 100%;
  max-height: 100%;
  object-fit: contain;
  display: block;
  border-radius: 18px;
  box-shadow: 0 18px 36px rgba(107, 91, 71, 0.16);
  background: #f9f5f1;
}

.placeholder-product {
  width: min(100%, 240px);
  height: 100%;
  max-height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-family: var(--font-brand), serif;
  font-size: 4rem;
  font-weight: 500;
  transition: transform 0.3s ease;
  border-radius: 18px;
  box-shadow: 0 18px 36px rgba(107, 91, 71, 0.14);
}

.product-1 { background: linear-gradient(135deg, #d4c4b0, #b8977866); }
.product-2 { background: linear-gradient(135deg, #c9b299, #a68b73); }
.product-3 { background: linear-gradient(135deg, #b89778, #8c745f); }
.product-4 { background: linear-gradient(135deg, #a68b73, #6b5b47); }

.product-overlay {
  position: absolute;
  inset: 1.25rem;
  background: rgba(107, 91, 71, 0.52);
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
  border-radius: 18px;
  backdrop-filter: blur(4px);
}

.product-card:hover .product-overlay {
  opacity: 1;
}

.view-btn {
  border-color: #ffffff !important;
  color: #ffffff !important;
  font-family: var(--font-brand), serif;
  font-weight: 500;
  background: rgba(255, 255, 255, 0.1) !important;
  backdrop-filter: blur(10px);
  border-radius: 24px !important;
}

.view-btn:hover {
  background: #ffffff !important;
  color: #6b5b47 !important;
}

.product-info {
  padding: 1.5rem;
  text-align: center;
}

.product-card--status {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 220px;
}

.product-name {
  font-family: var(--font-brand), serif;
  font-size: 1.4rem;
  font-weight: 500;
  color: #6b5b47;
  margin-bottom: 0.5rem;
}

.product-description {
  font-family: var(--font-brand), serif;
  font-size: 0.95rem;
  line-height: 1.5;
  color: #888;
  margin-bottom: 1rem;
  font-weight: 300;
}

.product-price {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
}

.price {
  font-family: var(--font-brand), serif;
  font-size: 1.2rem;
  font-weight: 600;
  color: #8c745f;
}

.currency {
  font-size: 0.9rem;
  color: #999;
  font-weight: 400;
}

.product-stock {
  margin-top: 0.75rem;
  color: #a94442;
  font-size: 0.9rem;
  font-weight: 500;
}

/* Values Brief Section */
.values-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
}

.value-card {
  text-align: center;
  padding: 2rem 1.5rem;
  background: #ffffff;
  border: 1px solid rgba(140, 116, 95, 0.1);
  border-radius: 16px;
  transition: all 0.3s ease;
  box-shadow: 0 4px 15px rgba(140, 116, 95, 0.08);
}

.value-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 30px rgba(140, 116, 95, 0.15);
  border-color: rgba(140, 116, 95, 0.2);
}

.value-icon {
  font-size: 2.5rem;
  margin-bottom: 1rem;
  filter: grayscale(0.2);
}

.value-card h4 {
  font-family: var(--font-brand), serif;
  font-size: 1.3rem;
  font-weight: 500;
  color: #6b5b47;
  margin-bottom: 0.75rem;
}

.value-card p {
  font-family: var(--font-brand), serif;
  font-size: 0.95rem;
  line-height: 1.6;
  color: #666;
  font-weight: 300;
}

/* Collections Section */
.collections-section {
  background: linear-gradient(135deg, #faf9f7, #f7f5f3);
  position: relative;
}

.collections-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 2rem;
  margin-top: 3rem;
}

.collection-card {
  background: #ffffff;
  border: 1px solid rgba(140, 116, 95, 0.1);
  border-radius: 20px;
  overflow: hidden;
  transition: all 0.4s ease;
  position: relative;
  box-shadow: 0 6px 25px rgba(140, 116, 95, 0.08);
}

.collection-card:hover {
  transform: translateY(-12px);
  box-shadow: 0 20px 50px rgba(140, 116, 95, 0.2);
  border-color: rgba(140, 116, 95, 0.25);
}

.collection-image {
  height: 300px;
  position: relative;
  overflow: hidden;
}

.collection-placeholder {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #ffffff;
  font-family: var(--font-brand), serif;
  font-size: 3rem;
  font-weight: 500;
  transition: transform 0.4s ease;
}

.collection-1 { background: linear-gradient(135deg, #d4c4b0, #b89778); }
.collection-2 { background: linear-gradient(135deg, #c9b299, #a68b73); }
.collection-3 { background: linear-gradient(135deg, #b89778, #8c745f); }

.collection-card:hover .collection-placeholder {
  transform: scale(1.05);
}

.collection-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(45deg, rgba(107, 91, 71, 0.2), rgba(140, 116, 95, 0.1));
  opacity: 0;
  transition: opacity 0.3s ease;
}

.collection-card:hover .collection-overlay {
  opacity: 1;
}

.collection-content {
  padding: 2rem;
  text-align: center;
}

.collection-name {
  font-family: var(--font-brand), serif;
  font-size: 1.8rem;
  font-weight: 500;
  color: #6b5b47;
  margin-bottom: 1rem;
}

.collection-description {
  font-family: var(--font-brand), serif;
  font-size: 1rem;
  line-height: 1.6;
  color: #666;
  margin-bottom: 1.5rem;
  font-weight: 300;
}

.explore-btn {
  background: transparent !important;
  border: 1px solid #8c745f !important;
  color: #8c745f !important;
  font-family: var(--font-brand), serif;
  font-weight: 500;
  font-size: 0.95rem;
  border-radius: 24px !important;
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.explore-btn:hover {
  background: #8c745f !important;
  color: #ffffff !important;
  transform: translateY(-1px);
}

.explore-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s ease;
}

.explore-btn:hover::before {
  left: 100%;
}

/* Founders Section */
.founders-section {
  background: linear-gradient(135deg, #0f0f0f, #1a1a1a);
  position: relative;
}

.founder-card {
  text-align: center;
}

.founder-image {
  position: relative;
  width: 300px;
  height: 300px;
  margin: 0 auto 2rem;
  border-radius: 50%;
  overflow: hidden;
  border: 3px solid rgba(212, 175, 55, 0.3);
  transition: all 0.4s ease;
}

.founder-image:hover {
  border-color: rgba(212, 175, 55, 0.8);
  transform: scale(1.05);
}

.founder-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.placeholder-image {
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #d4af37, #b8860b);
  color: #1a1a1a;
  font-family: var(--font-brand), serif;
  font-size: 4rem;
  font-weight: 700;
  letter-spacing: 0.1em;
}

.image-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(212, 175, 55, 0.1), rgba(184, 134, 11, 0.1));
  opacity: 0;
  transition: opacity 0.3s ease;
}

.founder-image:hover .image-overlay {
  opacity: 1;
}

.founder-name {
  font-family: var(--font-brand), serif;
  font-size: 2rem;
  font-weight: 600;
  color: #d4af37;
  margin-bottom: 0.5rem;
}

.founder-role {
  font-family: var(--font-brand), serif;
  font-size: 1.2rem;
  color: #999;
  margin-bottom: 1.5rem;
  font-style: italic;
}

.founder-description {
  font-family: var(--font-brand), serif;
  font-size: 1.1rem;
  line-height: 1.7;
  color: #cccccc;
  max-width: 400px;
  margin: 0 auto;
  font-style: italic;
}

.mystical-symbol {
  font-size: 4rem;
  color: #d4af37;
  text-shadow: 0 0 30px rgba(212, 175, 55, 0.5);
  animation: pulse 3s ease-in-out infinite;
}

/* MVV Section */
.mvv-section {
  background: linear-gradient(135deg, #1a1a1a, #0f0f0f);
}

.mvv-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
  gap: 3rem;
  margin-top: 3rem;
}

.mvv-card {
  padding: 3rem 2rem;
  background: rgba(212, 175, 55, 0.05);
  border-left: 4px solid #d4af37;
  transition: all 0.4s ease;
  position: relative;
}

.mvv-card:hover {
  transform: translateX(10px);
  background: rgba(212, 175, 55, 0.1);
}

.mvv-icon {
  font-size: 3rem;
  margin-bottom: 1.5rem;
}

.mvv-card h4 {
  font-family: var(--font-brand), serif;
  font-size: 2rem;
  font-weight: 600;
  color: #d4af37;
  margin-bottom: 1.5rem;
}

.mvv-card p, .mvv-card ul {
  font-family: var(--font-brand), serif;
  font-size: 1.1rem;
  line-height: 1.7;
  color: #cccccc;
}

.mvv-card ul {
  list-style: none;
  padding: 0;
}

.mvv-card li {
  margin-bottom: 1rem;
  padding-left: 1rem;
  position: relative;
}

.mvv-card li::before {
  content: '◆';
  position: absolute;
  left: -0.5rem;
  color: #d4af37;
  font-size: 0.8rem;
  top: 0.1rem;
}

/* Collections Preview */
.collections-preview {
  background:
    radial-gradient(circle at top left, rgba(217, 200, 181, 0.3), transparent 26%),
    linear-gradient(180deg, #faf7f4 0%, #f1ebe4 100%);
}

.section-subtitle {
  font-family: var(--font-brand), serif;
  font-size: 1.3rem;
  color: #8f7a65;
  font-style: italic;
  margin-top: 1rem;
}

.collection-card {
  background: rgba(255, 252, 248, 0.92);
  border: 1px solid rgba(184, 151, 120, 0.16);
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
  overflow: hidden;
  height: 100%;
  box-shadow: 0 14px 36px rgba(140, 116, 95, 0.08);
}

.collection-card:hover {
  transform: translateY(-10px);
  border-color: rgba(184, 151, 120, 0.28);
  background: rgba(255, 252, 248, 0.98);
  box-shadow: 0 22px 46px rgba(140, 116, 95, 0.14);
}

.collection-image {
  position: relative;
  height: 300px;
  overflow: hidden;
}

.collection-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.collection-artwork {
  width: 100%;
  height: 100%;
  position: relative;
  display: flex;
  flex-direction: column;
  align-items: flex-start;
  justify-content: space-between;
  padding: 1.5rem;
  color: #fffaf4;
  font-family: var(--font-brand), serif;
  isolation: isolate;
  transition: transform 0.5s ease, filter 0.5s ease;
}

.collection-artwork::before,
.collection-artwork::after {
  content: '';
  position: absolute;
  border-radius: 999px;
  pointer-events: none;
  z-index: 0;
}

.collection-artwork::before {
  width: 15rem;
  height: 15rem;
  top: -4.5rem;
  right: -3rem;
  background: radial-gradient(circle, rgba(255, 248, 240, 0.5) 0%, rgba(255, 248, 240, 0) 72%);
}

.collection-artwork::after {
  width: 10rem;
  height: 10rem;
  bottom: -3.5rem;
  left: -2rem;
  border: 1px solid rgba(255, 248, 240, 0.28);
  opacity: 0.8;
}

.collection-artwork.ancestral {
  background:
    linear-gradient(150deg, rgba(255, 248, 238, 0.18), rgba(255, 248, 238, 0) 45%),
    linear-gradient(135deg, #ccb39a 0%, #b78e69 52%, #8b664b 100%);
}

.collection-artwork.contemporaneo {
  background:
    linear-gradient(150deg, rgba(255, 249, 243, 0.18), rgba(255, 249, 243, 0) 45%),
    linear-gradient(135deg, #d8c7ba 0%, #b9967d 45%, #8b6f62 100%);
}

.collection-artwork.artesanal {
  background:
    linear-gradient(150deg, rgba(255, 251, 246, 0.18), rgba(255, 251, 246, 0) 45%),
    linear-gradient(135deg, #d9c1a8 0%, #bd9874 50%, #927057 100%);
}

.collection-kicker,
.collection-mark,
.collection-motif {
  position: relative;
  z-index: 1;
}

.collection-kicker {
  display: inline-flex;
  align-items: center;
  gap: 0.45rem;
  padding: 0.45rem 0.8rem;
  border-radius: 999px;
  background: rgba(255, 248, 240, 0.16);
  border: 1px solid rgba(255, 248, 240, 0.22);
  color: rgba(255, 250, 244, 0.92);
  font-size: 0.88rem;
  letter-spacing: 0.08em;
  text-transform: uppercase;
}

.collection-mark {
  align-self: center;
  font-size: clamp(4.6rem, 9vw, 6.4rem);
  font-weight: 400;
  line-height: 1;
  text-shadow: 0 16px 28px rgba(88, 62, 39, 0.14);
}

.collection-motif {
  max-width: 12rem;
  font-size: 1rem;
  line-height: 1.45;
  color: rgba(255, 250, 244, 0.86);
}

.collection-card:hover .collection-image .collection-artwork {
  transform: scale(1.06);
  filter: saturate(1.05);
}

.collection-overlay {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: linear-gradient(135deg, rgba(107, 91, 71, 0.48), rgba(184, 151, 120, 0.2));
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.collection-card:hover .collection-overlay {
  opacity: 1;
}

.explore-btn {
  border-color: #f7f1eb !important;
  color: #fffaf4 !important;
  font-family: var(--font-brand), serif;
  font-weight: 600;
  letter-spacing: 0.05em;
  background: rgba(255, 255, 255, 0.12) !important;
  backdrop-filter: blur(10px);
  border-radius: 999px !important;
}

.explore-btn:hover {
  background: #fffaf4 !important;
  color: #6b5b47 !important;
}

.collection-info {
  padding: 2rem;
  text-align: center;
}

.collection-name {
  font-family: var(--font-brand), serif;
  font-size: 1.6rem;
  font-weight: 600;
  color: #6b5b47;
  margin-bottom: 1rem;
}

.collection-description {
  font-family: var(--font-brand), serif;
  font-size: 1.1rem;
  line-height: 1.6;
  color: #7f6d5a;
}

/* Final CTA */
.final-cta {
  background:
  radial-gradient(circle at top right,
  rgba(217, 200, 181, 0.35),
  transparent 70%
)
    linear-gradient(135deg, #f9f7f4 0%, #f2efec 100%);

  position: relative;
  padding-block: clamp(3.5rem, 8vw, 6rem);
  
}

.cta-content {
  padding: clamp(2rem, 4vw, 3rem) clamp(1.5rem, 4vw, 2.5rem);
  background: rgba(255, 252, 248, 0.88);
  border: 1px solid rgba(184, 151, 120, 0.18);
  border-radius: 30px;
  box-shadow: 0 18px 42px rgba(140, 116, 95, 0.1);
  text-align: center;
  max-width: 760px;
  margin: 0 auto;
}

.cta-title {
  font-family: var(--font-brand), serif;
  font-size: clamp(2rem, 5vw, 3rem);
  font-weight: 600;
  color: #6b5b47;
}

.cta-text {
  font-family: var(--font-brand), serif;
  font-size: 1.08rem;
  line-height: 1.65;
  color: #7f6d5a;
  max-width: 560px;
  margin: 0 auto;
}

.cta-button {
  background: linear-gradient(135deg, #8c745f, #a68b73) !important;
  color: #fffaf4 !important;
  font-family: var(--font-brand), serif;
  font-weight: 600;
  font-size: 1.2rem;
  letter-spacing: 0.05em;
  border-radius: 999px !important;
  transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.cta-button:hover {
  transform: translateY(-3px);
  box-shadow: 0 20px 40px rgba(140, 116, 95, 0.25);
}

/* Animations */
@keyframes gradientShift {
  0%, 100% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
}

@keyframes pulse {
  0%, 100% { 
    transform: scale(1); 
    text-shadow: 0 0 30px rgba(212, 175, 55, 0.5);
  }
  50% { 
    transform: scale(1.05); 
    text-shadow: 0 0 50px rgba(212, 175, 55, 0.8);
  }
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-grid {
    width: calc(100% - 1.5rem);
  }

  .hero-copy-shell {
    padding: 1.5rem;
    border-radius: 24px;
  }

  .product-image {
    height: 320px;
  }

  .essence-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  .mvv-grid {
    grid-template-columns: 1fr;
    gap: 2rem;
  }
  
  .founder-image {
    width: 250px;
    height: 250px;
  }
  
  .collection-image {
    height: 250px;
  }
  
  .essence-card, .mvv-card {
    padding: 1.5rem;
  }
  
  .cta-content {
    padding: 2rem 1rem;
  }
}

@media (max-width: 480px) {
  .hero-copy-shell {
    padding: 1.25rem;
  }

  .product-image {
    height: 300px;
    padding: 1rem;
  }

  .product-photo,
  .placeholder-product,
  .product-overlay {
    width: min(100%, 210px);
  }

  .hero-content .py-16 {
    padding-top: 4rem !important;
    padding-bottom: 4rem !important;
  }
  
  .brand-name {
    font-size: 3rem;
  }
  
  .mystical-title {
    font-size: 2rem;
  }
  
  .essence-text {
    font-size: 1.1rem;
  }
  
  .section-title {
    font-size: 2.5rem;
  }
  
  .founder-image {
    width: 200px;
    height: 200px;
  }
}
</style>