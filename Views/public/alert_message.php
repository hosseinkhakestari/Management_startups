<?php
if (!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['message']) && isset($_SESSION['show_message']) && $_SESSION['show_message'] == 1){
    ?>
    <script>
        var message = "<?php echo $_SESSION['message'][0]; ?>";
        $.alert({
            title: '',
            content: '<p style="text-align: right;">'+ message +'</p>',
            buttons: {
                باشه:function () {
                }
            }
        });
    </script>
    <?php
    unset($_SESSION["show_message"]);
}
?>