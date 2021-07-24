<template>
    <div class="plan">
        <h1 v-if="!isEditing">{{plan.name}}</h1>
        <h1 v-if="isEditing"><input v-model="name" type="text"></h1>
        <p>Que incluye:</p>
        <div v-if="isEditing">
            <input v-model="newFeature" type="text" placeholder="Agrega mas beneficios" />
            <button class="btn btn-info" @click="addFeature">Agregar</button>
        </div>
        <ul v-if="!isEditing">
            <li v-for="(i, index) in plan.includes" :key="index">
                {{i}}
            </li>
        </ul>
        <ul v-if="isEditing">
            <li v-for="(i, index) in includes" :key="index">
                {{i}}
                <i title="Eliminar" class="delete" @click="deleteFeature(index)">&times;</i>
            </li>
        </ul>
        <p v-if="!isEditing">Precio: Q {{plan.price}}</p>
        <p v-if="isEditing">Precio: Q <input type="text" v-model="plan.price" /></p>
        <div>
            <button
                @click="toggleEdit"
                v-if="!isEditing"
                class="btn btn-primary"
            >
                Editar
            </button>
            <button
                @click="deletePlan"
                v-if="!isEditing"
                class="btn btn-danger"
            >
                Eliminar
            </button>
            <button
                @click="edit"
                v-if="isEditing"
                class="btn btn-success"
            >
                Actualizar
            </button>
            <button
                class="btn btn-secondary"
                @click="toggleEdit"
                v-if="isEditing"
            >
                Cancelar
            </button>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Plan',
    data: function() {
        return {
            name: this.plan.name,
            price: this.plan.price,
            includes: this.plan.includes,
            isEditing: false,
            newFeature: ''
        }
    },
    props: ['plan'],
    methods: {
        toggleEdit: function() {
            if(this.isEditing) {
                this.$emit('refresh', null);
            }
            this.isEditing = !this.isEditing;
        },
        edit: function() {
            let params = '';
            params += `name=${this.name}`;
            params += `&price=${this.price}`;
            
            const features = this.includes.join(',');
            params += `&includes=${features}`;

            fetch(`/api/plans/${this.plan.id}?${params}`, {
                method: 'PUT'
            }).then(() => {
                console.log('ok');
                this.isEditing = false;
                this.$emit('refresh', null);
            });
        },
        addFeature: function() {
            this.includes.push(this.newFeature);
            this.newFeature = '';
        },
        deleteFeature: function(index) {
            this.includes.splice(index, 1);
        },
        deletePlan: function() {
            fetch(`/api/plans/${this.plan.id}`, {
                method: 'DELETE'
            }).then(() => {
                console.log('ok');
                this.$emit('refresh', null);
            });
        }
    }
}
</script>

<style lang="scss" scoped>
.plan {
    border: 1px solid rgba(0, 0, 0, 0.3);
    border-radius: 25px;
    padding: 20px;
    margin-bottom: 20px;
}

.delete {
    font-style: normal;
    cursor: pointer;
    font-weight: bold;
}
</style>