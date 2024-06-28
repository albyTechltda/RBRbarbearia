document.addEventListener('DOMContentLoaded', function() {
    const clienteTab = document.getElementById('cliente-tab');
    const cabeleireiroTab = document.getElementById('cabeleireiro-tab');
    const clienteForm = document.getElementById('cliente-form');
    const cabeleireiroForm = document.getElementById('cabeleireiro-form');
    const photoUpload = document.getElementById('foto-upload');
    const photoPreview = document.getElementById('photo-preview');

    clienteTab.addEventListener('click', function(event) {
        event.preventDefault();
        clienteTab.classList.add('active');
        cabeleireiroTab.classList.remove('active');
        clienteForm.style.display = 'block';
        cabeleireiroForm.style.display = 'none';
    });

    cabeleireiroTab.addEventListener('click', function(event) {
        event.preventDefault();
        cabeleireiroTab.classList.add('active');
        clienteTab.classList.remove('active');
        cabeleireiroForm.style.display = 'block';
        clienteForm.style.display = 'none';
    });

    photoUpload.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                photoPreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
});

