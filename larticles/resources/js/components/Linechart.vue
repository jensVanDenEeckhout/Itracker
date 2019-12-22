<template>
  <nav class="navbar navbar-expand-sm navbar-dark bg-info mb-2">
    <div class="container">
      <a href="#" class="navbar-brand">Larticles</a>
    </div>
  </nav>
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