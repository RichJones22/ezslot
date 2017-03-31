<template>
    <div class="m-table">
        <table id="example" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%"></table>
    </div>
</template>
<style>
    .m-table {
        padding: 2rem;
        border: hidden;
        border-radius: 3rem;
        background-color: #a2a2a2;
    }
</style>
<script>
    export default {
        data(){
            return{
            }
        },
        mounted() {
            console.log('vue-closed-trades2 Component is  ready.');

            let self = this;

            axios.get('/api/closedSymbols')
                .then(function (response) {
                    self.skills = response.data;

                    let dataSet = [];

                    for(let i=0;i<self.skills.length; i++){
                        let data = [];
                        data.push(self.skills[i].close_date);
                        data.push(self.skills[i].underlier_symbol);
                        data.push(self.skills[i].profits);

                        dataSet.push(data);
                    }

                    $("#example").dataTable( {
                        data: dataSet,
                        processing: true,
                        columns: [
                            { title: "Trade Date" },
                            { title: "Symbol" },
                            { title: "Profits" },
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            'copy', 'excel', 'pdf'
                        ]
                    } );
                });
        },

        computed: {
            runningTotal: function () {
                if (this.skills.length > 0) {
                    return this.skills.reduce(function(prev, elem){
                        return prev + elem.profits;
                    },0);
                } else {
                    return 0;
                }
            }
        }
    }
</script>
