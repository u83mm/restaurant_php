"use strict"; 

/**
 * This function updates the text of an HTML element based on the value of a sibling element.
 */
function finishDish() {   
    let originalText = document.getElementById(this.id).parentElement.firstElementChild.value;
    let strikedText = "<del>" + originalText + "</del>";
    let finishedValue = document.getElementById(this.id).previousElementSibling.value;
    let dish = document.getElementById(this.id);

    finishedValue == 1 ?  dish.innerHTML = originalText : dish.innerHTML = strikedText;   
}

/**
 * The function toggles the value of a checkbox input's previous sibling input between 0 and 1.
 */
function setFinishDishValue() {
    let finishedValue = document.getElementById(this.id).previousElementSibling;
    finishedValue.value == 1 ? finishedValue.value = 0 : finishedValue.value = 1;
}

/**
 * The function marks completed items orders as finished by striking through their original text.
 */
function testDishesStriked() {    
    let itemsFinished = document.getElementsByClassName("item_finished");    

    for (let index = 0; index < itemsFinished.length; index++) {
        let originalText =  itemsFinished[index].previousElementSibling.value;
        let strikedText = "<del>" + originalText + "</del>";

        if(itemsFinished[index].value == 1) itemsFinished[index].nextElementSibling.innerHTML = strikedText; 
    }
}

window.onload = function() {
    /** Test for striked dishes */
    testDishesStriked();


    /** Add event "click" to dishes in 'Comandas' view */
	let finishCheck = document.querySelectorAll("div.finished");
        
    if(finishCheck) {
        for (let index = 0; index < finishCheck.length; index++) {               
            finishCheck[index].addEventListener("click", finishDish);
            finishCheck[index].addEventListener("click", setFinishDishValue);
        }
    }
}
