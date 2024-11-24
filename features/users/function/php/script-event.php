<script>
    document.getElementById('event-type').addEventListener('change', function () {
    document.querySelectorAll('[id$="-options"]').forEach(function (el) {
        el.style.display = 'none';
    });

    const selectedEvent = this.value
        .toLowerCase()
        .replace(/ /g, '-') 
        .replace(/\//g, ''); 

    const selectedOptions = document.getElementById(selectedEvent + '-options');
    if (selectedOptions) {
        selectedOptions.style.display = 'block';
    }
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[id$="-options"]').forEach(function (el) {
        el.style.display = 'none';
    });

    document.getElementById('kiddie-party-package').addEventListener('change', function () {
        const selectedPackage = this.value;

        if (selectedPackage === 'Other-kiddie-party') {
            document.getElementById('Other-kiddie-party-options').style.display = 'block'; 
        } else {
            document.getElementById('Other-kiddie-party-options').style.display = 'none'; 
        }
    });

    document.getElementById('adult-birthday-package').addEventListener('change', function () {
        const selectedPackage = this.value;
        if (selectedPackage === 'Other-adult-birthday-party') {
            document.getElementById('Other-adult-birthday-party-options').style.display = 'block'; 
        } else {
            document.getElementById('Other-adult-birthday-party-options').style.display = 'none'; 
        }
    });

    document.getElementById('debut-packages').addEventListener('change', function () {
        const selectedPackage = this.value;
        if (selectedPackage === 'Other-debut') {
            document.getElementById('Other-adult-birthday-party-options').style.display = 'block'; 
        } else {
            document.getElementById('Other-adult-birthday-party-options').style.display = 'none'; 
        }
    });

    document.getElementById('wedding-package').addEventListener('change', function () {
        const selectedPackage = this.value;
        if (selectedPackage === 'Other-wedding') {
            document.getElementById('Other-wedding-options').style.display = 'block'; 
        } else {
            document.getElementById('Other-wedding-options').style.display = 'none'; 
        }
    });
    document.getElementById('christening-package').addEventListener('change', function () {
        const selectedPackage = this.value;
        if (selectedPackage === 'Other-christening') {
            document.getElementById('Other-christening-options').style.display = 'block'; 
        } else {
            document.getElementById('Other-christening-options').style.display = 'none'; 
        }
    });

    document.getElementById('despedida-package').addEventListener('change', function () {
        const selectedPackage = this.value;
        if (selectedPackage === 'Other-despedida') {
            document.getElementById('Other-despedida-options').style.display = 'block'; 
        } else {
            document.getElementById('Other-despedida-options').style.display = 'none'; 
        }
    });

    document.getElementById('christmas-party-package').addEventListener('change', function () {
        const selectedPackage = this.value;
        if (selectedPackage === 'Other christmas-year-end-party') {
            document.getElementById('Other-christmas-year-end-party').style.display = 'block'; 
        } else {
            document.getElementById('Other-christmas-year-end-party').style.display = 'none'; 
        }
    });

    


    
});



</script>