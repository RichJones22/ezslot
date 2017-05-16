/*
 this file manages the detail table that is produced when a user clicks on a table row on the Splash screen.

 file name: ezsSplashDetailTable.js
 */

ezsNS.namespace('ezSlot.SplashDetailTable');
ezsNS.ezSlot.SplashDetailTable = {
    /* Formatting function for row details */
    format: function (rowData) {
        console.log('enter -- ezsSplashDetailTable.js');

        let table = document.createElement('table'), tr, total=0;
        table.setAttribute("style", "float:right");

        let closeDate = rowData[0];
        let symbol = rowData[1];

        axios
            .get('/api/getTradeDetails', {
                params: {
                    'close_date': closeDate,
                    'symbol': symbol,
                }
            })
            .then(function (response) {

                response.data = JSON.parse(response.data[0].trade_details);

                // first header.
                ezsNS.ezSlot.SplashDetailTable.iTblHeader01(table);
                ezsNS.ezSlot.SplashDetailTable.iTblHeader02(table);

                for (let i = 0; i < response.data.length; i++) {
                    tr = document.createElement('tr');
                    //
                    ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,response.data[i].close_date);
                    // ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,response.data[i].underlier_symbol);
                    ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,response.data[i].option_type);
                    ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,response.data[i].option_side);
                    ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,response.data[i].option_quantity  + "&nbsp","right-align");
                    ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,ezsNS.ezSlot.SplashDetailTable.displayDollars(ezsNS.ezSlot.SplashDetailTable.ParseIntOrEmptyString(response.data[i].amount)) + "&nbsp", "right-align");

                    let value = ezsNS.ezSlot.SplashDetailTable.ParseIntOrEmptyString(response.data[i].profits);
                    ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,value !== "" ? ezsNS.ezSlot.SplashDetailTable.displayDollars(value) + "&nbsp" : value + "&nbsp", "right-align");

                    if (value !== "") {
                        total += value;
                    }
                }
                ezsNS.ezSlot.SplashDetailTable.iTblFooter01(table);
                ezsNS.ezSlot.SplashDetailTable.iTblFooter02(table,total);
            })
            .catch(function (response) {
                console.log(response);
            })
        ;
        return table;
    },
    ParseIntOrEmptyString: function(value) {
        let intValue = parseFloat(value);

        if (isNaN(intValue)) {
            return "";
        }

        return intValue;
    },
    tblDetail: function(table,tr,str,style) {
        let td;

        td = document.createElement('td');
        tr.appendChild(td);
        td.innerHTML = str;
        if (typeof style !== 'undefined') {
            td.className = "right-align";
        }
        table.appendChild(tr);
    },
    iTblHeader01: function(table) {
        let tr;

        tr = document.createElement('tr');
        //
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"close Date&nbsp");
        // ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"symbols &nbsp");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"type&nbsp");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"side&nbsp");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"qty&nbsp");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"amount&nbsp","right-align");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"profit&nbsp","right-align");
    },
    iTblHeader02: function (table) {
        let tr;

        tr = document.createElement('tr');
        //
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"==========&nbsp");
        // ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"========&nbsp");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"====&nbsp");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"====&nbsp");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"===&nbsp");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"============&nbsp");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"============&nbsp");
    },
    iTblFooter01: function(table, total) {
        let tr;

        tr = document.createElement('tr');
        //
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        // ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"============&nbsp");
    },
    iTblFooter02: function(table, total) {
        let tr;

        tr = document.createElement('tr');
        //
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        // ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,"Total");
        ezsNS.ezSlot.SplashDetailTable.tblDetail(table,tr,ezsNS.ezSlot.SplashDetailTable.displayDollars(total) + "&nbsp","right-align");
    },
    displayDollars: function(num) {
        return ezsNS.ezSlot.utils.displayCurrency(num,2)
    }
};
