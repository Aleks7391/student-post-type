jQuery(document).ready(function () {
	jQuery('.ag_status_meta_admin').each(function () {
		jQuery(this).val(this.checked);

		let post_id_text = jQuery(this).parent().parent().attr('id');

		let post_id = post_id_text.replace(/^\D+/g, '');
		jQuery(this).change(function () {
			jQuery.ajax({
				type: "POST",
				url: myAjax.ajaxurl,
				data: { action: 'ag_update_active_status', post_id: post_id },
			});
		})
	})
})