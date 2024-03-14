let creneau = document.querySelectorAll('.creneau__button');

creneau.forEach((creneau) => {
    creneau.addEventListener('click', (event) => {
        // Remove the class from all elements
        creneau.forEach((element) => {
            element.classList.remove('creneau__selected');
        });

        // Add the class only to the clicked element
        event.target.classList.add('creneau__selected');
    }
    );
}
);