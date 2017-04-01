<template>
    <div class="m-table">
        <table id="example" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
            <tfoot>
                <tr>
                    <th colspan="3" style="text-align:right"></th>
                </tr>
            </tfoot>
        </table>
    </div>
</template>
<style>
    .m-table {
        padding: 2rem;
        border: hidden;
        border-radius: 3rem;
        background-color: #a2a2a2;
    }
    th { white-space: nowrap; }
</style>
<script>
    export default {
//        data(){
//            return{
//            }
//        },
        mounted() {
            console.log('vue-closed-trades2 Component is  ready.');

            let self = this;

            axios.get('/api/closedSymbols')
                .then(function (response) {
                    self.skills = response.data;

                    let dataSet = [];

                    for(let i=0;i<self.skills.length; i++){
                        let data1 = [];
                        data1.push(self.skills[i].close_date);
                        data1.push(self.skills[i].underlier_symbol);
                        data1.push(self.skills[i].profits);

                        dataSet.push(data1);
                    }

                    let table = $("#example").dataTable({
                        // data and table columns
                        data: dataSet,
                        columns: [
                            { title: "Trade Date" },
                            { title: "Symbol" },
                            { title: "Profits" },
                        ],
                        // print, copy and excel buttons
                        dom: 'lftiprB',
                        buttons: [
                            'print','copy', 'excel'
                        ],
                        // display totals in the footer row.
                        "footerCallback": function ( row, data, start, end, display ) {
                            let api = this.api();

                            // Remove the formatting to get integer data for summation
                            let intVal = function ( i ) {
                                return typeof i === 'string' ?
                                    i.replace(/[\$,]/g, '')*1 :
                                    typeof i === 'number' ?
                                        i : 0;
                            };

                            // Total over all pages
                            let total = api
                                .column( 2 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Total over this page
                            let pageTotal = api
                                .column( 2, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Update footer
                            $( api.column( 2 ).footer() ).html(
                                'Page Total: '+ rgNS.ezSlot.utils.displayNumber(pageTotal,2) + ' -- Grand Total '+ rgNS.ezSlot.utils.displayNumber(total,2)
                            );
                        }
                    });
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
