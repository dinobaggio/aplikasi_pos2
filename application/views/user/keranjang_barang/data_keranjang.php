<span>

</span>
<script>
let keranjang = localStorage.keranjang;
let el_data_keranjang = document.getElementsByTagName('span')[0];
if (keranjang != null) {
    
    if (keranjang[0] == '[' && keranjang[keranjang.length-1] == ']') {
        el_data_keranjang.innerHTML = keranjang;
    } else {
        el_data_keranjang.innerHTML = 'false';
    }
} else {
    el_data_keranjang.innerHTML = 'false';
}

</script>