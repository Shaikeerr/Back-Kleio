let calendar_number = document.querySelectorAll('.calendar__number')

calendar_number.forEach((number) => {
    number.addEventListener('click', (event) => {
        // Remove the class from all elements
        calendar_number.forEach((element) => {
            element.classList.remove('calendar__selected');
        });

        // Add the class only to the clicked element
        event.target.classList.add('calendar__selected');
    });
});





