/** Change the acction attrib. in 'add_to_order_form' form */
function updateAddList() {
    document.getElementById('new_order_form').action = "/admin/comandas/updateAddList";
}

// Reset New Order form
function resetOrder() {
    document.getElementById("new_order_form").action = "/orders/order/resetOrder";
}

// Save a new order
function saveNewOrder() {
    document.getElementById("new_order_form").action = "/orders/order/save";
}

/** Change action attribute in order view when click 'update' button */
function changeActionShowOrderForm() {         
    let formElement = document.getElementById('show_order_form')

    formElement.action = "/admin/comandas/update";
    formElement.submit();
}

export { updateAddList, resetOrder, saveNewOrder, changeActionShowOrderForm };