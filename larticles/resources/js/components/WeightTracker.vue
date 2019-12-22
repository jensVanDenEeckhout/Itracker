<template>
    <div>
        <h2>Weight tracker</h2>

        <form @submit.prevent="addweightRecord1" class="mb-3"> 
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Date" v-model="weightRecord.date">
            </div>

             <div class="form-group">
                <input type="text" class="form-control" placeholder="Weight" v-model="weightRecord.weight"></textarea>
            </div>

            <button type="submit" class="btn btn-light btn-block">Save</button>   
        </form>

        <div class="card card-body mb-2" v-for="weightRecord in weightRecords" v-bind:key="weightRecord.id">
            <h3> date: {{ weightRecord.date }} -> {{ weightRecord.weight }} kg</h3>
            <hr>  
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return {
            weightRecords: [],
            weightRecord: {
                id: '',
                date: new Date().toISOString().slice(0,10),
                weight: ''
            },
            weightRecord_id: '',
            pagination: {},
            edit: false
        };
    },

    created(){
        this.fetchWeightRecords();
    },

    methods: {
        fetchWeightRecords(page_url){
            let vm = this;
            page_url = page_url || '/api/weightRecords';
            fetch(page_url)
            .then(res => res.json())
            .then(res => {
                this.weightRecords = res.data;
            })
            .catch( err => console.log(err));
        },
        addweightRecord1(){
            if(this.edit === false){
                // add
                fetch('api/weightRecord1', {
                    method: 'post',
                    body: JSON.stringify(this.weightRecord),
                    headers: {
                        'content-type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    alert('weightRecord Added');
                    this.fetchWeightRecords();
                })
                .catch(err => console.log(err));
            }else{
            }
        }  
    }
};
</script>