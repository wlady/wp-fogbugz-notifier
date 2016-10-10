		<div class="wrap ">
			<div id="icon-options-general" class="icon32"><br /></div>
			<h2><?php _e( 'FogBugz Update Notifier' , 'fogbugz-notifier' ); ?></h2>
			<form action="options.php" method="post">
				<?php settings_fields ( 'fogbugz-notifier' ); ?>
				<?php if ( ! empty ( $this->options ) ) : // Start option check. Don't show most of the form if there are no options in the db ?>
				<h3><?php _e( 'FogBugz Notifier Options' , 'fogbugz-notifier' ); ?></h3>
				<p><?php _e( 'If not empty "X-FogBugz-Case: NNN" header will be added to update notification email.' , 'fogbugz-notifier' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php _e( 'FogBugz Case' , 'fogbugz-notifier' ); ?>
						</th>
						<td>
							<input type="text" name="fogbugz-notifier[fogbugz-notifier-case]" value="<?php echo $this->get_option ( 'fogbugz-notifier-case' ); ?>" size="100" />
						</td>
					</tr>
				</table>

				<h3><?php _e( 'FogBugz Notifier Plugin Options' , 'fogbugz-notifier' ); ?></h3>
				<p><?php _e( 'Leave this field empty to disable check updates.' , 'fogbugz-notifier' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Plugin Repository' , 'fogbugz-notifier-repository' ); ?>
						</th>
						<td>
							<input type="text" name="fogbugz-notifier[fogbugz-notifier-repository]" value="<?php echo $this->get_option ( 'fogbugz-notifier-repository' ); ?>" size="100" />
						</td>
					</tr>
				</table>

				<?php endif; // End Option Check ?>

				<h3><?php _e( 'Resets' , 'fogbugz-notifier' ); ?></h3>
				<p><?php _e( 'These options will allow you to purge cache or to revert the options back to their defaults or to remove the options from the database for a clean uninstall.' , 'fogbugz-notifier' ); ?></p>
				<table class="form-table">
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Reset to Defaults' , 'fogbugz-notifier' ); ?>
						</th>
						<td>
							<select name="fogbugz-notifier[default]">
								<option value="false" selected="selected"><?php _e( 'false' , 'fogbugz-notifier' ); ?></option>
								<option value="true"><?php _e( 'true' , 'fogbugz-notifier' ); ?></option>
							</select>
						</td>
					</tr>
					<tr valign="top">
						<th scope="row">
							<?php _e( 'Delete Options for a Clean Uninstall' , 'fogbugz-notifier' ); ?>
						</th>
						<td>
							<select name="fogbugz-notifier[delete]">
								<option value="false" selected="selected"><?php _e( 'false' , 'fogbugz-notifier' ); ?></option>
								<option value="true"><?php _e( 'true' , 'fogbugz-notifier' ); ?></option>
							</select>
						</td>
					</tr>
				</table>

				<p class="submit">
					<input type="submit" class="button-primary" value="<?php _e( 'Save Changes' , 'fogbugz-notifier' ) ?>" />
				</p>
			</form>
		</div>
