<template>
    <div class="w-min bg-white rounded-lg shadow-lg mx-auto p-4">
        <h1 class="text-2xl text-gray-700 text-center mb-4">
            Zadanie rekrutacyjne dla firmy <span class="font-bold text-primary">FORMAT</span>
        </h1>
        <div class="w-full flex">
            <button class="btn btn-outline my-5 ml-auto mr-0" @click.prevent="showEditForm">Utwórz fakturę</button>
        </div>
        <div class="alert alert-success my-3" v-for="successMsg in success">
            <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     class="w-6 h-6 mx-2 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
                <label>{{ successMsg }}</label>
            </div>
        </div>
        <div class="alert alert-error my-3" v-for="error in errors">
            <div class="flex-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                     class="w-6 h-6 mx-2 stroke-current">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                </svg>
                <label>{{ error }}</label>
            </div>
        </div>
        <div class="">
            <table class="table w-full table-zebra">
                <thead>
                <tr>
                    <th></th>
                    <th>Nr faktury</th>
                    <th>NIP kupującego</th>
                    <th>NIP sprzedającego</th>
                    <th>Nazwa produktu</th>
                    <th>Kwota netto</th>
                    <th>Data wystawienia</th>
                    <th>Data edycji</th>
                    <th>Funkcje</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="invoice in invoices" class="hover">
                    <td></td>
                    <td>{{ invoice.invoice_nr }}</td>
                    <td>{{ invoice.customer.vat_nr }}</td>
                    <td>{{ invoice.seller.vat_nr }}</td>
                    <td>{{ invoice.product.name }}</td>
                    <td>{{ invoice.amount }}</td>
                    <td>{{ invoice.invoice_date }}</td>
                    <td>{{ invoice.updated_at }}</td>
                    <td>
                        <button @click.prevent="showEditForm({id: invoice.id})" class="inline-block">
                            <edit-icon/>
                        </button>
                        <button @click.prevent="showDeleteModal({id: invoice.id, invoice_nr: invoice.invoice_nr })"
                                class="inline-block">
                            <delete-icon/>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <div class="w-full flex my-5">
            <div class="btn-group mx-auto">
                <button class="btn btn-outline" @click.prevent="getInvoices(paginator.currentPage-1)"
                        v-if="paginator.currentPage>1">Previous
                </button>
                <button class="btn btn-outline" :class="paginator.currentPage===n? 'btn-active' : ''"
                        @click.prevent="getInvoices(n)" v-for="n in paginator.lastPage"> {{ n }}
                </button>
                <button class="btn btn-outline" @click.prevent="getInvoices(paginator.currentPage+1)"
                        v-if="paginator.currentPage<paginator.lastPage">Next
                </button>
            </div>
        </div>
        <div class="text-sm w-full text-right text-gray-600">Paweł "Grzyb9k" Grzyb</div>
    </div>
    <Form v-if="formModal" @closeModal="showEditForm" @refreshData="getInvoices" :editId="toEdit"></Form>
    <ConfirmDelete v-if="deleteModal" @closeModal="showDeleteModal" @refreshData="getInvoices"
                   :invoiceData="toEdit"></ConfirmDelete>
</template>

<script>

import Form from './Form'
import ConfirmDelete from './ConfirmDelete'

import { lock, unlock } from 'tua-body-scroll-lock'

export default {
    data () {
        return {
            errors: [],
            invoices: null,
            success: [],
            url: window.location.href,
            paginator: {
                currentPage: null,
                lastPage: null,
                total: null,
            },
            formModal: false,
            deleteModal: false,
            toEdit: null,
        }
    },
    components: {
        Form,
        ConfirmDelete,
    },
    methods: {
        showDeleteModal (value) {
            this.toEdit = value
            this.deleteModal = !this.deleteModal
            if (this.deleteModal) {
                lock(document.querySelector('body'))
            } else {
                unlock(document.querySelector('body'))
            }
        },
        showEditForm (value) {
            this.toEdit = value.id
            if (value.success) {
                this.success = value.success
            }
            this.formModal = !this.formModal
            if (this.formModal) {
                lock(document.querySelector('body'))
            } else {
                unlock(document.querySelector('body'))
            }
        },
        getInvoices (goToPage) {
            !goToPage ? goToPage = this.paginator.currentPage : ''
            const url = './api/invoice'
            let query = null
            goToPage ? query = url + '?page=' + goToPage : query = url
            axios.get(query).then(response => {
                this.invoices = response.data.data.invoices
                this.paginator = response.data.meta

            }).catch(response => {
                this.error = response.error
            })
        },
    },
    mounted () {
        this.getInvoices(this.paginator.currentPage > 0 ? this.paginator.currentPage : 1)
    },
}
</script>
