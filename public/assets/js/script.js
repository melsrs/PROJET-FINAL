
document.addEventListener('DOMContentLoaded', function() {
    const deleteForms = document.querySelectorAll('.delete-form');

    deleteForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            if (confirm('Êtes-vous sûr de vouloir supprimer cet article ?')) {
                const articleId = form.dataset.articleId;
                const formData = new FormData(form);

                const url = '/dashboardAdmin/deleteArticle';
                fetch(url, {
                        method: 'POST',
                        body: formData
                    })

                    .then(response => response.json()) // Assurez-vous que le serveur renvoie du JSON
                    .then(data => {
                        if (data.success) {
                            // Supprimer l'article du DOM
                            const articleElement = document.getElementById('article-' + articleId);
                            articleElement.remove();
                            alert('Article supprimé avec succès.');
                        } else {
                            alert('Erreur: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la suppression:', error);
                        alert('Une erreur est survenue.');
                    });
            }
        });
    });
});