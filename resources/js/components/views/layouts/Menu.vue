<template>
    <div>
        <admin-menu v-if="$store.state.user.profile === 1"/>
        <multilateral v-if="$store.state.user.profile === 2"/>
        <commercial v-if="$store.state.user.profile === 3"/>
        <multi-commercial v-if="$store.state.user.profile === 4"/>
        <not-assigned-menu v-if="$store.state.user.profile === 5"/>
    </div>
</template>

<script>
    import AdminMenu from './partials/AdminMenu';
    import Multilateral from './partials/Multilateral';
    import Commercial from './partials/Commercial';
    import MultiCommercial from './partials/MultiCommercial';
    import NotAssignedMenu from './partials/NotAssignedMenu';

    export default {
        components: {
            AdminMenu,
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
