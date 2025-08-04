window.document.addEventListener('DOMContentLoaded', function a(){
    document.getElementById('image').addEventListener('change', function(event) {
            const arquivo = event.target.files[0];
            const preview = document.getElementById('preview');

            if (arquivo) {
                const leitor = new FileReader();

                leitor.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                leitor.readAsDataURL(arquivo); // converte a imagem para base64
            } else {
                preview.style.display = 'none';
                preview.src = '#';
            }
        });
});