<div>
    <div x-data="signaturePad(@entangle($attributes->wire('model')))">
        <label for="company" class="block text-sm font-medium text-gray-700">Signature:</label>
        <canvas x-ref="signature_canvas" class="border rounded shadow"></canvas>
        <a href="#" class="text-sm" x-on:click.prevent="clear()">Clear</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/signature_pad@4.0.0/dist/signature_pad.umd.min.js"></script>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('signaturePad', (value) => ({
                signaturePadInstance: null,
                value: value,
                init() {
                    this.signaturePadInstance = new SignaturePad(this.$refs.signature_canvas);
                    this.signaturePadInstance.addEventListener("endStroke", () => {
                        this.value = this.signaturePadInstance.toDataURL('image/png');
                    });
                },
                clear() {
                    this.signaturePadInstance.clear();
                    this.value = null;
                }
            }))
        })
    </script>
</div>
