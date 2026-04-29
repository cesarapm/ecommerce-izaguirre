<template>
  <div class="about-page">
    <section class="about-hero">
      <v-container class="py-16">
        <v-row justify="center">
          <v-col cols="12" lg="10" class="text-center">
            <div class="hero-emblem">Nuestra Esencia</div>
            <h1 class="hero-title">IzaguirreQu</h1>
            <p class="hero-text">
              Nace de una energia femenina, introspectiva y magnetica. No solo creamos joyeria;
              damos vida a piezas que despiertan curiosidad y deseo sin mostrarlo todo.
            </p>
            <p class="hero-quote">
              "No todas las joyas se usan... algunas te despiertan"
            </p>
          </v-col>
        </v-row>
      </v-container>
    </section>

    <section class="story-section">
      <v-container class="py-14">
        <v-row justify="center">
          <v-col cols="12" lg="10">
            <div class="section-heading text-center mb-10">
              <span class="section-kicker">Quienes Somos</span>
              <h2>Arte, alma y origen</h2>
            </div>
            <div class="story-grid">
              <article class="story-card story-card--wide">
                <p>
                  Creemos que el misterio no esta en lo que ves, sino en lo que sientes al portarlo.
                  Somos el punto de encuentro entre el arte y el alma, donde todo se alinea para
                  crear joyas artesanales que cuentan una historia y honran un origen.
                </p>
                <p>
                  Cada simbolo guarda un secreto... y pronto, algunos de ellos querran hablarte.
                  Nuestras piezas son fragmentos de Mexico tejidos con el alma de sus artistas,
                  disenadas para la mujer que busca conectar con fuerzas ancestrales.
                </p>
              </article>
              <article class="story-card">
                <h3>Nuestra Promesa</h3>
                <p>
                  No vendemos piezas, despertamos conexiones. Lleva contigo un pedacito de Mexico,
                  lleva contigo tu propia historia y permite que te encuentre.
                </p>
              </article>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </section>

    <section class="founders-section">
      <v-container class="py-14">
        <v-row justify="center">
          <v-col cols="12" lg="10">
            <div class="section-heading text-center mb-10">
              <span class="section-kicker">Quienes compartimos este sueno</span>
              <h2>Mujeres que sostienen la vision</h2>
            </div>
            <div class="founders-grid">
              <article class="founder-card">
                <div class="founder-media founder-media--romero">
                  <img
                    :src="'/images/about/elizabeth-quintana-romero.webp'"
                    alt="Elizabeth Quintana Romero"
                    class="founder-photo"
                  >
                  <div class="founder-photo-badge">EQR</div>
                </div>
                <span class="founder-tag">Innovacion con Raices</span>
                <h3>Elizabeth Quintana Romero</h3>
                <p>
                  Orgullosamente mexicana por herencia y conviccion, su historia mezcla rigor
                  cientifico y pasion artesanal. Como Doctora en Ciencia y Tecnologia de Alimentos,
                  ha dedicado su vida a la innovacion y el diseno, sin soltar la fascinacion por la
                  joyeria que nacio desde la infancia al mirar el espiritu emprendedor de su madre.
                </p>
                <p>
                  De la mano de maestros orfebres mexicanos, fusiona la tradicion ancestral con una
                  vision contemporanea. En IzaguirreQu disena momentos memorables a traves del detalle
                  y proyecta el legado joyero de Mexico al escenario global.
                </p>
              </article>

              <article class="founder-card">
                <div class="founder-media founder-media--izaguirre">
                  <img
                    :src="'/images/about/elizabeth-izaguirre-quintana.webp'"
                    alt="Elizabeth Izaguirre Quintana"
                    class="founder-photo"
                  >
                  <div class="founder-photo-badge">EIQ</div>
                </div>
                <span class="founder-tag">Raices que trascienden fronteras</span>
                <h3>Elizabeth Izaguirre Quintana</h3>
                <p>
                  Psicologa y estratega de innovacion en talento humano, es el puente entre sus
                  raices mexicanas y su recorrido por el mundo. Madre de espiritu solidario, ha hecho
                  de la adaptacion una forma de arte, ayudando a otros a florecer en nuevas tierras.
                </p>
                <p>
                  A traves de IzaguirreQu honra el legado de la orfebreria mexicana y lleva la riqueza
                  cultural de su tierra a distintos rincones del mundo. Su esencia cercana y autentica
                  refleja lo que quienes la conocen describen con claridad: Eli es puro corazon.
                </p>
              </article>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </section>

    <section class="purpose-section">
      <v-container class="py-14">
        <v-row justify="center">
          <v-col cols="12" lg="10">
            <div class="section-heading text-center mb-10">
              <span class="section-kicker">Mision, Vision y Valores</span>
              <h2>Lo que guia cada pieza</h2>
            </div>

            <div class="purpose-grid mb-8">
              <article class="purpose-card">
                <h3>Mision</h3>
                <p>
                  Despertar conexiones profundas entre el arte y el alma a traves de joyeria
                  artesanal mexicana que trasciende fronteras, fusionando innovacion con la riqueza
                  de nuestra herencia para crear piezas que cuentan historias y honran su origen.
                </p>
              </article>

              <article class="purpose-card">
                <h3>Vision</h3>
                <p>
                  Ser el portal referente a nivel global donde la tradicion orfebre de Mexico se
                  encuentra con la mujer contemporanea, proyectando nuestro legado cultural como un
                  simbolo de misterio, elegancia y fuerza ancestral.
                </p>
              </article>
            </div>

            <div class="values-card">
              <h3>Valores</h3>
              <div class="values-grid">
                <div class="value-item">
                  <strong>Raices Vivas</strong>
                  <p>Honramos el legado de los maestros orfebres y la riqueza cultural de Mexico.</p>
                </div>
                <div class="value-item">
                  <strong>Misticismo y Deseo</strong>
                  <p>Creemos en el poder de lo que no se ve y en la energia femenina que acompana cada pieza.</p>
                </div>
                <div class="value-item">
                  <strong>Innovacion Consciente</strong>
                  <p>Unimos ciencia, estrategia y pasion artesanal para crear disenos con memoria.</p>
                </div>
                <div class="value-item">
                  <strong>Espiritu Solidario</strong>
                  <p>Compartimos un pedacito de nuestra tierra con el corazon y buscamos hacer florecer talento.</p>
                </div>
                <div class="value-item">
                  <strong>Autenticidad Magnetica</strong>
                  <p>Creamos joyeria con proposito para quienes desean portar su propia historia.</p>
                </div>
              </div>
            </div>
          </v-col>
        </v-row>
      </v-container>
    </section>
  </div>
</template>

<style scoped>
.about-page {
  margin-top: 70px;
  background: linear-gradient(180deg, #faf7f4 0%, #f4efe9 100%);
  color: #5f5244;
}

.about-hero {
  background:
    radial-gradient(circle at top left, rgba(217, 200, 181, 0.45), transparent 28%),
    linear-gradient(180deg, #f8f4ef 0%, #f3ece5 100%);
}

.hero-emblem,
.section-kicker {
  display: inline-block;
  padding: 0.45rem 1rem;
  border-radius: 999px;
  background: rgba(184, 151, 120, 0.12);
  color: #8c745f;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  font-size: 0.78rem;
}

.hero-title,
.section-heading h2,
.story-card h3,
.founder-card h3,
.purpose-card h3,
.values-card h3 {
  color: #6b5b47;
  letter-spacing: 0.04em;
}

.hero-title {
  font-size: clamp(2.8rem, 7vw, 4.8rem);
  margin: 1.25rem 0 1rem;
}

.hero-text,
.story-card p,
.founder-card p,
.purpose-card p,
.value-item p {
  font-size: 1.02rem;
  line-height: 1.9;
  color: #7f6d5a;
}

.hero-text {
  max-width: 760px;
  margin: 0 auto;
}

.hero-quote {
  margin-top: 1.5rem;
  color: #8c745f;
  font-size: 1.15rem;
}

.story-grid,
.purpose-grid,
.founders-grid,
.values-grid {
  display: grid;
  gap: 1.5rem;
}

.story-grid,
.purpose-grid {
  grid-template-columns: 1.5fr 1fr;
}

.founders-grid {
  grid-template-columns: repeat(2, minmax(0, 1fr));
}

.values-grid {
  grid-template-columns: repeat(2, minmax(0, 1fr));
  margin-top: 1.5rem;
}

.story-card,
.founder-card,
.purpose-card,
.values-card {
  background: rgba(255, 252, 248, 0.88);
  border: 1px solid rgba(184, 151, 120, 0.16);
  border-radius: 28px;
  padding: 2rem;
  box-shadow: 0 18px 40px rgba(140, 116, 95, 0.08);
}

.founder-card {
  padding: 1.2rem;
}

.founder-media {
  position: relative;
  border-radius: 22px;
  overflow: hidden;
  margin-bottom: 1.4rem;
  min-height: 420px;
  background: linear-gradient(180deg, #eadfD4 0%, #c9b29c 100%);
  box-shadow: 0 20px 40px rgba(107, 91, 71, 0.14);
}

.founder-media::after {
  content: '';
  position: absolute;
  inset: 0;
  background: linear-gradient(180deg, rgba(35, 24, 17, 0.04) 0%, rgba(35, 24, 17, 0.3) 100%);
  pointer-events: none;
}

.founder-photo {
  display: block;
  width: 100%;
  height: 100%;
  min-height: 420px;
  object-fit: cover;
}

.founder-media--romero .founder-photo {
  object-position: center 20%;
}

.founder-media--izaguirre .founder-photo {
  object-position: center 18%;
}

.founder-photo-badge {
  position: absolute;
  left: 1rem;
  bottom: 1rem;
  z-index: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  min-width: 3.5rem;
  padding: 0.55rem 0.9rem;
  border-radius: 999px;
  background: rgba(255, 250, 244, 0.78);
  border: 1px solid rgba(255, 250, 244, 0.7);
  color: #6b5b47;
  letter-spacing: 0.12em;
  font-size: 0.78rem;
  backdrop-filter: blur(10px);
}

.founder-tag {
  display: block;
  margin-bottom: 0.8rem;
  color: #9a866f;
  letter-spacing: 0.12em;
  text-transform: uppercase;
  font-size: 0.75rem;
}

.value-item {
  padding: 1rem 1.1rem;
  border-radius: 18px;
  background: rgba(245, 239, 233, 0.7);
}

.value-item strong {
  color: #6b5b47;
  display: block;
  margin-bottom: 0.55rem;
}

@media (max-width: 960px) {
  .story-grid,
  .purpose-grid,
  .founders-grid,
  .values-grid {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 600px) {
  .about-page {
    margin-top: 84px;
  }

  .founder-media,
  .founder-photo {
    min-height: 360px;
  }

  .story-card,
  .founder-card,
  .purpose-card,
  .values-card {
    padding: 1.5rem;
  }
}
</style>