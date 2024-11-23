document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('lookup').addEventListener('click', function() {
        const country = document.getElementById('country').value; 
        fetch(`world.php?country=${encodeURIComponent(country)}`) 
            .then(response => response.text()) 
            .then(data => {
                const resultDiv = document.getElementById('result');
                resultDiv.innerHTML = data; 
            })
            .catch(error => console.error('Error fetching data:', error));
    });
});