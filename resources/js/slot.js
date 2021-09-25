//Slot

setInterval(() => {
    document.querySelectorAll('.gui-slot, .gui-large-slot').forEach(e => {
        const elements = e.querySelectorAll('.gui-slot-entry');
        if (elements.length > 0) {
            const index = Array.from(elements).findIndex(e => e.style.display === "block");
            if (index >= 0 && !elements[index].matches(':hover')) {
                elements[index].style.display = "none";
                elements[(index + 1) % elements.length].style.display = "block";
            }
        }
    });
}, 1000);
