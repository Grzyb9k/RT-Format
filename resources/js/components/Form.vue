<template>
    <div
        class="
          fixed
          inset-0
          z-10
          flex
          items-center
          justify-center
          bg-gray-700 bg-opacity-50
        "
    >
        <div class="max-w-2xl p-6 bg-white rounded-md shadow-xl">
            <div class="flex items-center justify-between" v-if="!loading">
                <h3 class="text-2xl">Faktura {{ invoice.invoice_nr }}</h3>
                <svg
                    @click="closeModal"
                    xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-red-900 cursor-pointer"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                </svg>
            </div>
            <div class="flex items-center justify-center " v-if="loading">
                <div class="w-16 h-16 border-b-2 border-gray-900 rounded-full animate-spin"></div>
            </div>
            <div class="mt-4" v-if="!loading">
                <div class="alert alert-error my-2" v-if="errors" v-for="error in errors">
                    <div class="flex-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                             class="w-6 h-6 mx-2 stroke-current">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                        <label>{{ error }}</label>
                    </div>
                </div>
                <div class="form-control my-5">
                    <label class="label">
                        <span class="label-text">Kwota netto</span>
                    </label>
                    <input type="text" :placeholder="invoice.amount ? '' : '0,00'" class="input input-bordered"
                           @keypress="isNumber($event)" v-model="form.amount">

                </div>
                <form>
                    <div class="form-control my-5">
                        <label class="label">
                            <span class="label-text">Data wystawienia faktury</span>
                        </label>
                        <litepie-datepicker
                            as-single
                            i18n="pl"
                            :formatter="formatter"
                            v-model="invoiceDateField"
                        ></litepie-datepicker>
                    </div>
                    <div class="form-control my-5">
                        <label class="label">
                            <span class="label-text">Sprzedawca</span>
                        </label>
                        <select class="select select-bordered w-full max-w-xs" v-model="form.seller">
                            <option disabled="disabled" selected="selected" v-if="!invoice.seller">Wybierz sprzedawcę
                            </option>
                            <option v-for="seller in sellers" :value="seller.id">{{ seller.name }} (NIP:
                                {{ seller.vat_nr }})
                            </option>
                        </select>

                    </div>
                    <div class="form-control my-5">
                        <label class="label">
                            <span class="label-text">Kupujący</span>
                        </label>
                        <select class="select select-bordered w-full max-w-xs" v-model="form.customer">
                            <option disabled="disabled" selected="selected" v-if="!invoice.customer">Wybierz
                                kupującego
                            </option>
                            <option v-for="customer in customers" :value="customer.id">{{ customer.name }} (NIP:
                                {{ customer.vat_nr }})
                            </option>
                        </select>
                    </div>
                    <div class="form-control my-5">
                        <label class="label">
                            <span class="label-text">Produkt</span>
                        </label>
                        <select class="select select-bordered w-full max-w-xs" v-model="form.product">
                            <option disabled="disabled" selected="selected" v-if="!invoice.product">Wybierz produkt
                            </option>
                            <option v-for="product in products" :value="product.id">{{ product.name }}</option>
                        </select>
                    </div>
                    <button
                        @click="closeModal"
                        class="px-6 py-2 text-blue-800 border border-blue-600 rounded"
                    >
                        Anuluj
                    </button>
                    <button class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded" @click.prevent="submitForm">
                        Zapisz
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import { ref } from 'vue'
import LitepieDatepicker from 'litepie-datepicker'

export default {
    name: 'Form',
    props: ['editId'],
    setup () {
        const invoiceDateField = ref([])
        const formatter = ref({
            date: 'YYYY-MM-DD',
            month: 'MMM',
        })
        return {
            invoiceDateField, formatter,
        }
    },
    data () {
        return {
            invoice: [],
            sellers: [],
            customers: [],
            products: [],
            loading: !!this.editId,
            errors: [],
            success: [],
            action: null,
            form: {
                amount: null,
                seller: null,
                customer: null,
                product: null,
            },

        }
    },
    components: {
        LitepieDatepicker,
    },
    methods: {
        closeModal () {
            this.$emit('closeModal', '')
        },
        getInvoiceData () {
            axios.get('./api/invoice/' + this.editId, {}).then(response => {
                this.invoice = response.data.data.invoice
                this.form.seller = response.data.data.invoice.seller.id
                this.form.product = response.data.data.invoice.product.id
                this.form.amount = response.data.data.invoice.amount
                this.form.customer = response.data.data.invoice.customer.id
                this.invoiceDateField = response.data.data.invoice.invoice_date
                this.loading = false
            }).catch(response => {
                this.errors.push(response.error)
            })
        },
        getSellers () {
            axios.get('./api/seller', {}).then(response => {
                this.sellers = response.data.data.sellers
            }).catch(response => {
                this.errors.push(response.error)
            })
        },
        getCustomers () {
            axios.get('./api/customer', {}).then(response => {
                this.customers = response.data.data.customers
            }).catch(response => {
                this.errors.push(response.error)
            })
        },
        getProducts () {
            axios.get('./api/product', {}).then(response => {
                this.products = response.data.data.products
            }).catch(response => {
                this.errors.push(response.error)
            })
        },
        validateForm () {
            this.errors = []
            if (!this.form.amount) {
                this.errors.push('Kwota netto jest wymagana.')
            }
            if (!this.form.seller) {
                this.errors.push('Sprzedawca jest wymagany.')
            }
            if (!this.form.customer) {
                this.errors.push('Kupujący jest wymagany.')
            }
            if (!this.form.product) {
                this.errors.push('Produkt jest wymagany.')
            }
            if (this.invoiceDateField === '' || this.invoiceDateField.length === 0) {
                this.errors.push('Data wystawienia faktury jest wymagana.')
            }
            return this.errors.length === 0
        },
        isNumber (evt) {
            evt = (evt) ? evt : window.event
            const charCode = (evt.which) ? evt.which : evt.keyCode
            if ((charCode > 31 && (charCode < 48 || charCode > 57)) && charCode !== 46) {
                evt.preventDefault()
            } else {
                return true
            }
        },
        submitForm () {
            if (this.validateForm()) {
                let formData = {
                    amount: this.form.amount,
                    seller_id: this.form.seller,
                    customer_id: this.form.customer,
                    product_id: this.form.product,
                    invoice_date: this.action === 'POST' ? this.invoiceDateField[0] : this.invoiceDateField,
                    _method: this.action,
                }

                if (this.action === 'PUT') {
                    axios.post('./api/invoice/' + this.editId, formData).then(response => {
                        this.success.push('Pomyślnie zaktualizowano fakturę.')
                        this.$emit('refreshData')
                    }).catch(error => {
                        this.errors.push(error)
                    })
                }
                if (this.action === 'POST') {
                    axios.post('./api/invoice', formData).then(response => {
                        this.success.push('Pomyślnie utworzono fakturę.')
                        this.$emit('refreshData')
                    }).catch(error => {
                        this.errors.push(error)
                    })
                }
                this.$emit('closeModal', { success: this.success })
            }
        },
    },
    mounted () {
        this.getSellers()
        this.getCustomers()
        this.getProducts()
        if (this.editId) {
            this.getInvoiceData()
            this.action = 'PUT'
        } else {
            this.action = 'POST'
        }
    },

}
</script>
