<?php
	$review_fields = get_post_meta( get_the_ID(), 'noozbeat_review_fields', true );
	$review_score  = get_post_meta( get_the_ID(), 'noozbeat_review_score', true );
?>
<?php if ( ! empty( $review_fields ) && ! empty( $review_score ) ): ?>
	<div class="entry-rating">
		<div class="entry-rating-final-score">
			<strong><?php echo esc_attr( $review_score ); ?></strong>

			<?php $score_text = get_post_meta( get_the_ID(), 'noozbeat_review_score_text', true ); ?>
			<?php if ( ! empty( $score_text ) ): ?>
				<span><?php echo esc_html( $score_text ); ?></span>
			<?php endif; ?>
		</div>

		<ul class="entry-rating-scores">
			<?php foreach( $review_fields as $field ): ?>
				<li class="entry-rating-score">
					<?php
						$max_score = apply_filters( 'noozbeat_max_review_score', 10 );
						$score     = round( ( 100 / $max_score ) * $field['score'] );
					?>
					<div class="entry-rating-score-bar" style="width: <?php echo esc_attr( $score ); ?>%;">
						<span class="entry-rating-score-name"><?php echo esc_html( $field['title'] ); ?></span>
						<span class="entry-rating-score-value"><?php echo esc_html( $field['score'] ); ?></span>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
<?php endif; ?>
