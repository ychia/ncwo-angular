jQuery.fn.dataTableExt.oSort['title-date-asc']  = function(x,y) {
    var ax = x.split("-");
    var a = ( ax[2]+ax[0]+ax[1] ) * 1;   
    var by = y.split("-");
    var b = ( by[2]+by[0]+by[1] ) * 1;
    return ((a < b) ? -1 : ((a > b) ?  1 : 0));
};
 
jQuery.fn.dataTableExt.oSort['title-date-desc'] = function(y,x) {
    var ax = x.split("-");
    var a = ( ax[2]+ax[0]+ax[1] ) * 1;   
    var by = y.split("-");
    var b = ( by[2]+by[0]+by[1] ) * 1;
    return ((a < b) ? -1 : ((a > b) ?  1 : 0));
};