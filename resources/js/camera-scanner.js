import { Html5Qrcode, Html5QrcodeSupportedFormats } from 'html5-qrcode';

document.addEventListener('alpine:init', () => {
    window.Alpine.data('cameraScanner', ({ baseUrl }) => ({
        qr: null,
        cameras: [],
        index: 0,
        facing: '',        // 'user' | 'environment' | '' (tidak diketahui, mis. webcam laptop)
        running: false,
        busy: false,
        mirror: false,
        canRetry: true,
        handled: false,
        label: '',
        error: '',
        notice: '',
        reqId: 0,
        currentId: '',

        async init() {
            if (!window.isSecureContext || !navigator.mediaDevices?.getUserMedia) {
                this.canRetry = false;
                this.error = 'Kamera hanya bisa dipakai lewat HTTPS (atau localhost). Buka halaman lewat alamat https:// atau pakai input manual di bawah.';
                return;
            }
            this.qr = new Html5Qrcode('reader', {
                verbose: false,
                formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
            });
            window.addEventListener('pagehide', () => this.stop());

            await this.start({ facingMode: 'environment' }); // default: kamera belakang
            await this.loadCameras();
        },

        destroy() {
            this.stop();
        },

        /** Mengembalikan true jika kamera menyala. Gagal bila error atau tidak merespons dalam timeoutMs. */
        async start(cameraConfig, timeoutMs = 8000) {
            if (this.busy) return false;
            this.busy = true;
            this.error = '';
            this.notice = '';
            const id = ++this.reqId;

            const attempt = this.qr.start(
                cameraConfig,
                {
                    fps: 10,
                    qrbox: (w, h) => {
                        const s = Math.floor(Math.min(w, h) * 0.72);
                        return { width: s, height: s };
                    },
                },
                (text) => this.onScan(text),
                () => {}
            );

            let timer;
            const timeout = new Promise((_, reject) => {
                timer = setTimeout(() => reject(new Error('Timeout: kamera tidak merespons')), timeoutMs);
            });

            try {
                await Promise.race([attempt, timeout]);
                this.running = true;
                this.readSettings();
                return true;
            } catch (e) {
                this.running = false;
                this.error = this.explain(e);
                // Jika permintaan menggantung lalu berhasil belakangan, matikan agar tidak ada kamera "hantu".
                attempt.then(() => { if (this.reqId === id) return this.qr.stop(); }).catch(() => {});
                return false;
            } finally {
                clearTimeout(timer);
                this.busy = false;
            }
        },

        async stop() {
            try {
                if (this.qr && this.running) await this.qr.stop();
            } catch (e) {}
            this.running = false;
        },

        async loadCameras() {
            try {
                this.cameras = await Html5Qrcode.getCameras();
                this.readSettings();
            } catch (e) {
                this.cameras = [];
            }
        },

        /** Baca kamera yang sedang aktif: dipakai untuk label, efek cermin, dan indeks. */
        readSettings() {
            let s = {};
            try { s = this.qr.getRunningTrackSettings() || {}; } catch (e) {}

            this.currentId = s.deviceId || '';
            this.facing = s.facingMode === 'user' || s.facingMode === 'environment' ? s.facingMode : '';
            const cam = this.cameras.find((c) => c.id === s.deviceId);
            const name = (cam?.label || '').toLowerCase();
            const front = this.facing === 'user' || /front|depan|facetime/.test(name);
            const back = this.facing === 'environment' || /back|rear|belakang|environment/.test(name);

            this.mirror = front && !back; // pratinjau kamera depan dicerminkan agar natural
            this.label = front && !back ? 'Kamera depan' : back ? 'Kamera belakang' : (cam?.label || 'Kamera');

            const i = this.cameras.findIndex((c) => c.id === s.deviceId);
            if (i >= 0) this.index = i;
        },

        async flip() {
            if (this.busy || this.cameras.length < 2) return;

            const startIndex = this.index;
            const startId = this.currentId;
            await this.stop();

            // Coba kamera berikutnya satu per satu; lewati yang tidak merespons.
            for (let step = 1; step < this.cameras.length; step++) {
                const i = (startIndex + step) % this.cameras.length;
                if (await this.start(this.cameras[i].id, 6000)) {
                    this.index = i;
                    return;
                }
            }

            // Semua kamera lain gagal: kembali ke kamera semula.
            const back = await this.start(startId || { facingMode: 'environment' });
            if (back) this.notice = 'Kamera lain tidak dapat dibuka, kembali ke kamera semula.';
        },

        async retry() {
            await this.loadCameras();
            const cam = this.cameras[this.index];
            await this.start(cam ? cam.id : { facingMode: 'environment' });
        },

        async onScan(text) {
            if (this.handled) return;
            const token = (text || '').trim().split('/').filter(Boolean).pop();
            if (!token) return;
            this.handled = true;
            await this.stop();
            window.location.href = `${baseUrl}/${encodeURIComponent(token)}`;
        },

        explain(e) {
            const m = `${e?.name ?? ''} ${e?.message ?? e}`;
            if (/Timeout/i.test(m)) return 'Kamera tidak merespons. Mungkin kamera inframerah atau virtual. Coba kamera lain atau pakai input manual di bawah.';
            if (/NotAllowed|Permission/i.test(m)) return 'Izin kamera ditolak. Izinkan kamera di pengaturan situs pada browser, lalu coba lagi.';
            if (/NotFound|Requested device not found/i.test(m)) return 'Kamera tidak ditemukan di perangkat ini. Gunakan input manual di bawah.';
            if (/NotReadable|in use/i.test(m)) return 'Kamera sedang dipakai aplikasi lain. Tutup aplikasi itu, lalu coba lagi.';
            return 'Kamera tidak dapat dibuka. Coba lagi atau gunakan input manual di bawah.';
        },
    }));
});