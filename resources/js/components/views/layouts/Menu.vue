<template>
    <div>
        <admin-menu v-if="$store.state.user.profile === 1"/>
        <capturist-menu v-if="$store.state.user.profile === 2"/>

    </div>
</template>

<script>
    import AdminMenu from './partials/AdminMenu';
    import CapturistMenu from "./partials/CapturistMenu";
    import Multilateral from './partials/Multilateral';
    import Commercial from './partials/Commercial';
    import MultiCommercial from './partials/MultiCommercial';
    import NotAssignedMenu from './partials/NotAssignedMenu';

    export default {
        components: {
            AdminMenu,
            CapturistMenu,
            Multilateral,
            Commercial,
            MultiCommercial,
            NotAssignedMenu
        },

        created() {
            let data = {cat_transaction_type_id : 1, action: 'Entra a inicio'};

            axios.post('/api/transaction', data).then(response => {
            }).catch(error => {
                this.$message({
                    type: "warning",
                    message: "No fue posible completar la acción, intente nuevamente."
                });
            });
        },
    }
</script>

<style scoped>

</style>
