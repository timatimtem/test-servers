



<?php get_header(); ?>


<div class="modal-wrap">
    <div id="id01" class="modal">

        <form class="modal-content animate" action="<?php echo get_template_directory_uri();?>/SignIn.php" method="post">
<!--            <img src="--><?php //echo get_template_directory_uri();?><!--/img/logo@2x.png" alt="servers">-->

            <div class="container">
                <a href="/servers">
                    <img src="http://155.94.131.122/servers/wp-content/themes/blazing-servers/img/logoblue.png"
                         alt="servers" style="
       top: -24px;
    position: relative;
    display: block;
    width: 150px;
    margin: 0 auto;"></a>
<!--                <h4>Sign In</h4>-->

                <label for="username"><b>Username</b></label>
                <input type="text" placeholder="Enter Username" name="username" required>

                <label for="password"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>
                <a href="" class="forgot"> Forgot password?</a>


                <div class="btn-wrap">
                    <button type="submit" value="Sign I">Sign In</button>

                    <div style="margin-bottom:10px;text-align: center; color: #8e8e8e;font-size:11px;font-family: MetropolisMedium, sans-serif">or</div>
                    <button value="Sign I" class="secondary" onclick="window.location.href='/servers/register/'">Sign Up</button>
                </div>
            </div>


        </form>
    </div>
</div>

<?php the_post() ?>
<?php the_content(); ?>


<?php get_footer();?>




