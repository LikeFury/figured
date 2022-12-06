<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Figured Test</div>

                    <div class="card-body">

                        Quantity: <input v-model="quantity" type="text">
                        <br />
                        <button @click="checkQuantity()">Check</button>

                        <br />
                        {{ message }}

                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { ref } from 'vue'

    export default {

        setup() {

            const quantity = ref(0);
            let message = ref('');

            async function checkQuantity()
            {
                axios.post('/api/inventory/check', {
                    quantity: quantity.value
                })
                    .then(function (response) {
                        message.value = 'The value is: $' + response.data.data.value
                    })
                    .catch((error) => {
                        console.log(error.response.data.message)
                        message.value = 'ERROR: ' + error.response.data.message
                    })
            }

            return {
                quantity,
                checkQuantity,
                message
            }
        },

        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
