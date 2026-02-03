document.addEventListener('DOMContentLoaded', function() {
    // Preview modal functionality
    const previewModal = document.getElementById('preview-modal');
    const closeModalBtn = previewModal?.querySelector('.close-modal');
    
    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', () => {
            previewModal.style.display = 'none';
        });
    }
    
    if (previewModal) {
        previewModal.addEventListener('click', (e) => {
            if (e.target === previewModal) {
                previewModal.style.display = 'none';
            }
        });
    }
    
    // Preview certificate function (for modal preview)
    window.previewCertificate = function(fileUrl) {
        const previewModal = document.getElementById('preview-modal');
        const previewContent = document.getElementById('preview-content');
        
        // Check file type
        const isImage = /\.(jpg|jpeg|png|gif)$/i.test(fileUrl);
        const isPDF = /\.pdf$/i.test(fileUrl);
        
        if (isImage) {
            previewContent.innerHTML = `
                <img id="preview-image" src="${fileUrl}" alt="Preview Sertifikat">
            `;
        } else if (isPDF) {
            previewContent.innerHTML = `
                <iframe src="${fileUrl}" width="100%" height="600px"></iframe>
            `;
        } else {
            previewContent.innerHTML = `
                <div class="error-message">
                    <i class="fas fa-exclamation-circle"></i>
                    Format file tidak didukung untuk preview
                </div>
            `;
        }
        
        previewModal.style.display = 'flex';
    };
    
    // Add click event to preview buttons (if using JavaScript preview)
    document.querySelectorAll('.btn-preview[target="_blank"]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            // If it's already a link with target="_blank", let it work normally
            // Otherwise, we could override with modal preview
        });
    });
    
    // Form validation for NIM input
    const nimInput = document.getElementById('nim-input');
    if (nimInput) {
        nimInput.addEventListener('input', function() {
            // Only allow numbers
            this.value = this.value.replace(/\D/g, '');
            
            // Limit to 10 digits
            if (this.value.length > 10) {
                this.value = this.value.slice(0, 10);
            }
        });
    }
});