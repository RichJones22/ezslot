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
            ezsNS.ezSlot.utils.spinner.spinnerById('example');
            axios.get('/api/closedSymbols')
                .then(function (response) {

                    let dataSet = [];

                    // dataTable wants to process an array of arrays; we get array of objects; so we need to convert.
                    for(let i=0;i<response.data.length; i++){
                        let data1 = [];
                        data1.push(response.data[i].close_date);
                        data1.push(response.data[i].underlier_symbol);
                        data1.push(ezsNS.ezSlot.utils.displayCurrency(response.data[i].profits, 2));

                        dataSet.push(data1);
                    }

                    $("#example").dataTable({
                        // data and table columns
                        data: dataSet,
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

                    /* Formatting function for row details - modify as you need */
                    function format () {
                        let table = document.createElement('table'), tr, td, total=0;
                        table.setAttribute("style", "float:right");

                        axios
                            .get('/api/getTradeDetails')
                            .then(function (response) {

                                // first header.
                                iTblHeader01(table);
                                iTblHeader02(table);

                                for (let i = 0; i < response.data.length; i++) {
                                    tr = document.createElement('tr');
                                    //
                                    td = document.createElement('td');
                                    tr.appendChild(td);
                                    td.innerHTML = response.data[i].close_date;
                                    table.appendChild(tr);
                                    //
                                    td = document.createElement('td');
                                    tr.appendChild(td);
                                    td.innerHTML = response.data[i].underlier_symbol;
                                    table.appendChild(tr);
                                    //
                                    td = document.createElement('td');
                                    tr.appendChild(td);
                                    td.innerHTML = response.data[i].option_type;
                                    table.appendChild(tr);
                                    //
                                    td = document.createElement('td');
                                    tr.appendChild(td);
                                    td.innerHTML = response.data[i].option_side;
                                    table.appendChild(tr);
                                    //
                                    td = document.createElement('td');
                                    td.className = "right-align";
                                    tr.appendChild(td);
                                    td.innerHTML = self.displayDollars(ParseIntOrEmptyString(response.data[i].amount)) + "&nbsp&nbsp";
                                    table.appendChild(tr);
                                    //
                                    td = document.createElement('td');
//                                    td.className = "right-align";
                                    tr.appendChild(td);

                                    let value = ParseIntOrEmptyString(response.data[i].profits);

                                    td.innerHTML = value !== "" ? self.displayDollars(value) : value;
                                    table.appendChild(tr);

                                    if (value !== "") {
                                        total += value;
                                    }
                                }
                                iTblFooter01(table);
                                iTblFooter02(table,total);
                            })
                            .catch(function (response) {
                                console.log(response);
                            })
                        ;

                        return table;
                    }

                    function ParseIntOrEmptyString(value) {
                        let intValue = parseInt(value);

                        if (isNaN(intValue)) {
                            return "";
                        }

                        return intValue;
                    }

                    function tblDetail(table,tr,str) {
                        let td;

                        td = document.createElement('td');
                        tr.appendChild(td);
                        td.innerHTML = str;
                        table.appendChild(tr);
                    }

                    function iTblHeader01(table) {
                        let tr;

                        tr = document.createElement('tr');
                        //
                        tblDetail(table,tr,"close Date &nbsp");
                        tblDetail(table,tr,"symbols &nbsp");
                        tblDetail(table,tr,"type &nbsp");
                        tblDetail(table,tr,"side &nbsp");
                        tblDetail(table,tr,"amount &nbsp&nbsp");
                        tblDetail(table,tr,"profit &nbsp");
                    }

                    function iTblHeader02(table) {
                        let tr;

                        tr = document.createElement('tr');
                        //
                        tblDetail(table,tr,"===========&nbsp");
                        tblDetail(table,tr,"========&nbsp");
                        tblDetail(table,tr,"=====&nbsp");
                        tblDetail(table,tr,"=====&nbsp");
                        tblDetail(table,tr,"=========&nbsp");
                        tblDetail(table,tr,"=======&nbsp");
                    }

                    function iTblFooter01 (table) {
                        let tr;

                        tr = document.createElement('tr');
                        //
                        tblDetail(table,tr,"");
                        tblDetail(table,tr,"");
                        tblDetail(table,tr,"");
                        tblDetail(table,tr,"");
                        tblDetail(table,tr,"");
                        tblDetail(table,tr,"=======&nbsp");
                    }

                    function iTblFooter02 (table, total) {
                        let tr;

                        tr = document.createElement('tr');
                        //
                        tblDetail(table,tr,"");
                        tblDetail(table,tr,"");
                        tblDetail(table,tr,"");
                        tblDetail(table,tr,"");
                        tblDetail(table,tr,"Total");
                        tblDetail(table,tr,self.displayDollars(total));
                    }

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
                            row.child( format() ).show();
                            tr.addClass('shown');
                        }
                    });

                    //stop spinner
                    ezsNS.ezSlot.utils.spinner.spinnerByIdStop();
                }).catch(function (error) {
                    console.log(error);
            });
        },
        methods: {
            displayDollars: function(num) {
                return ezsNS.ezSlot.utils.displayCurrency(num,2)
            }
        }
    }
</script>
