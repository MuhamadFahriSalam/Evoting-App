import { Html5QrcodeScanner } from "html5-qrcode";

document.addEventListener("DOMContentLoaded", () => {

    const reader = document.getElementById("reader");

    if (!reader) return;

    const scanner = new Html5QrcodeScanner(
        "reader",
        {
            fps: 10,
            qrbox: 250,
        }
    );

    scanner.render(
        (decodedText) => {
            window.location.href = decodedText;
        },
        () => {}
    );
});