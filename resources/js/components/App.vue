<template>
    <div>
        <button
            type="button"
            class="btn btn-outline-primary btn-lg mb-2 btn-block"
            @click="showModal"
        >
            Agregar nuevo plan
        </button>
        
        <Plan
            v-for="plan in plans"
            :key="plan.id"
            :plan="plan"
            @refresh="onRefresh"
        />
        <div class="modal fade" id="addPlanModal" tabindex="-1" role="dialog" aria-labelledby="addPlanModalTitle" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Nuevo Plan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div> Nombre:</div><input type="text" v-model="newName" />
                    <p><p/>
                    <div>Precio: </div><input type="number" v-model="newPrice" />
                    <p><p/>
                    <div>Que incluye: </div>
                    <input type="text" v-model="newFeature" v-on:keyup.enter="addNewFeature"/>
                    <button class="btn btn-info" @click="addNewFeature">
                        Agregar
                    </button>
                    <ul>
                        <li v-for="(i, index) in newFeatures" :key="index">
                            {{i}}
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="closeModal">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="savePlan" :disabled="isFormInvalid">Guardar</button>
                </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Plan from './Plan.vue';

export default {
    name: 'App',
    components: {
        Plan
    },
    data: function() {
        return {
            plans: [],
            newName: '',
            newPrice: '',
            newFeature: '',
            newFeatures: []
        }
    },
    mounted: function() {
        fetch('/api/plans')
            .then(response => response.json())
            .then(p => {
                this.plans = p;
            })
            .catch(e => console.error(e));
    },
    methods: {
        onRefresh: function () {
            fetch('/api/plans')
            .then(response => response.json())
            .then(p => {
                this.plans = p;
            })
            .catch(e => console.error(e));
        },
        addNewFeature: function() {
            if(this.newFeature.length > 0) {
                this.newFeatures.push(this.newFeature);
                this.newFeature = '';
            }
        },
        closeModal: function() {
           $('#addPlanModal').modal('hide');
           this.newName = '';
           this.newPrice = '';
           this.newFeature = '';
           this.newFeatures = [];
        },
        showModal: function() {
            $('#addPlanModal').modal('show');
        },
        savePlan: function() {
            let params = '';
            params += `name=${this.newName}`;
            params += `&price=${this.newPrice}`;
            
            const features = this.newFeatures.join(',');
            params += `&includes=${features}`;

            fetch(`/api/plans?${params}`, {
                method: 'POST'
            }).then(() => {
                console.log('ok');
                this.onRefresh();
                this.closeModal();
            });
        }
    },
    computed: {
        isFormInvalid: function() {
            return (
                !this.newName.length ||
                !this.newPrice.length ||
                !this.newFeatures.length
            )
        }
    }
}
</script>