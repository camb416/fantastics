<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package fantastics
 */

?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer" role="contentinfo">



		<div class="site-info">
			<!--<a href="<?php //echo esc_url( __( 'https://wordpress.org/', 'fantastics' ) ); ?>"><?php //printf( esc_html__( 'Proudly powered by %s', 'fantastics' ), 'WordPress' ); ?></a>
			<span class="sep"> | </span>
			<?php // printf( esc_html__( 'Theme: %1$s by %2$s.', 'fantastics' ), 'fantastics', '<a href="http://underscores.me/" rel="designer">Underscores.me</a>' ); ?>
		</div><!-- .site-info -->
            <a class="footerlogo" href="<?php echo site_url(); ?>" rel="home">Fantastics</a>
			<?php wp_nav_menu( array( 'theme_location' => 'footer-menu' ) ); ?>

            <form role="search" method="get" class="search-form" action="/">
                <label>
                    <span class="screen-reader-text">Search for:</span>
                    <input type="search" class="search-field" placeholder="Search …" value="" name="s">
                </label>
                <input type="submit" class="search-submit" value="Search">
            </form>


	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>
<!-- Go to www.addthis.com/dashboard to customize your tools --> <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-54343ae2777014ef"></script>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-1540197-3', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>
