var editButtons = document.querySelectorAll(".edit-button");


editButtons.forEach((button, i) => {
    // button.addEventListener("click", () => {
        
    // });
    button.addEventListener("click", testFunction);
});



function testFunction(){
    alert("Kliknięty!");
    var elem = document.getElementByID("edit-button");
    elem.value = "Zapisz";
}

document.getElementsByClassName("edit-button").addEventListener("click", function(){
    this.innerText = "Save";
})

