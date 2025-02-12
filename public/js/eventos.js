import { testDishesStriked, finishDish, setFinishDishValue, setAvailableDisheOnEditView, showEmoji } from "./modules/dishesFunctions.js";
import { setDateMinAttributeOnForm } from "./modules/datePickerFunctions.js";
import { updateAddList, resetOrder, saveNewOrder, changeActionShowOrderForm } from "./modules/orderFunctions.js";

"use strict"; 

window.onload = function() { 
    /** Function to manage emojis in dishes categories */
	showEmoji();
           
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


    /* Selects all elements with the class name 'show_password'
	and adds an event listener to them. It then checks if there are any elements found
	with that class using `if(showPasswordChars.length > 0)`. */
	let showPasswordChars = document.querySelectorAll('.show_password');

	if(showPasswordChars.length > 0) {
		showPasswordChars.forEach(showPasswordChar => {
			showPasswordChar.addEventListener('click', () => {				
				let input = showPasswordChar.parentNode.previousElementSibling.querySelector('input');
				if(input.type == 'password') {
					input.type = 'text';
					showPasswordChar.src = '/images/eye_closed.svg';
				} else {
					input.type = 'password';
					showPasswordChar.src = '/images/eye.svg';
				}
			});
		});
	}
    
    /** Set a dishe available when click checkbox on edit dishe view */
    const checkboxAvailableDishe = document.querySelector('#available');
    if(checkboxAvailableDishe) checkboxAvailableDishe.addEventListener('click', setAvailableDisheOnEditView);
}