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
        mounted() {
            console.log('vue-closed-trades2 Component is  ready.');

            let self = this;

            // start spinner
            ezsNS.ezSlot.utils.spinner.spinnerById('example');
            axios.get('/api/closedSymbols')
                .then(function (response) {

                    let dataSet = [];

                    // dataTable wants to process an array of arrays; we get array of objects; so we need to convert.
                    for(let i=0;i<response.data.length; i++){
                        let data1 = [];
                        data1.push(response.data[i].close_date);
                        data1.push(response.data[i].underlier_symbol);
                        data1.push(ezsNS.ezSlot.utils.round(response.data[i].profits, 2));

                        dataSet.push(data1);
                    }

                    $("#example").dataTable({
                        // data and table columns
                        data: dataSet,
                        columns: [
                            { title: "Trade Date"},
                            { title: "Symbol" },
                            { title: "Profits" },
                        ],
                        order: [
                          [0, "desc" ]
                        ],
                        // print, copy and excel buttons
                        dom: 'lftiprB',
                        buttons: [
                            'print','copy', 'excel', 'csv'
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
                                'Page Total: '+ ezsNS.ezSlot.utils.displayCurrency(pageTotal,2) + ' -- Grand Total '+ ezsNS.ezSlot.utils.displayCurrency(total,2)
                            );
                        }
                    });
                    //stop spinner
                    ezsNS.ezSlot.utils.spinner.spinnerByIdStop();
                }).catch(function (error) {
                    console.log(error);
            });
        }
    }
</script>
