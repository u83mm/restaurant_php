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

export {setDateMinAttributeOnForm};