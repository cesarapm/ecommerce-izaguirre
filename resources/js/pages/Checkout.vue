<template>
  <v-container class="checked-page">
    <h1 class="text-h3 mb-8">Finalizar Compra</h1>

    <v-alert v-if="cartItems.length === 0" type="warning" class="mb-6">
      Tu carrito está vacío. <router-link :to="{ name: 'ProductList' }">Ver productos</router-link>
    </v-alert>

    <v-form v-else @submit.prevent="submitOrder">
      <v-row>
        <v-col cols="12" md="8">
          <!-- Información Personal -->
          <v-card class="mb-6">
            <v-card-title>📋 Información Personal</v-card-title>
            <v-card-text>
              <v-alert
                v-if="savedProfileExists"
                type="info"
                variant="tonal"
                class="mb-4"
              >
                Encontramos datos guardados en este dispositivo y ya precargamos tu formulario.
                <template #append>
                  <v-btn variant="text" size="small" @click="clearSavedProfile">
                    Olvidar datos
                  </v-btn>
                </template>
              </v-alert>

              <v-row>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="form.firstName"
                    label="Nombre *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="form.lastName"
                    label="Apellido *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="form.email"
                    label="Email *"
                    type="email"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="6">
                  <v-text-field
                    v-model="form.phone"
                    label="Teléfono *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-checkbox
                    v-model="form.saveCustomerProfile"
                    color="primary"
                    density="comfortable"
                    hide-details
                    label="Guardar mis datos y compras en este dispositivo para la próxima vez"
                  ></v-checkbox>
                  <p class="text-body-2 text-medium-emphasis mt-2">
                    No te pediremos contraseña. Solo usaremos esta información para autocompletar futuras compras en este navegador.
                  </p>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>

          <!-- Dirección de Envío -->
          <v-card class="mb-6">
            <v-card-title>📍 Dirección de Envío</v-card-title>
            <v-card-text>
              <v-row>
                <v-col cols="12">
                  <v-text-field
                    v-model="form.address"
                    label="Dirección *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field
                    v-model="form.city"
                    label="Ciudad *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field
                    v-model="form.state"
                    label="Estado *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12" sm="4">
                  <v-text-field
                    v-model="form.zipCode"
                    label="Código Postal *"
                    variant="outlined"
                    required
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-textarea
                    v-model="form.notes"
                    label="Notas adicionales (opcional)"
                    variant="outlined"
                    rows="2"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>

          <!-- Método de Pago -->
          <v-card>
            <v-card-title>💳 Método de Pago</v-card-title>
            <v-card-text>
              <v-radio-group v-model="form.paymentMethod" class="payment-methods-group">
                <div class="payment-option" :class="{ 'payment-option--active': form.paymentMethod === 'mercado_pago' }">
                  <v-radio label="Mercado Pago" value="mercado_pago"></v-radio>
                  <p class="payment-option__description">
                    Paga con tarjeta, saldo o métodos disponibles en Mercado Pago y regresa al checkout con el estado de tu compra.
                  </p>
                </div>

                <div class="payment-option" :class="{ 'payment-option--active': form.paymentMethod === 'transferencia' }">
                  <v-radio label="Transferencia bancaria" value="transferencia"></v-radio>
                  <p class="payment-option__description">
                    Genera tu orden y continúa con la confirmación manual del depósito o transferencia.
                  </p>
                </div>
              </v-radio-group>
            </v-card-text>
          </v-card>
        </v-col>

        <!-- Resumen -->
        <v-col cols="12" md="4">
          <v-card v-if="recentOrders.length" class="mb-4">
            <v-card-title>🕘 Compras recientes</v-card-title>
            <v-divider></v-divider>
            <v-list density="compact">
              <v-list-item v-for="order in recentOrders" :key="order.order_number">
                <v-list-item-title>
                  {{ order.order_number }}
                </v-list-item-title>
                <v-list-item-subtitle>
                  {{ order.status_label }} • {{ order.created_at }}
                </v-list-item-subtitle>
                <template v-slot:append>
                  <span>${{ Number(order.total).toFixed(2) }}</span>
                </template>
              </v-list-item>
            </v-list>
          </v-card>

          <v-card class="mb-4">
            <v-card-title>🛒 Tu Pedido</v-card-title>
            <v-divider></v-divider>
            <v-list density="compact">
              <v-list-item v-for="item in cartItems" :key="item.id">
                <v-list-item-title>
                  {{ item.name }} x{{ item.quantity }}
                </v-list-item-title>
                <template v-slot:append>
                  <span>${{ (item.price * item.quantity).toFixed(2) }}</span>
                </template>
              </v-list-item>
            </v-list>
          </v-card>

          <v-card>
            <v-card-title>💰 Resumen</v-card-title>
            <v-divider></v-divider>
            <v-card-text>
              <div class="d-flex justify-space-between mb-2">
                <span>Subtotal:</span>
                <span>${{ subtotal.toFixed(2) }}</span>
              </div>
              <div class="d-flex justify-space-between mb-2">
                <span>Envío:</span>
                <span>${{ shippingCost.toFixed(2) }}</span>
              </div>
              <v-divider class="my-3"></v-divider>
              <div class="d-flex justify-space-between">
                <span class="font-weight-bold text-h6">Total:</span>
                <span class="font-weight-bold text-h5 text-success">
                  ${{ total.toFixed(2) }}
                </span>
              </div>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions class="flex-column pa-4">
              <v-btn
                color="primary"
                block
                size="large"
                type="submit"
                :loading="submitting"
                :prepend-icon="form.paymentMethod === 'mercado_pago' ? 'mdi-credit-card-outline' : 'mdi-bank-transfer-out'"
                class="mb-2"
              >
                {{ form.paymentMethod === 'mercado_pago' ? 'Continuar a Mercado Pago' : 'Crear pedido por transferencia' }}
              </v-btn>
              <v-btn
                variant="outlined"
                block
                @click="$router.back()"
              >
                Volver
              </v-btn>
            </v-card-actions>
          </v-card>
        </v-col>
      </v-row>
    </v-form>

    <!-- Modal de Éxito -->
    <v-dialog v-model="successDialog" max-width="500" persistent>
      <v-card>
        <v-card-title class="text-h5 text-center py-6 bg-success">
          <v-icon size="64" color="white" class="mb-2">mdi-check-circle</v-icon>
          <div class="text-white">¡Pedido registrado!</div>
        </v-card-title>
        <v-card-text class="text-center pa-6">
          <p class="text-h6 mb-2">Orden #{{ orderNumber }}</p>
          <p class="text-body-1 mb-4">Total: ${{ orderTotal }}</p>
          <p class="text-body-2 text-grey mb-4">
            {{ successMessage }}
          </p>
        </v-card-text>
        <v-card-actions class="justify-center pb-6 flex-column">
          <v-btn
            color="success"
            @click="closeSuccessDialog"
            block
          >
            Entendido
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Modal de Error -->
    <v-dialog v-model="errorDialog" max-width="500">
      <v-card>
        <v-card-title class="text-h5 text-center py-6 bg-error">
          <v-icon size="64" color="white" class="mb-2">mdi-alert-circle</v-icon>
          <div class="text-white">Error</div>
        </v-card-title>
        <v-card-text class="text-center pa-6">
          <p class="text-body-1">{{ errorMessage }}</p>
        </v-card-text>
        <v-card-actions class="justify-center pb-6">
          <v-btn color="error" @click="errorDialog = false">Cerrar</v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <!-- Snackbar de validación -->
    <v-snackbar v-model="validationSnackbar" color="warning" :timeout="3000">
      Por favor completa todos los campos requeridos
    </v-snackbar>
  </v-container>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useCart } from '../composables/useCart';

const router = useRouter();
const { cartItems, subtotal, clearCart } = useCart();

const checkoutProfileStorageKey = 'joyeria_checkout_profile';
const checkoutOrdersStorageKey = 'joyeria_checkout_orders';

const createEmptyForm = () => ({
  firstName: '',
  lastName: '',
  email: '',
  phone: '',
  address: '',
  city: '',
  state: '',
  zipCode: '',
  notes: '',
  paymentMethod: 'mercado_pago',
  saveCustomerProfile: false
});

const form = ref(createEmptyForm());

const shippingCost = computed(() => subtotal.value > 50 ? 0 : 10);
const total = computed(() => subtotal.value + shippingCost.value);
const submitting = ref(false);
const savedProfileExists = ref(false);
const recentOrders = ref([]);

// Estados para modales
const successDialog = ref(false);
const errorDialog = ref(false);
const validationSnackbar = ref(false);
const errorMessage = ref('');
const orderNumber = ref('');
const orderTotal = ref(0);
const successMessage = ref('');
const transferWhatsAppNumber = '5580091558'; // Reemplaza con el número real de WhatsApp para transferencias

const loadSavedProfile = () => {
  const rawProfile = window.localStorage.getItem(checkoutProfileStorageKey);

  if (!rawProfile) {
    savedProfileExists.value = false;
    return;
  }

  try {
    const profile = JSON.parse(rawProfile);
    form.value = {
      ...form.value,
      ...profile,
      notes: form.value.notes,
      paymentMethod: form.value.paymentMethod,
      saveCustomerProfile: true
    };
    savedProfileExists.value = true;
  } catch (error) {
    console.warn('No se pudieron cargar los datos guardados del checkout.', error);
    window.localStorage.removeItem(checkoutProfileStorageKey);
    savedProfileExists.value = false;
  }
};

const loadRecentOrders = () => {
  const rawOrders = window.localStorage.getItem(checkoutOrdersStorageKey);

  if (!rawOrders) {
    recentOrders.value = [];
    return;
  }

  try {
    recentOrders.value = JSON.parse(rawOrders);
  } catch (error) {
    console.warn('No se pudieron cargar las compras recientes.', error);
    window.localStorage.removeItem(checkoutOrdersStorageKey);
    recentOrders.value = [];
  }
};

const persistSavedProfile = () => {
  const profile = {
    firstName: form.value.firstName,
    lastName: form.value.lastName,
    email: form.value.email,
    phone: form.value.phone,
    address: form.value.address,
    city: form.value.city,
    state: form.value.state,
    zipCode: form.value.zipCode
  };

  window.localStorage.setItem(checkoutProfileStorageKey, JSON.stringify(profile));
  savedProfileExists.value = true;
};

const persistRecentOrder = (order) => {
  const orderHistory = [
    {
      order_number: order.order_number,
      total: Number(order.total),
      status: order.status,
      status_label: order.status === 'pendiente_transferencia' ? 'Pendiente de transferencia' : 'Pendiente de pago',
      created_at: new Date().toLocaleDateString('es-MX'),
    },
    ...recentOrders.value.filter(item => item.order_number !== order.order_number)
  ].slice(0, 5);

  recentOrders.value = orderHistory;
  window.localStorage.setItem(checkoutOrdersStorageKey, JSON.stringify(orderHistory));
};

const clearSavedProfile = () => {
  window.localStorage.removeItem(checkoutProfileStorageKey);
  window.localStorage.removeItem(checkoutOrdersStorageKey);
  savedProfileExists.value = false;
  recentOrders.value = [];
  form.value.saveCustomerProfile = false;
};

onMounted(() => {
  loadSavedProfile();
  loadRecentOrders();
});

const extractApiErrorMessage = async (response, result) => {
  if (result?.errors) {
    const firstErrorGroup = Object.values(result.errors)[0];
    if (Array.isArray(firstErrorGroup) && firstErrorGroup[0]) {
      return firstErrorGroup[0];
    }
  }

  if (result?.message) {
    return result.message;
  }

  const fallbackText = await response.text();
  return fallbackText || 'No se pudo crear la orden';
};

const closeSuccessDialog = () => {
  successDialog.value = false;
  clearCart();
  router.push({ name: 'Home' });
};

const buildTransferWhatsAppUrl = (order) => {
  const itemsSummary = cartItems.value
    .map(item => `- ${item.name} x${item.quantity}`)
    .join('\n');

  const message = [
    'Hola, acabo de generar un pedido por transferencia en IzaguirreQu.',
    '',
    `Orden: #${order.order_number}`,
    `Nombre: ${form.value.firstName} ${form.value.lastName}`,
    `Telefono: ${form.value.phone}`,
    `Email: ${form.value.email}`,
    `Direccion: ${form.value.address}, ${form.value.city}, ${form.value.state}, CP ${form.value.zipCode}`,
    '',
    'Piezas:',
    itemsSummary,
    '',
    `Total: $${Number(order.total).toFixed(2)} MXN`,
    'Comparto mi comprobante para continuar con la confirmacion.'
  ].join('\n');

  return `https://wa.me/${transferWhatsAppNumber}?text=${encodeURIComponent(message)}`;
};

const buildOrderPayload = () => ({
  customer_first_name: form.value.firstName,
  customer_last_name: form.value.lastName,
  customer_email: form.value.email,
  customer_phone: form.value.phone,
  shipping_address: form.value.address,
  shipping_city: form.value.city,
  shipping_state: form.value.state,
  shipping_zip_code: form.value.zipCode,
  subtotal: subtotal.value,
  shipping_cost: shippingCost.value,
  total: total.value,
  notes: form.value.notes,
  save_customer_profile: form.value.saveCustomerProfile,
  items: cartItems.value.map(item => ({
    product_id: item.id,
    product_name: item.name,
    quantity: item.quantity,
    unit_price: item.price
  }))
});

const submitOrder = async () => {
  // Validar formulario
  if (!form.value.firstName || !form.value.lastName || !form.value.email || !form.value.phone || !form.value.address || !form.value.city || !form.value.state || !form.value.zipCode) {
    validationSnackbar.value = true;
    return;
  }

  const transferWindow = form.value.paymentMethod === 'transferencia'
    ? window.open('', '_blank')
    : null;

  try {
    submitting.value = true;
    const endpoint = form.value.paymentMethod === 'transferencia'
      ? '/api/crear-pedido/transferencia'
      : '/api/crear-pedido';

    const response = await fetch(endpoint, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      },
      body: JSON.stringify(buildOrderPayload())
    });

    const result = await response.json();

    if (!response.ok || result.success === false) {
      throw new Error(await extractApiErrorMessage(response, result));
    }

    if (form.value.saveCustomerProfile) {
      persistSavedProfile();
      persistRecentOrder(result.order);
    }

    if (form.value.paymentMethod === 'mercado_pago') {
      sessionStorage.setItem('last_mercado_pago_order_id', String(result.order.id));

      if (!result.checkout_url) {
        throw new Error('La orden se creó, pero Mercado Pago no devolvió una URL de pago.');
      }

      window.location.href = result.checkout_url;
      return;
    }

    const transferWhatsAppUrl = buildTransferWhatsAppUrl(result.order);

    orderNumber.value = result.order.order_number;
    orderTotal.value = Number(result.order.total).toFixed(2);
    successMessage.value = 'Tu pedido quedó registrado con pago por transferencia. Puedes continuar con el comprobante o contacto de confirmación.';
    if (transferWindow) {
      transferWindow.location.replace(transferWhatsAppUrl);
    } else {
      window.open(transferWhatsAppUrl, '_blank');
    }

    successDialog.value = true;
    return;

  } catch (error) {
    if (transferWindow && !transferWindow.closed) {
      transferWindow.close();
    }

    console.error('Error al procesar la orden:', error);
    errorMessage.value = 'Error al procesar tu pedido: ' + error.message;
    errorDialog.value = true;
  } finally {
    submitting.value = false;
  }
};
</script>
<style>
    header{
    font-family: var(--font-brand), serif;
    margin: 0;
    padding: 0;
    font-size: 16px;
    scroll-behavior: smooth;
}
* {
      font-family: var(--font-brand), serif;
    margin: 0;
    padding: 0;
    font-size: 16px;
    scroll-behavior: smooth;
  }
.checked-page{
margin-top: 150px !important;
}

.payment-option {
  padding: 1rem 1rem 0.85rem;
  border: 1px solid rgba(184, 151, 120, 0.16);
  border-radius: 18px;
  background: rgba(249, 245, 241, 0.86);
  margin-bottom: 0.85rem;
}

.payment-option--active {
  border-color: rgba(140, 116, 95, 0.34);
  box-shadow: 0 14px 28px rgba(107, 91, 71, 0.08);
}

.payment-option__description {
  color: #7f6d5a;
  line-height: 1.65;
  padding-left: 2.2rem;
  padding-top: 0.2rem;
  font-size: 0.95rem;
}


</style>
