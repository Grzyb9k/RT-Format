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
            <div class="flex items-center justify-between">
                <h3 class="text-2xl">Wymagane potwierdzenie</h3>
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
            <p class="my-10">Czy na pewno chcesz usunąć fakturę {{ invoiceData.invoice_nr }} ?</p>
                    <button
                        @click="closeModal"
                        class="px-6 py-2 text-blue-800 border border-blue-600 rounded"
                    >
                       NIE
                    </button>
                    <button class="px-6 py-2 ml-2 text-blue-100 bg-blue-600 rounded" @click.prevent="deleteInvoice">
                        TAK
                    </button>

            </div>
        </div>
</template>

<script>
export default {
    name: 'ConfirmDelete',
    props: ['invoiceData'],
    data () {
        return {
            errors: [],
            success: [],
        }
    },
    methods: {
        closeModal () {
            this.$emit('closeModal', '')
        },
        deleteInvoice() {
            axios.post('./api/invoice/'+this.invoiceData.id, {_method: 'DELETE'}).then(response => {
                console.log(response)
                this.success.push('Pomyślnie usunięto fakturę.')
                this.$emit('refreshData')
            }).catch(error => {
                this.errors.push(error);
            })
            this.$emit('closeModal', { success: this.success, errors: this.errors })
        }
    }
}
</script>

<style scoped>

</style>
