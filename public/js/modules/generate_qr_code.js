// Generate QR Code
document.addEventListener('DOMContentLoaded', function() {
    // Replace with your actual menu page URL
    const menuUrl = window.location.origin + '/menu';
    
    // Generate QR code
    QRCode.toCanvas(document.getElementById('qrcode'), menuUrl, {
        width: 180,
        margin: 1,
        color: {
            dark: '#000000',
            light: '#FFFFFF'
        }
    }, function(error) {
        if (error) console.error(error);
        console.log('QR code generated successfully!');
    });
    
    // Optional: Add analytics for QR code scans
    document.getElementById('qrcode').addEventListener('click', function() {
        // Track QR code click in your analytics
        console.log('QR code clicked - potential scan');
    });
});