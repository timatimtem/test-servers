<?php get_header(); ?>


<div class="modal-wrap">
    <div id="id01" class="modal">

        <form class="modal-content animate" " action="<?php echo get_template_directory_uri();?>/mail.php" method="post">

            <div class="container">

                <a href="/servers">
                    <img src="http://155.94.131.122/servers/wp-content/themes/blazing-servers/img/logoblue.png"
                         alt="servers" style="
      top: -24px;
    position: relative;
    display: block;
    width: 150px;
    margin: 0 auto;">
                </a>

<!--                <h4>Sign Up</h4>-->

                <label for="uname"><b>Name</b></label>
                <input type="text" placeholder="Name" name="username" required>

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Password" name="password" required>
                <input type="text" name="data[url][success]" value="http://155.94.131.122/servers" class="hidden">
                <input type="text" name="data[text][pending]" value="Signing In" class="hidden">


                <label for="psw-2"><b>Repeat Password</b></label>
<!--                <input type="password" placeholder="Repeat Password" name="psw-2" >-->


                <a href="" class="forgot"> Forgot password?</a>


                <div class="btn-wrap">
                    <button type="submit" value="Sign I">Sign Up</button>

                    <div style="margin-bottom:10px;text-align: center; color: #8e8e8e;font-size:11px;font-family: MetropolisMedium, sans-serif">
                        or
                    </div>
                    <button onclick="window.location.href='/servers/login/'" value="Sign In" class="secondary">Sign In
                    </button>
                </div>


            </div>


        </form>
    </div>
</div>

<?php the_post() ?>
<?php the_content(); ?>


<?php get_footer(); ?>




