/*
    ezsNS used for ezSlot application nameSpacing

    file name: ezSlotNS.js
 */
if (typeof ezsNS === 'undefined') {
    var ezsNS = {
        namespace: function() {
            let a = arguments, o = null, i, j, d;
            for (i = 0; i < a.length; i++) {
                d = a[i].split(".");
                o = this;
                for (j = 0; j < d.length; j++) {
                    o[d[j]] = o[d[j]] || {};
                    o = o[d[j]];
                }
            }
            return o;
        }
    };
}


