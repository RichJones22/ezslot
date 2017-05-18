/*
 example file to test out ezsNS

 file name: ezSlotUtils.js
 */

ezsNS.namespace('ezSlot.utils');
ezsNS.ezSlot.utils = {
    round: function (number, precision) {
        let factor = Math.pow(10, precision);
        let tempNumber = number * factor;
        let roundedTempNumber = Math.round(tempNumber);
        return roundedTempNumber / factor;
    },
    currencyFormat: function (num) {
        return "$" + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    },
    displayCurrency: function(num, precision) {
        return ezsNS.ezSlot.utils.currencyFormat(ezsNS.ezSlot.utils.round(num, precision));
    },
    // spinnerById: function(elId, options) {
    //
    //     // if options missing, or empty, set to an empty defaults
    //     if (typeof options === 'undefined') {
    //         options = {color: '#FF0000'};
    //     }
    //
    //     // http://spin.js.org/ for more options details; also see spin.js in this project.
    //     let target = document.getElementById(elId);
    //
    //     if (typeof elId === 'undefined') {
    //         console.log('spinnerById could not find ' + elId + ' on page; spinner not set...');
    //         return;
    //     }
    //
    //     return new Spinner(options).spin(target);
    // },
    // TODO:  may need to make this a class so that I can have multiple instances of spinner running concurrently...
    // http://spin.js.org/ for more options details; also see spin.js in this project.
    spinner: {
        spinnerInst: null,
        spinnerById: function(elId, options) {

            // if options missing, or empty, set to an empty defaults
            if (typeof options === 'undefined') {
                options = {color: '#FF0000'};
            }

            let target = document.getElementById(elId);

            if (typeof elId === 'undefined') {
                console.log('spinnerById could not find "' + elId + '" on page; spinner not set...');
                return;
            }

            // http://spin.js.org/ for more options details; also see spin.js in this project.
            ezsNS.ezSlot.utils.spinner.spinnerInst =  new Spinner(options).spin(target);

            return ezsNS.ezSlot.utils.spinner.spinnerInst;
        },
        spinnerByIdStop: function() {
            if (ezsNS.ezSlot.utils.spinner.spinnerInst !== null) {
                ezsNS.ezSlot.utils.spinner.spinnerInst.stop();
            }
        }
    }
};
