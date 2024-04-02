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


/**
 * Functions in new order view
 * 
 *  - resetOrder()
 *  - saveNewOrder()
 */

// Reset New Order form
function resetOrder() {
    document.getElementById("new_order_form").action = "/orders/order/resetOrder";
}

// Save a new order
function saveNewOrder() {
    document.getElementById("new_order_form").action = "/orders/order/save";
}


/** Disable date before current day in forms with 'input type date' fields */
function setDateMinAttributeOnForm() {
    const today = new Date();
    let day = today.getDate();
    let mounth = today.getMonth() + 1;        
    
    // Add "0" before current day and month if they have only one digit (ex. "2" will be "02")
    if(day.toString().length == 1) day = "0" + day;
    if(mounth.toString().length == 1) mounth = "0" + mounth;
        
    const minDate = today.getFullYear() + "-" + mounth + "-" + day;   
        
    // Set the min attribute of the input field to today's date
    document.querySelector('input[type="date"]').min = minDate;    
}

/** Change action attribute in order view when click 'update' button */
function changeActionShowOrderForm() {         
    let formElement = document.getElementById('show_order_form')

    formElement.action = "/admin/comandas/update";
    formElement.submit();
}

/** Change the acction attrib. in 'add_to_order_form' form */
function updateAddList() {
    document.getElementById('new_order_form').action = "/admin/comandas/updateAddList";
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
        
    /** Reset new order form */
    let newOrderButton = document.getElementById('new_order_button');
    if(newOrderButton) newOrderButton.addEventListener("click", resetOrder);
    
    /** Save new order form */
    let sendOrderButton = document.getElementById('send_order_button');
    if(sendOrderButton) sendOrderButton.addEventListener("click", saveNewOrder);

    /** Disable date before current day in forms with 'input[type="date"]' fields 
     *  and class 'blockBefore'
     */    
    let dateElement = document.querySelector('.blockBefore');
    if (dateElement) setDateMinAttributeOnForm();

    /** Change the action attribute in show order form */
    let buttonElement = document.querySelector('#update_button');

    if(buttonElement) {        
        buttonElement.addEventListener("click", changeActionShowOrderForm);
    }

    /** Change the acction attrib. in 'add_to_order_form' form */
    let buttonElementUpdateAddList = document.querySelector('#update_add_to_order');

    if(buttonElementUpdateAddList) buttonElementUpdateAddList.addEventListener('click', updateAddList);
}
