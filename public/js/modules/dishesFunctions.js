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

/**
 * Sets the value of an element to 1 if it is checked,
 * and 0 if it is not checked.
 */
function setAvailableDisheOnEditView() {    
    this.value = this.checked ? 1 : 0;   
}

/**
 * The function `showEmoji` populates an emoji container with emoji options that can be selected and
 * displayed in an emoji field.
 */
function showEmoji() {
    const emojis = ['🥗','🥘', '🍟', '🥩', '🍹', '🍦','🍝', '🐟', '🍺', '🍾', '🍷', '☕️', '🍮', '🍜', '🧁']; // Add more emojis as needed
    const emojiContainer = document.getElementById('emoji-container');
    const emojiField = document.getElementById('dish_menu_menuEmoji');

    if(emojiContainer) {
        // Populate the emoji container with emoji options
        emojis.forEach(emoji => {
            const emojiOption = document.createElement('span');
            emojiOption.classList.add('emoji-option');
            emojiOption.textContent = emoji;
            emojiOption.addEventListener('click', () => {
                emojiField.value = emoji;
            });
            emojiContainer.appendChild(emojiOption);
        });
    }
}

export { testDishesStriked, finishDish, setFinishDishValue, setAvailableDisheOnEditView, showEmoji };