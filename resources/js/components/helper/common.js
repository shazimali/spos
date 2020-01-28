const addCommas = (num) => {
    var str = num.toString().split('.');
    if (str[0].length >= 4) {
        //add comma every 3 digits befor decimal
        str[0] = str[0].replace(/(\d)(?=(\d{3})+$)/g, '$1,');
    }
    /* Optional formating for decimal places
    if (str[1] && str[1].length >= 4) {
        //add space every 3 digits after decimal
        str[1] = str[1].replace(/(\d{3})/g, '$1 ');
    }*/
    return str.join('.');
}

const round = (num) => { 
    
   return Math.round(num*2)/2
 }

 export {addCommas,round};