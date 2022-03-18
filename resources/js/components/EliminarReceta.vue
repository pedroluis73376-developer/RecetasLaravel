<template>
    <input
        type="submit"
        class="btn btn-danger d-line  mb-1"
        value="eliminar"
        @click="eliminarReceta"
    />
</template>

<script>
export default {
    props: ["recetaId"],
    mounted() {
        console.log("receta actual", this.recetaId);
    },
    methods: {
        eliminarReceta() {
            this.$swal({ 
                title: "Deseas Eliminar la Receta",
                text: "Una vez Eliminada no se puede Recuperar",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "SI",
                cancelButtonText: "No"
            }).then((result) => {
                if (result.isConfirmed) {
                    const params={
                        id: this.recetaId
                    }

                    axios.post(`/recetas/${this.recetaId}`, {params, _method: 'delete'})
                    .then(respuesta =>{
                        this.$swal({
                        title:'rectea eliminada',
                        text:'Se elimino la receta',
                        icon: 'success'});
                        
                        //eliminar receta de DOM
                        this.$el.parentNode.parentNode.parentNode.removeChild(this.$el.parentNode.parentNode);
                    })
                    .catch(error =>
                    {
                        console.log(error)
                    })

                    
                }
            });
        },
    },
};
</script>
