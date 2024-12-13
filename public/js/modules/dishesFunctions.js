/**
 * The function marks completed items orders as finished by striking through their original text.
 */
function testDishesStriked() {    
    let itemsFinished = document.getElementsByClassName("item_finished");
    let finished = document.getElementsByClassName("finished");

    for (let index = 0; index < itemsFinished.length; index++) {        
        if(itemsFinished[index].value == 1) finished[index].setAttribute("class", "finished lineThrough");                 
    }
}

/**
 * This function updates the text of an HTML element based on the value of a sibling element.
 */
function finishDish() {       
    if(this.className === "finished") {
        document.getElementById(this.id).setAttribute("class", "finished lineThrough");
    }
    else {
        document.getElementById(this.id).setAttribute("class", "finished");
    }           
}

/**
 * The function toggles the value of a checkbox input's previous sibling input between 0 and 1.
 */
function setFinishDishValue() {
    let finishedValue = document.getElementById(this.id).previousElementSibling;
    finishedValue.value = finishedValue.value == 1 ?  0 : 1;
}

export {testDishesStriked, finishDish, setFinishDishValue};