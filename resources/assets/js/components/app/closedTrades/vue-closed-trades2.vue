<template>
    <div class="m-table">
        <table id="example" class="table table-striped table-bordered table-responsive" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th></th>
                    <th>Trade Date</th>
                    <th>Symbol</th>
                    <th>Profit</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="4" style="text-align:right"></th>
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
    th {
        white-space: nowrap;
    }
    td.details-control {
        background: url('../../../../../../public/img/detail_open.png') no-repeat center center;
        cursor: pointer;
    }
    tr.shown td.details-control {
        background: url('../../../../../../public/img/detail_close.png') no-repeat center center;
    }
    td.right-align {
        text-align: right;
    }
</style>
<script>
    export default {
        mounted() {
            console.log('vue-closed-trades2 Component is  ready.');

            let self = this;

            // start spinner
            this.spinnerById('example');

            // get data
            axios.get('/api/closedSymbols')
                .then(function (response) {

                    let dataSet = [];

                    // dataTable wants to process an array of arrays; we get array of objects; so we need to convert.
                    for(let i=0;i<response.data.length; i++){
                        let data1 = [];
                        data1.push(response.data[i].close_date);
                        data1.push(response.data[i].underlier_symbol);
                        data1.push(self.displayDollars(response.data[i].profits));

                        dataSet.push(data1);
                    }

                    $("#example").dataTable({
                        // data and table columns
                        data: dataSet,
                        autoWidth: false,     // allow container styling to work.
                        columns: [
                            {
                                "className":      'details-control',
                                "orderable":      false,
                                "data":           null,
                                "defaultContent": ''
                            },
                            { data: 0 },
                            { data: 1 },
                            { data: 2, "class": "right-align" },
                        ],
                        order: [
                          [1, "desc" ]
                        ],
                        "iDisplayLength": 25,
                        // print, copy and excel buttons
//                        dom: 'lftiprB',
//                        buttons: [
//                            'print','copy', 'excel', 'csv'
//                        ],
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
                                .column( 3 )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Total over this page
                            let pageTotal = api
                                .column( 3, { page: 'current'} )
                                .data()
                                .reduce( function (a, b) {
                                    return intVal(a) + intVal(b);
                                }, 0 );

                            // Update footer
                            $( api.column( 3 ).footer() ).html(
                                'Page Total: '+ self.displayDollars(pageTotal) + ' -- Grand Total '+ self.displayDollars(total)
                            );
                        }
                    });

                    //stop spinner
                    self.spinnerByIdStop();

                    // Add event listener for opening and closing details
                    $('#example tbody').on('click', 'td.details-control', function () {
                        let table = $('#example').DataTable();
                        let tr = $(this).closest('tr');
                        let row = table.row( tr );

                        if ( row.child.isShown() ) {
                            // This row is already open - close it
                            row.child.hide();
                            tr.removeClass('shown');
                        }
                        else {
                            // Open this row
                            row.child( ezsNS.ezSlot.SplashDetailTable.format(row.data()) ).show();
                            tr.addClass('shown');
                        }
                    });
                }).catch(function (error) {
                    console.log(error);

                    //stop spinner
                    self.spinnerByIdStop();
                })
            ;

        },
        methods: {
            displayDollars: function(num) {
                return ezsNS.ezSlot.utils.displayCurrency(num,2)
            },
            spinnerById: function(value) {
                return ezsNS.ezSlot.utils.spinner.spinnerById(value);
            },
            spinnerByIdStop: function() {
                return ezsNS.ezSlot.utils.spinner.spinnerByIdStop();
            }
        }
    }
</script>
