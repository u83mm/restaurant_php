"use strict"; 

/**
 * This function updates the text of an HTML element based on the value of a sibling element.
 */
function finishDish() {   
    let originalText = document.getElementById(this.id).parentElement.firstElementChild.value;
    let finishedValue = document.getElementById(this.id).previousElementSibling.value;

    if(finishedValue == 1) {
        document.getElementById(this.id).innerHTML = originalText;
    }
    else {
        document.getElementById(this.id).innerHTML = "<del>" + originalText + "</del>";
    }    
}

/**
 * The function toggles the value of a checkbox input's previous sibling input between 0 and 1.
 */
function setFinishDishValue() {
    let finishedValue = document.getElementById(this.id).previousElementSibling;
    finishedValue.value == 1 ? finishedValue.value = 0 : finishedValue.value = 1;
}

/**
 * The function marks completed coffee orders as finished by striking through their original text.
 */
function testDishesStriked() {    
    let itemsFinished = document.getElementsByName("coffees_finished[]");
    let originalText = "";   

    for (let index = 0; index < itemsFinished.length; index++) {
        originalText =  itemsFinished[index].previousElementSibling.value;
        if(itemsFinished[index].value == 1) itemsFinished[index].nextElementSibling.innerHTML = "<del>" + originalText + "</del>"; 
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
