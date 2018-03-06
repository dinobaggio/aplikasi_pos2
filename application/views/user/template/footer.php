    
    
    <script>
    notif_keranjang();
        function logout () {
            localStorage.removeItem('keranjang');
            window.open("<?= base_url('user/logout') ?>", "_self");
        }

        function notif_keranjang () {
            let el_tombol_keranjang = $('#tombol_keranjang');
            let keranjang = localStorage.keranjang;
            if(keranjang != null) {
                if (keranjang[0] == '[' && keranjang[keranjang.length-1] == ']') {
                    keranjang = JSON.parse(keranjang);
                    let filter = keranjang.filter(function (keranjang) {
                        return keranjang != null;
                    });
                    el_tombol_keranjang.html("Keranjang Barang ("+filter.length+")");
                } else {
                    el_tombol_keranjang.html("Keranjang Barang");
                }
            } else {
                el_tombol_keranjang.html("Keranjang Barang");
            }

        }
    </script>
    </body>
</html>