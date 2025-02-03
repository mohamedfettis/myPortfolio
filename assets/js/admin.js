document.addEventListener('DOMContentLoaded', function() {
    // Nettoyer les champs après soumission réussie
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const formData = new FormData(form);
            
            // Stocker les fichiers sélectionnés pour les réutiliser après le reset
            const fileInputs = form.querySelectorAll('input[type="file"]');
            const files = {};
            fileInputs.forEach(input => {
                files[input.name] = input.files[0];
            });
            
            fetch(form.action, {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(html => {
                // Si la soumission est réussie (vérifier la présence du message de succès)
                if (html.includes('succès')) {
                    // Réinitialiser le formulaire
                    form.reset();
                    
                    // Restaurer les fichiers sélectionnés
                    fileInputs.forEach(input => {
                        const file = files[input.name];
                        if (file) {
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(file);
                            input.files = dataTransfer.files;
                        }
                    });
                    
                    // Afficher un message de succès
                    showNotification('Opération réussie!', 'success');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Une erreur est survenue', 'error');
            });
        });
    });
    
    // Notification stylée
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        document.body.appendChild(notification);
        
        // Animation d'entrée
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
            notification.style.opacity = '1';
        }, 100);
        
        // Disparition après 3 secondes
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            notification.style.opacity = '0';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Preview des images et vidéos
    const imageInputs = document.querySelectorAll('input[type="file"]');
    imageInputs.forEach(input => {
        input.accept = "image/*,video/mp4,video/avi,video/mov";
        input.addEventListener('change', function(e) {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                const preview = this.parentElement.querySelector('.image-preview');
                
                reader.onload = function(e) {
                    if (!preview) {
                        const img = document.createElement('img');
                        img.className = 'image-preview';
                        img.src = e.target.result;
                        img.style.maxWidth = '200px';
                        img.style.marginTop = '10px';
                        input.parentElement.appendChild(img);
                    } else {
                        preview.src = e.target.result;
                    }
                }
                
                reader.readAsDataURL(file);
            }
        });
    });
});
