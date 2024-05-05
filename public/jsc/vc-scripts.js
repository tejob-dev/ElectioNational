jQuery( document ).ready(
	function ($) {
		function lizrOnSetIconSizeValue($el) {
			var $parent      = $el.parents( '.lizr-advanced-size-wrapper' ).first();
			var $sizeEl      = $parent.find( 'input[name="lizr-size-number"]' ).first();
			var $size        = $sizeEl.val();
			var $measurement = $parent.find( 'select[name="lizr-size-measurement"]' ).first().val();

			if ($measurement === '%' && Math.abs( $size ) > 100) {
				$size = 100;
				$sizeEl.val( $size );
			}

			$( $parent ).find( '.lizr-vc-size' ).first().val( $size + '|' + $measurement )
		}

		$( document ).on(
			"change",
			'.lizr-advanced-size-wrapper input[name="lizr-size-number"]',
			function () {
				lizrOnSetIconSizeValue( $( this ) );
			}
		)

		$( document ).on(
			"change",
			'.lizr-advanced-size-wrapper select[name="lizr-size-measurement"]',
			function () {
				lizrOnSetIconSizeValue( $( this ) );
			}
		)
	}
);
