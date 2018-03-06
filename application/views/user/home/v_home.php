<div id='home'>
    <h2><?= $title ?></h2>
    <div v-if='seen' v-html='message'></div>

</div>

<script>

    <?php if(isset($username)) : ?>

        let user = "<?= $username ?>";
        let home = new Vue({
            el: '#home',
            data: {
                message : `<p>selamat datang `+user+`</p>`,
                seen : true
            }
        });

    <?php else : ?>

        let home = new Vue({
            el : '#home',
            data : {
                message : '',
                seen : false
            }
        });

    <?php endif; ?>
</script>