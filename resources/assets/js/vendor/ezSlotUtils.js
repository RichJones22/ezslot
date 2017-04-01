/*
 example file to test out rgNS

 file name: ezSlotUtils.js
 */

rgNS.namespace('ezSlot.utils');
rgNS.ezSlot.utils = {
    round: function (number, precision) {
        let factor = Math.pow(10, precision);
        let tempNumber = number * factor;
        let roundedTempNumber = Math.round(tempNumber);
        return roundedTempNumber / factor;
    },
    currencyFormat: function (num) {
        return "$" + num.toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
    },
    displayNumber: function(num, precision) {
        return rgNS.ezSlot.utils.currencyFormat(rgNS.ezSlot.utils.round(num, precision));
    }
};
