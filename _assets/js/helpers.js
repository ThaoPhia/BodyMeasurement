/* Convert the value from pounds to kilograms */
function lbsTokg(valNum) {
    //console.log("Lbs: "+valNum+" to kg: "+(valNum / 2.2046).toFixed(2));
    if(valNum)
        return (valNum / 2.2046).toFixed(2);
  return 0;
} 
/* Convert the value from pounds to kilograms */
function kgToLbs(valNum) {
    //console.log("Kg: "+valNum+" to Lbs: "+(valNum * 2.2046).toFixed(2));
    if(valNum)
      return (valNum * 2.2046).toFixed(2);
    return 0; 
}