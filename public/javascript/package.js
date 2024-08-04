document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('container').addEventListener('click', function(event){
        if(event.target && event.target.id === 'addContainer') {
            const container = document.getElementById('container');
            const featureContainer = document.getElementById('featureContainer');
            
            // Clone the featureContainer
            const newFeatureContainer = featureContainer.cloneNode(true);

            // Clear the values in the cloned inputs
            newFeatureContainer.querySelectorAll('input').forEach((input, index) => {
                input.value = '';
                input.name = input.name.replace(/\d+/, container.children.length);
            });

            // Remove the ID from the cloned featureContainer's "+" button
            newFeatureContainer.querySelector('p#addContainer').remove();

            // Create and add "-" button to the cloned featureContainer
            const removeButton = document.createElement('p');
            removeButton.textContent = '-';
            removeButton.classList.add('cursor-pointer', 'text-2xl', 'font-bold');
            removeButton.addEventListener('click', function() {
                newFeatureContainer.remove();
            });

            // Clear the button container and add the "-" button
            const buttonContainer = newFeatureContainer.querySelector('.button-container');
            buttonContainer.innerHTML = '';
            buttonContainer.appendChild(removeButton);

            // Append the cloned featureContainer to the container
            container.appendChild(newFeatureContainer);
        }
    });
});


document.addEventListener('DOMContentLoaded', function () {
    const priceInput = document.getElementById('price');

    priceInput.addEventListener('input', function (e) {
        // Remove any non-numeric characters except the decimal point
        let value = e.target.value.replace(/[^0-9.]/g, '');

        // Ensure only one decimal point is allowed
        const parts = value.split('.');
        if (parts.length > 2) {
            value = parts[0] + '.' + parts.slice(1).join('');
        }

        // Reformat the value if necessary
        e.target.value = value;
    });
});
