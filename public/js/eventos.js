"use strict"; 

/**
 * This function updates the text of an HTML element based on the value of a sibling element.
 */
function finishDish() {   
    let originalText = document.getElementById(this.id).parentElement.firstElementChild.value;

    // Capitalize the first letter
    originalText = originalText.charAt(0).toUpperCase() + originalText.slice(1);
    
    let strikedText = "<del>" + originalText + "</del>";
    let finishedValue = document.getElementById(this.id).previousElementSibling.value;
    let dish = document.getElementById(this.id);

    dish.innerHTML = finishedValue == 1 ?  originalText : strikedText;   
}


/**
 * The function toggles the value of a checkbox input's previous sibling input between 0 and 1.
 */
function setFinishDishValue() {
    let finishedValue = document.getElementById(this.id).previousElementSibling;
    finishedValue.value = finishedValue.value == 1 ?  0 : 1;
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


/** Reset New Order form */
function resetOrder() {
    document.getElementById("new_order_form").action = "/orders/index.php"
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
    
    
    /** Reset New Order form */
    let newOrderButton = document.getElementById('new_order_button');

    if(newOrderButton) {           
        newOrderButton.addEventListener("click", resetOrder);
    }
}
