<?php if ( ! is_page_template( 'template-builder.php' ) ) { ?>
		</div>
	</div>
</main>
<?php } ?>

<footer class="footer">
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<?php dynamic_sidebar( 'footer-left' ); ?>
			</div>

			<div class="col-sm-4">
				<?php dynamic_sidebar( 'footer-middle' ); ?>
			</div>

			<div class="col-sm-4">
				<?php dynamic_sidebar( 'footer-right' ); ?>
			</div>
		</div>
	</div>

	<div class="foot">
		<div class="container">
			<div class="row">
				<div class="col-xs-12">
					<p>
						<?php echo get_theme_mod( 'footer_text', noozbeat_get_default_footer_text() ); ?>
					</p>

				</div>
			</div>
		</div>
	</div>
</footer>

</div> <!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
