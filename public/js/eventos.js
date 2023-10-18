"use strict"; 

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


/** Reset New Order form */
function resetOrder() {
    document.getElementById("new_order_form").action = "/orders/index.php"
}

/** Disable date before current day in forms with 'input type date' fields */
function setDateMinAttributeOnForm() {
    const today = new Date();
    const minDate = today.toISOString().split('T')[0];   

    // Set the min attribute of the input field to today's date
    document.querySelector('input[type="date"]').min = minDate;    
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
    if(newOrderButton) newOrderButton.addEventListener("click", resetOrder);

    /** Disable date before current day in forms with 'input type date' fields */
    let dateElement = document.querySelector('input[type="date"]');
    if (dateElement) setDateMinAttributeOnForm();
}
