import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

// import './qr-scanner';
import './camera-scanner';

// QR Code
import QRCode from 'qrcode';

window.renderReceiptQr = async function (img, url) {
    try {
        img.src = await QRCode.toDataURL(url, {
            width: 520,
            margin: 3,
            errorCorrectionLevel: 'M',
        });
    } catch (e) {
        console.error('QR gagal dibuat', e);
    }
};